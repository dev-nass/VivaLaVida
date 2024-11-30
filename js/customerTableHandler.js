
let customerIdValue = '';
let customerFnameValue = '';
let customerLnameValue = '';
let customerEmailValue = '';
let customerContactNumberValue = '';

let custommerUsernameValue = "";
let customerAddressValue = "";
let customerPurchaseStatusValue = "";

let customerDeletionObject = {};



$(document).ready(function () {
  const table = $('#customerTable').DataTable({
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
  $('#customerTable').on('click', '#select-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const customerIdInput = row.querySelector('th[customer-id-col]').textContent.trim();
    const customerFnameInput = row.querySelector('td[customer-fname-col]').textContent.trim();
    const customerLnameInput = row.querySelector('td[customer-lname-col]').textContent.trim();
    const customerEmailInput = row.querySelector('td[customer-email-col]').textContent.trim();
    const customerUsernameInput = row.querySelector('td[customer-username-col]').textContent.trim();
    const customerContactNumberInput = row.querySelector('td[customer-cnumber-col]').textContent.trim();
    const customerAddressInput = row.querySelector('td[customer-address-col]').textContent.trim();
    const customerPurchaseStatusInput = row.querySelector('td[customer-purchase-status-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-customer-id]').value = customerIdInput;
    document.querySelector('input[data-fname]').value = customerFnameInput;
    document.querySelector('input[data-lname]').value = customerLnameInput;
    document.querySelector('input[data-email]').value = customerEmailInput;
    document.querySelector('input[data-username]').value = customerUsernameInput;
    document.querySelector('input[data-contact-number]').value = customerContactNumberInput;
    document.querySelector('input[data-address]').value = customerAddressInput;
    document.querySelector('input[data-purchase-status]').value = customerPurchaseStatusInput;


    // Optionally, display a success message or perform further actions
    // alert("Customer Selected");
  });
});


document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const customerIdInput = document.querySelector('input[data-customer-id]');
  const customerFnameInput = document.querySelector('input[data-fname]');
  const customerLnameInput = document.querySelector('input[data-lname]');
  const customerEmailInput = document.querySelector('input[data-email]');
  const customerContactNumberInput = document.querySelector('input[data-contact-number]');

  customerIdValue = customerIdInput.value.trim();
  customerFnameValue = customerFnameInput.value.trim();
  customerLnameValue = customerLnameInput.value.trim();
  customerEmailValue = customerEmailInput.value.trim();
  customerContactNumberValue = customerContactNumberInput.value.trim();



  if (customerIdValue && customerFnameValue && customerLnameValue && customerEmailValue && customerContactNumberValue) {
    customerDeletionObject = {
      customerDetail: {
        customerId: customerIdValue,
        customerFname: customerFnameValue,
        customerLname: customerLnameValue,
        customerEmail: customerEmailValue,
        customerContactNumber: customerContactNumberValue,
      }
    };

    customerDeletion(customerDeletionObject);
  } else if (customerIdValue === '' && customerFnameValue === '' && customerLnameValue === '' && customerEmailValue === '' && customerContactNumberValue === '') {
    alert("No selected customer");
  }
});




function customerDeletion(customerParameter) {
  // Responsible for archiving guitar's information
  const customerArchiving = new XMLHttpRequest();
  customerArchiving.open('POST', '../php/customerArchiving.php', true);
  customerArchiving.setRequestHeader('Content-Type', 'application/json');

  customerArchiving.onload = function () {
    if (customerArchiving.status >= 200 && customerArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", customerArchiving.responseText);

        const customerArchiving_response = JSON.parse(customerArchiving.responseText);
        if (customerArchiving_response.success) {
          alert("Customer archived");
        } else {
          alert("No selected customer");
          console.log("Archiving new transanction failed:", customerArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for customer side:', error);
      }
    } else {
      console.error('Error processing archiving:', customerArchiving.status);
    }
  };

  // Handle network errors
  customerArchiving.onerror = function () {
    console.error('Network error while archiving customer');
  };

  // Send the `customeredDataParameter` array as JSON to the server
  customerArchiving.send(JSON.stringify(customerParameter));
}