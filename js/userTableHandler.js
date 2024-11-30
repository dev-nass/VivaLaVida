
let userIdValue = '';
let userFnameValue = '';
let userLnameValue = '';
let userAgeValue = '';
let userUsernameValue = '';
let userEmailValue = '';
let userContactNumberValue = '';
let userAddressValue = '';

let userDeletionObject = {};
let userUpdatingObject = {};



$(document).ready(function () {
  const table = $('#userTable').DataTable({
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
  $('#userTable').on('click', '#select-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const userIdInput = row.querySelector('th[user-id-col]').textContent.trim();
    const userFnameInput = row.querySelector('td[user-fname-col]').textContent.trim();
    const userLnameInput = row.querySelector('td[user-lname-col]').textContent.trim();
    const userAgeInput = row.querySelector('td[user-age-col]').textContent.trim();
    const userUsernameInput = row.querySelector('td[user-username-col]').textContent.trim();
    const userEmailInput = row.querySelector('td[user-email-col]').textContent.trim();
    const userContactNumberInput = row.querySelector('td[user-cnumber-col]').textContent.trim();
    const userAddressInput = row.querySelector('td[user-address-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-user-id]').value = userIdInput;
    document.querySelector('input[data-fname]').value = userFnameInput;
    document.querySelector('input[data-lname]').value = userLnameInput;
    document.querySelector('input[data-age]').value = userAgeInput;
    document.querySelector('input[data-username]').value = userUsernameInput;
    document.querySelector('input[data-email]').value = userEmailInput;
    document.querySelector('input[data-contact-number]').value = userContactNumberInput;
    document.querySelector('input[data-address]').value = userAddressInput;


    // Optionally, display a success message or perform further actions
    alert("User Selected");
  });
});


document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const userIdInput = document.querySelector('input[data-user-id]');
  const userFnameInput = document.querySelector('input[data-fname]');
  const userLnameInput = document.querySelector('input[data-lname]');
  const userAgeInput = document.querySelector('input[data-age]');
  const userUsernameInput = document.querySelector('input[data-username]');
  const userEmailInput = document.querySelector('input[data-email]');
  const userContactNumberInput = document.querySelector('input[data-contact-number]');
  const userAddressInput = document.querySelector('input[data-address]');

  userIdValue = userIdInput.value.trim();
  userFnameValue = userFnameInput.value.trim();
  userLnameValue = userLnameInput.value.trim();
  userAgeValue = userAgeInput.value.trim();
  userUsernameValue = userUsernameInput.value.trim();
  userEmailValue = userEmailInput.value.trim();
  userContactNumberValue = userContactNumberInput.value.trim();
  userAddressValue = userAddressInput.value.trim();



  if (userIdValue) {
    userDeletionObject = {
      userDetail: {
        userId: userIdValue,
        userFname: userFnameValue,
        userLname: userLnameValue,
        userAge: userAgeValue,
        userUsername: userUsernameValue,
        userEmail: userEmailValue,
        userContactNumber: userContactNumberValue,
        userAddress: userAddressValue
      }
    };

    userDeletion(userDeletionObject);
  } else if (userIdValue === '') {
    alert("No selected user");
  }
});


document.querySelector('.update-btn').addEventListener('click', function () {
  //  Extract the values from the row
  const userIdInput = document.querySelector('input[data-user-id]');
  const userFnameInput = document.querySelector('input[data-fname]');
  const userLnameInput = document.querySelector('input[data-lname]');
  const userAgeInput = document.querySelector('input[data-age]');
  const userUsernameInput = document.querySelector('input[data-username]');
  const userEmailInput = document.querySelector('input[data-email]');
  const userContactNumberInput = document.querySelector('input[data-contact-number]');
  const userAddressInput = document.querySelector('input[data-address]');

  userIdValue = userIdInput.value.trim();
  userFnameValue = userFnameInput.value.trim();
  userLnameValue = userLnameInput.value.trim();
  userAgeValue = userAgeInput.value.trim();
  userUsernameValue = userUsernameInput.value.trim();
  userEmailValue = userEmailInput.value.trim();
  userContactNumberValue = userContactNumberInput.value.trim();
  userAddressValue = userAddressInput.value.trim();



  if (userIdValue) {
    userUpdatingObject = {
      userDetail: {
        userId: userIdValue,
        userFname: userFnameValue,
        userLname: userLnameValue,
        userAge: userAgeValue,
        userUsername: userUsernameValue,
        userEmail: userEmailValue,
        userContactNumber: userContactNumberValue,
        userAddress: userAddressValue
      }
    };

    userUpdate(userUpdatingObject);
  } else if (userIdValue === '') {
    alert("No selected user");
  }
});








function userDeletion(userParameter) {
  // Responsible for archiving guitar's information
  const userArchiving = new XMLHttpRequest();
  userArchiving.open('POST', '../php/userArchiving.php', true);
  userArchiving.setRequestHeader('Content-Type', 'application/json');

  userArchiving.onload = function () {
    if (userArchiving.status >= 200 && userArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", userArchiving.responseText);

        const userArchiving_response = JSON.parse(userArchiving.responseText);
        if (userArchiving_response.success) {
          alert("User archived");
        } else {
          alert("No selected user");
          console.log("Archiving user failed:", userArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for user side:', error);
      }
    } else {
      console.error('Error processing archiving:', userArchiving.status);
    }
  };

  // Handle network errors
  userArchiving.onerror = function () {
    console.error('Network error while archiving user');
  };

  // Send the `useredDataParameter` array as JSON to the server
  userArchiving.send(JSON.stringify(userParameter));
}




function userUpdate(userParameter) {
  // Responsible for archiving guitar's information
  const userUpdating = new XMLHttpRequest();
  userUpdating.open('POST', '../php/userUpdating.php', true);
  userUpdating.setRequestHeader('Content-Type', 'application/json');

  userUpdating.onload = function () {
    if (userUpdating.status >= 200 && userUpdating.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", userUpdating.responseText);

        const userUpdating_response = JSON.parse(userUpdating.responseText);
        if (userUpdating_response.success) {
          alert("User updated");
        } else {
          alert("Credentials already exist");
          console.log("Updating user failed:", userUpdating.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for user side:', error);
      }
    } else {
      console.error('Error processing archiving:', userUpdating.status);
    }
  };

  // Handle network errors
  userUpdating.onerror = function () {
    console.error('Network error while archiving user');
  };

  // Send the `useredDataParameter` array as JSON to the server
  userUpdating.send(JSON.stringify(userParameter));
}