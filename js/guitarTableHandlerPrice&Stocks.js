let guitarIdValue = '';
let guitarTypeValue = '';
let guitarBrandValue = '';
let guitarModelValue = '';
let guitarPriceValue = '';
let guitarStocksValue = '';


let guitarUpdatingObject = {};




// Table initialization and Select Btn functionality
// Table initialization and Select Btn functionality
$(document).ready(function () {
  const table = $('#guitarTable').DataTable({
    responsive: true,
    search: {
      smart: true, // Enable smart search
    },
    columnDefs: [
      {
        targets: [0, 1, 2, 3], // Target the 'ID' column (index starts from 0)
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
  $('#guitarTable').on('click', '#edit-btn', function () {
    // Extract the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const guitarIdInput = row.querySelector('th[guitar-id-col]').textContent.trim();
    const guitarTypeInput = row.querySelector('td[guitar-type-col]').textContent.trim();
    const guitarBrandInput = row.querySelector('td[guitar-brand-col]').textContent.trim();
    const guitarModelInput = row.querySelector('td[guitar-model-col]').textContent.trim();
    const guitarPriceInput = row.querySelector('td[guitar-price-col]').textContent.trim();
    const guitarStocksInput = row.querySelector('td[guitar-stocks-col]').textContent.trim();

    // Set values to the modal's input fields
    document.querySelector('input[data-guitar-id]').value = guitarIdInput;
    document.querySelector('input[data-guitar-type]').value = guitarTypeInput;
    document.querySelector('input[data-guitar-brand]').value = guitarBrandInput;
    document.querySelector('input[data-guitar-model]').value = guitarModelInput;
    document.querySelector('input[data-guitar-price]').value = guitarPriceInput;
    document.querySelector('input[data-guitar-stocks]').value = guitarStocksInput;

    // Optionally, display a success message or perform further actions
    // alert("Guitar Selected");
  });
});



document.querySelector('.update-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const guitarIdInput = document.querySelector('input[data-guitar-id]');
  const guitarTypeInput = document.querySelector('input[data-guitar-type]');
  const guitarBrandInput = document.querySelector('input[data-guitar-brand]');
  const guitarModelInput = document.querySelector('input[data-guitar-model]');
  const guitarPriceInput = document.querySelector('input[data-guitar-price]');
  const guitarStocksInput = document.querySelector('input[data-guitar-stocks]');

  guitarIdValue = guitarIdInput.value.trim();
  guitarTypeValue = guitarTypeInput.value.trim();
  guitarBrandValue = guitarBrandInput.value.trim();
  guitarModelValue = guitarModelInput.value.trim();
  guitarPriceValue = guitarPriceInput.value.trim();
  guitarStocksValue = guitarStocksInput.value.trim();

  if (guitarIdValue && guitarTypeValue && guitarBrandValue && guitarModelValue && guitarPriceValue && guitarStocksValue) {
    guitarUpdatingObject = {
      guitarDetail: {
        guitarId: guitarIdValue,
        guitarType: guitarTypeValue,
        guitarBrand: guitarBrandValue,
        guitarModel: guitarModelValue,
        guitarPrice: guitarPriceValue,
        guitarStocks: guitarStocksValue,
      }
    }

    guitarUpdating(guitarUpdatingObject);
  } else if (guitarIdValue === '' && guitarTypeValue === '' && guitarBrandValue === '' && guitarModelValue === '' && guitarPriceValue === '' && guitarStocksValue === '') {
    alert("No selected guitar");
  } else if (guitarPriceValue === '' || guitarStocksValue === '') {
    alert("Price or stocks is empty");
  }
});


// Responsible for updating the guitar
function guitarUpdating(guitarParameter) {
  // Responsible for updating guitar's information
  const guitarUpdating = new XMLHttpRequest();
  guitarUpdating.open('POST', '../php/guitarUpdatingPrice&Stocks.php', true);
  guitarUpdating.setRequestHeader('Content-Type', 'application/json');

  guitarUpdating.onload = function () {
    if (guitarUpdating.status >= 200 && guitarUpdating.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", guitarUpdating.responseText);

        const guitarUpdating_response = JSON.parse(guitarUpdating.responseText);
        if (guitarUpdating_response.success) {
          alert("Guitar updated");
        } else {
          alert("No selected guitar");
          console.log("Updated new guitar failed:", guitarUpdating.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for Guitar updating side:', error);
      }
    } else {
      console.error('Error processing updating:', guitarUpdating.status);
    }
  };

  // Handle network errors
  guitarUpdating.onerror = function () {
    console.error('Network error while archiving order');
  };

  // Send the `orderedDataParameter` array as JSON to the server
  guitarUpdating.send(JSON.stringify(guitarParameter));
}