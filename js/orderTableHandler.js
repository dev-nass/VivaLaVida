
let orderIdValue = '';
let transactionIdValue = '';
let guitarDetailsValue = '';
let quantityValue = '';
let totalPriceValue = '';

let orderDeletionObject = {};




$(document).ready(function () {
  const table = $('#orderTable').DataTable({
    responsive: true,
    search: {
      smart: true, // Enable smart search
    },
    columnDefs: [
      {
        targets: [0, 1, 2, 4, 5], // Target the 'ID' column (index starts from 0)
        searchable: true, // Make the ID column searchable
      },
      {
        targets: '_all', // Other columns
        searchable: false, // Ensure they remain searchable
      },
    ],
    initComplete: function () {
      // Custom search behavior
      var table = this.api();

      // Override the global search
      $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var searchTerm = table.search().toLowerCase();

        // Get the value of the ID column
        var idValue = data[0].toLowerCase(); // Assuming 'ID' is the first column

        // Prioritize ID column matching
        if (idValue.includes(searchTerm)) {
          return true;
        }

        // Fallback to the default global search
        return data.join(' ').toLowerCase().includes(searchTerm);
      });
    },
  });

  // Event delegation for buttons within the table
  $('#orderTable').on('click', '#select-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const orderIdInput = row.querySelector('th[order-id-col]').textContent.trim();
    const transactionIdInput = row.querySelector('td[order-transaction-id-col]').textContent.trim();
    const guitarDetailInput = row.querySelector('td[order-guitar-col]').textContent.trim();
    const quantityInput = row.querySelector('td[order-quantity-col]').textContent.trim();
    const totalPriceInput = row.querySelector('td[order-total-price-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-order-id]').value = orderIdInput;
    document.querySelector('input[data-transaction-id]').value = transactionIdInput;
    document.querySelector('input[data-guitar]').value = guitarDetailInput;
    document.querySelector('input[data-quantity]').value = quantityInput;
    document.querySelector('input[data-total-price]').value = totalPriceInput;

    // Optionally, display a success message or perform further actions
    // alert("Order Selected");
  });
});


document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const orderIdInput = document.querySelector('input[data-order-id]');
  const transactionIdInput = document.querySelector('input[data-transaction-id]');
  const guitarDetailInput = document.querySelector('input[data-guitar]');
  const quantityInput = document.querySelector('input[data-quantity]');
  const totalPriceInput = document.querySelector('input[data-total-price]');

  orderIdValue = orderIdInput.value.trim();
  transactionIdValue = transactionIdInput.value.trim();
  guitarDetailsValue = guitarDetailInput.value.trim();
  quantityValue = quantityInput.value.trim();
  totalPriceValue = totalPriceInput.value.trim();


  if (orderIdValue && transactionIdValue && guitarDetailsValue && quantityValue && totalPriceValue) {
    orderDeletionObject = {
      orderDetail: {
        orderId: orderIdValue,
        transactionId: transactionIdValue,
        guitarDetail: guitarDetailsValue,
        quantityValue: quantityValue,
        totalPrice: totalPriceValue,
      }
    }

    orderDeletion(orderDeletionObject);
  } else if (orderIdValue === '' && transactionIdValue === '' && guitarDetailsValue === '' && quantityValue === '' && totalPriceValue === '') {
    alert("No selected order");
  }
});


function orderDeletion(orderParameter) {
  // Responsible for archiving order's information
  const orderArchiving = new XMLHttpRequest();
  orderArchiving.open('POST', '../php/orderArchiving.php', true);
  orderArchiving.setRequestHeader('Content-Type', 'application/json');

  orderArchiving.onload = function () {
    if (orderArchiving.status >= 200 && orderArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", orderArchiving.responseText);

        const orderArchiving_response = JSON.parse(orderArchiving.responseText);
        if (orderArchiving_response.success) {
          alert("Order archived");
        } else {
          alert("No selected order");
          console.log("Archiving new ordder failed:", orderArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for order archiving side:', error);
      }
    } else {
      console.error('Error processing archiving:', orderArchiving.status);
    }
  };

  // Handle network errors
  orderArchiving.onerror = function () {
    console.error('Network error while archiving order');
  };

  // Send the `orderedDataParameter` array as JSON to the server
  orderArchiving.send(JSON.stringify(orderParameter));
}