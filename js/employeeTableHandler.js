
let employeeIdValue = '';
let employeeFnameValue = '';
let employeeLnameValue = '';
let employeeUsernameValue = '';
let employeeEmailValue = '';
let employeeContactNumberValue = '';

let employeeDeletionObject = {};
let employeeUpdatingObject = {};



$(document).ready(function () {
  const table = $('#employeeTable').DataTable({
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
  $('#employeeTable').on('click', '#select-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const employeeIdInput = row.querySelector('th[employee-id-col]').textContent.trim();
    const employeeFnameInput = row.querySelector('td[employee-fname-col]').textContent.trim();
    const employeeLnameInput = row.querySelector('td[employee-lname-col]').textContent.trim();
    const employeeUsernameInput = row.querySelector('td[employee-username-col]').textContent.trim();
    const employeeEmailInput = row.querySelector('td[employee-email-col]').textContent.trim();
    const employeeContactNumberInput = row.querySelector('td[employee-cnumber-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-employee-id]').value = employeeIdInput;
    document.querySelector('input[data-fname]').value = employeeFnameInput;
    document.querySelector('input[data-lname]').value = employeeLnameInput;
    document.querySelector('input[data-username]').value = employeeUsernameInput;
    document.querySelector('input[data-email]').value = employeeEmailInput;
    document.querySelector('input[data-contact-number]').value = employeeContactNumberInput;


    // Optionally, display a success message or perform further actions
    // alert("Employee Selected");
  });
});


document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const employeeIdInput = document.querySelector('input[data-employee-id]');
  const employeeFnameInput = document.querySelector('input[data-fname]');
  const employeeLnameInput = document.querySelector('input[data-lname]');
  const employeeUsernameInput = document.querySelector('input[data-username]');
  const employeeEmailInput = document.querySelector('input[data-email]');
  const employeeContactNumberInput = document.querySelector('input[data-contact-number]');

  employeeIdValue = employeeIdInput.value.trim();
  employeeFnameValue = employeeFnameInput.value.trim();
  employeeLnameValue = employeeLnameInput.value.trim();
  employeeUsernameValue = employeeUsernameInput.value.trim();
  employeeEmailValue = employeeEmailInput.value.trim();
  employeeContactNumberValue = employeeContactNumberInput.value.trim();



  if (employeeIdValue && employeeFnameValue && employeeLnameValue && employeeUsernameValue && employeeEmailValue && employeeContactNumberValue) {
    employeeDeletionObject = {
      employeeDetail: {
        employeeId: employeeIdValue,
        employeeFname: employeeFnameValue,
        employeeLname: employeeLnameValue,
        employeeUsername: employeeUsernameValue,
        employeeEmail: employeeEmailValue,
        employeeContactNumber: employeeContactNumberValue,
      }
    };

    employeeDeletion(employeeDeletionObject);
  } else if (employeeIdValue === '' && employeeFnameValue === '' && employeeLnameValue === '' && employeeUsernameValue === '' && employeeEmailValue === '' && employeeContactNumberValue === '') {
    alert("No selected employee");
  }
});


document.querySelector('.update-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const employeeIdInput = document.querySelector('input[data-employee-id]');
  const employeeFnameInput = document.querySelector('input[data-fname]');
  const employeeLnameInput = document.querySelector('input[data-lname]');
  const employeeUsernameInput = document.querySelector('input[data-username]');
  const employeeEmailInput = document.querySelector('input[data-email]');
  const employeeContactNumberInput = document.querySelector('input[data-contact-number]');

  employeeIdValue = employeeIdInput.value.trim();
  employeeFnameValue = employeeFnameInput.value.trim();
  employeeLnameValue = employeeLnameInput.value.trim();
  employeeUsernameValue = employeeUsernameInput.value.trim();
  employeeEmailValue = employeeEmailInput.value.trim();
  employeeContactNumberValue = employeeContactNumberInput.value.trim();



  if (employeeIdValue && employeeFnameValue && employeeLnameValue && employeeUsernameValue && employeeEmailValue && employeeContactNumberValue) {
    employeeUpdatingObject = {
      employeeDetail: {
        employeeId: employeeIdValue,
        employeeFname: employeeFnameValue,
        employeeLname: employeeLnameValue,
        employeeUsername: employeeUsernameValue,
        employeeEmail: employeeEmailValue,
        employeeContactNumber: employeeContactNumberValue,
      }
    };

    employeeUpdate(employeeUpdatingObject);
  } else if (employeeIdValue === '' && employeeFnameValue === '' && employeeLnameValue === '' && employeeUsernameValue === '' && employeeEmailValue === '' && employeeContactNumberValue === '') {
    alert("No selected employee");
  }
});








function employeeDeletion(employeeParameter) {
  // Responsible for archiving guitar's information
  const employeeArchiving = new XMLHttpRequest();
  employeeArchiving.open('POST', '../php/employeeArchiving.php', true);
  employeeArchiving.setRequestHeader('Content-Type', 'application/json');

  employeeArchiving.onload = function () {
    if (employeeArchiving.status >= 200 && employeeArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", employeeArchiving.responseText);

        const employeeArchiving_response = JSON.parse(employeeArchiving.responseText);
        if (employeeArchiving_response.success) {
          alert("Employee archived");
        } else {
          alert("No selected employee");
          console.log("Archiving employee failed:", employeeArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for employee side:', error);
      }
    } else {
      console.error('Error processing archiving:', employeeArchiving.status);
    }
  };

  // Handle network errors
  employeeArchiving.onerror = function () {
    console.error('Network error while archiving employee');
  };

  // Send the `employeeedDataParameter` array as JSON to the server
  employeeArchiving.send(JSON.stringify(employeeParameter));
}




function employeeUpdate(employeeParameter) {
  // Responsible for archiving guitar's information
  const employeeUpdating = new XMLHttpRequest();
  employeeUpdating.open('POST', '../php/employeeUpdating.php', true);
  employeeUpdating.setRequestHeader('Content-Type', 'application/json');

  employeeUpdating.onload = function () {
    if (employeeUpdating.status >= 200 && employeeUpdating.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", employeeUpdating.responseText);

        const employeeUpdating_response = JSON.parse(employeeUpdating.responseText);
        if (employeeUpdating_response.success) {
          alert("Employee updated");
        } else {
          alert("Credentials already exists");
          console.log("Updating employee failed:", employeeUpdating.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for employee side:', error);
      }
    } else {
      console.error('Error processing archiving:', employeeUpdating.status);
    }
  };

  // Handle network errors
  employeeUpdating.onerror = function () {
    console.error('Network error while archiving employee');
  };

  // Send the `employeeedDataParameter` array as JSON to the server
  employeeUpdating.send(JSON.stringify(employeeParameter));
}