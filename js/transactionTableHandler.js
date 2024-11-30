
let transactionIdValue = '';
let customerDetailValue = '';
let employeeIdValue = '';
let dateValue = '';
let paymentMethodValue = '';
let totalAmount = '';
let paidValue = '';
let changeValue = '';

let transactionDeletionObject = {};



$(document).ready(function () {
  const table = $('#transactionTable').DataTable({
    responsive: true,
    search: {
      smart: true, // Enable smart search
    },
    columnDefs: [
      {
        targets: '_all', // Other columns
        searchable: true, // Ensure they remain searchable
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
  $('#transactionTable').on('click', '#select-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const transactionIdInput = row.querySelector('th[transaction-id-col]').textContent.trim();
    const customerDetailInput = row.querySelector('td[customer-detail-col]').textContent.trim();
    const employeeIdInput = row.querySelector('td[employee-id-col]').textContent.trim();
    const transactionDateInput = row.querySelector('td[transaction-date-col]').textContent.trim();
    const paymentMethodInput = row.querySelector('td[payment-method-col]').textContent.trim();
    const totalAmountInput = row.querySelector('td[amount-due-col]').textContent.trim();
    const paidInput = row.querySelector('td[amount-paid-col]').textContent.trim();
    const changeInput = row.querySelector('td[change-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-transaction-id]').value = transactionIdInput;
    document.querySelector('input[data-customer-detail]').value = customerDetailInput;
    document.querySelector('input[data-employee-id]').value = employeeIdInput;
    document.querySelector('input[data-date]').value = transactionDateInput;
    document.querySelector('input[data-payment]').value = paymentMethodInput;
    document.querySelector('input[data-total-amount]').value = totalAmountInput;
    document.querySelector('input[data-paid]').value = paidInput;
    document.querySelector('input[data-change]').value = changeInput;


    // Optionally, display a success message or perform further actions
    // alert("Transaction Selected");
  });
});


document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const transactionIdInput = document.querySelector('input[data-transaction-id]');
  const customerDetailInput = document.querySelector('input[data-customer-detail]');
  const employeeIdInput = document.querySelector('input[data-employee-id]');
  const transactionDateInput = document.querySelector('input[data-date]');
  const paymentMethodInput = document.querySelector('input[data-payment]');
  const totalAmountInput = document.querySelector('input[data-total-amount]');
  const paidInput = document.querySelector('input[data-paid]');
  const changeInput = document.querySelector('input[data-change]');

  transactionIdValue = transactionIdInput.value.trim();
  customerDetailValue = customerDetailInput.value.trim();
  employeeIdValue = employeeIdInput.value.trim();
  dateValue = transactionDateInput.value.trim();
  paymentMethodValue = paymentMethodInput.value.trim();
  totalAmount = totalAmountInput.value.trim();
  paidValue = paidInput.value.trim();
  changeValue = changeInput.value.trim();



  if (transactionIdValue && customerDetailValue && employeeIdValue && dateValue && paymentMethodValue && totalAmount && paidValue && changeValue) {
    transactionDeletionObject = {
      transactionDetail: {
        transactionId: transactionIdValue,
        customerDetail: customerDetailValue,
        employeeId: employeeIdValue,
        date: dateValue,
        paymentMethod: paymentMethodValue,
        totalAmount: totalAmount,
        paid: paidValue,
        change: changeValue
      }
    };

    transactionDeletion(transactionDeletionObject);
  } else if (transactionIdValue === '' && transactionIdValue === '' && guitarDetailsValue === '' && quantityValue === '' && totalPriceValue === '') {
    alert("No selected transaction");
  }
});


function transactionDeletion(transactionParameter) {
  // Responsible for archiving guitar's information
  const transactionArchiving = new XMLHttpRequest();
  transactionArchiving.open('POST', '../php/transactionArchiving.php', true);
  transactionArchiving.setRequestHeader('Content-Type', 'application/json');

  transactionArchiving.onload = function () {
    if (transactionArchiving.status >= 200 && transactionArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", transactionArchiving.responseText);

        const transactionArchiving_response = JSON.parse(transactionArchiving.responseText);
        if (transactionArchiving_response.success) {
          alert("Transaction archived");
        } else {
          alert("No selected transaction");
          console.log("Archiving new transanction failed:", transactionArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for transaction side:', error);
      }
    } else {
      console.error('Error processing archiving:', transactionArchiving.status);
    }
  };

  // Handle network errors
  transactionArchiving.onerror = function () {
    console.error('Network error while archiving transaction');
  };

  // Send the `transactionedDataParameter` array as JSON to the server
  transactionArchiving.send(JSON.stringify(transactionParameter));
}