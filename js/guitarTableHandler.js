let guitarIdValue = '';
let guitarTypeValue = '';
let guitarBrandValue = '';
let guitarModelValue = '';
let guitarFretBoardMatValue = '';
let guitarNeckMatValue = '';
let guitarBodyMatValue = '';
let guitarBodyShapeValue = '';
let guitarNumberOfStringsValue = '';
let guitarNumberOfFretsValue = '';
let guitarImageValue = '';
let guitarDescriptionValue = '';
// let guitarPriceValue = '';
// let guitarStocksValue = '';

let guitarUpdatingObject = {};
let guitarArchivingObject = {};



// Table initialization and Select Btn functionality
$(document).ready(function () {
  const table = $('#guitarTable').DataTable({
    responsive: true,
  });

  // Event delegation for buttons within the table
  $('#guitarTable').on('click', '#edit-btn', function () {
    //  Extra the values from the row
    const row = table.row($(this).parents('tr')).node(); // Retrieve the row's DOM element

    const guitarIdInput = row.querySelector('th[guitar-id-col]').textContent.trim();
    const guitarTypeInput = row.querySelector('td[guitar-type-col]').textContent.trim();
    const guitarBrandInput = row.querySelector('td[guitar-brand-col]').textContent.trim();
    const guitarModelInput = row.querySelector('td[guitar-model-col]').textContent.trim();
    const guitarFretBoardMatInput = row.querySelector('td[guitar-fretMat-col]').textContent.trim();
    const guitarNeckMatInput = row.querySelector('td[guitar-neckMat-col]').textContent.trim();
    const guitarBodyMatInput = row.querySelector('td[guitar-bodyMat-col]').textContent.trim();
    const guitarBodyShapeInput = row.querySelector('td[guitar-BodyShape-col]').textContent.trim();
    const guitarNumberOfStringsInput = row.querySelector('td[guitar-numOfStrings-col]').textContent.trim();
    const guitarNumberOfFretsInput = row.querySelector('td[guitar-numberOfFrets-col]').textContent.trim();
    const guitarDescriptionInput = row.querySelector('td[guitar-description-col]').textContent.trim();
    // const guitarImageInput = row.querySelector('img[data-guitar-col-img]').src;
    // const guitarPriceInput = row.querySelector('td[guitar-price-col]').textContent.trim();
    // const guitarStocksInput = row.querySelector('td[guitar-stocks-col]').textContent.trim();

    // Set values to the modal's input field based on what's retrieved from the rows
    guitarIdValue = document.querySelector('input[data-guitar-id]').value = guitarIdInput;
    guitarTypeValue = document.querySelector('input[data-guitar-type]').value = guitarTypeInput;
    guitarBrandValue = document.querySelector('input[data-guitar-brand]').value = guitarBrandInput;
    guitarModelValue = document.querySelector('input[data-guitar-model]').value = guitarModelInput;
    guitarFretBoardMatValue = document.querySelector('input[data-guitar-fretBoardMat]').value = guitarFretBoardMatInput;
    guitarNeckMatValue = document.querySelector('input[data-guitar-neckMat]').value = guitarNeckMatInput;
    guitarBodyMatValue = document.querySelector('input[data-guitar-bodyMat]').value = guitarBodyMatInput;
    guitarBodyShapeValue = document.querySelector('input[data-guitar-bodyShape]').value = guitarBodyShapeInput;
    guitarNumberOfStringsValue = document.querySelector('input[data-guitar-numberOfStrings]').value = guitarNumberOfStringsInput;
    guitarNumberOfFretsValue = document.querySelector('input[data-guitar-numberOfFrets]').value = guitarNumberOfFretsInput;
    guitarDescriptionValue = document.querySelector('textarea[data-guitar-description]').value = guitarDescriptionInput;
    // guitarImageValue = document.querySelector('input[data-guitar-image]').value = guitarImageInput;
    // guitarPriceValue = document.querySelector('input[data-guitar-price]').value = guitarPriceInput;
    // guitarStocksValue = document.querySelector('input[data-guitar-stocks]').value = guitarStocksInput;

    // alert("Guitar Seleted"); this is removed since the btn now calls the modal
  });
});


document.querySelector('.update-btn').addEventListener('click', function () {
  const formData = new FormData();

  const guitarIdInput = document.querySelector('input[data-guitar-id]');
  const guitarTypeInput = document.querySelector('input[data-guitar-type]');
  const guitarBrandInput = document.querySelector('input[data-guitar-brand]');
  const guitarModelInput = document.querySelector('input[data-guitar-model]');
  const guitarFretBoardMatInput = document.querySelector('input[data-guitar-fretBoardMat]');
  const guitarNeckMatInput = document.querySelector('input[data-guitar-neckMat]');
  const guitarBodyMatInput = document.querySelector('input[data-guitar-bodyMat]');
  const guitarBodyShapeInput = document.querySelector('input[data-guitar-bodyShape]');
  const guitarNumberOfStringsInput = document.querySelector('input[data-guitar-numberOfStrings]');
  const guitarNumberOfFretsInput = document.querySelector('input[data-guitar-numberOfFrets]');
  const guitarDescriptionInput = document.querySelector('textarea[data-guitar-description]');

  guitarIdValue = guitarIdInput.value.trim();
  guitarTypeValue = guitarTypeInput.value.trim();
  guitarBrandValue = guitarBrandInput.value.trim();
  guitarModelValue = guitarModelInput.value.trim();
  guitarFretBoardMatValue = guitarFretBoardMatInput.value.trim();
  guitarNeckMatValue = guitarNeckMatInput.value.trim();
  guitarBodyMatValue = guitarBodyMatInput.value.trim();
  guitarBodyShapeValue = guitarBodyShapeInput.value.trim();
  guitarNumberOfStringsValue = guitarNumberOfStringsInput.value.trim();
  guitarNumberOfFretsValue = guitarNumberOfFretsInput.value.trim();
  guitarDescriptionValue = guitarDescriptionInput.value.trim();

  formData.append("guitarId", guitarIdValue);
  formData.append("guitarType", guitarTypeValue);
  formData.append("guitarBrand", guitarBrandValue);
  formData.append("guitarModel", guitarModelValue);
  formData.append("guitarFretBoardMat", guitarFretBoardMatValue);
  formData.append("guitarNeckMat", guitarNeckMatValue);
  formData.append("guitarBodyMat", guitarBodyMatValue);
  formData.append("guitarBodyShape", guitarBodyShapeValue);
  formData.append("guitarNumOfStrings", guitarNumberOfStringsValue);
  formData.append("guitarNumOfFrets", guitarNumberOfFretsValue);
  formData.append("guitarImage", document.querySelector('input[data-guitar-image]').files[0]); // Add the file
  formData.append("guitarDescription", guitarDescriptionValue);

  guitarUpdating(formData);

});



document.querySelector('.archive-btn').addEventListener('click', function () {
  //  Extra the values from the row
  const guitarIdInput = document.querySelector('input[data-guitar-id]');
  const guitarTypeInput = document.querySelector('input[data-guitar-type]');
  const guitarBrandInput = document.querySelector('input[data-guitar-brand]');
  const guitarModelInput = document.querySelector('input[data-guitar-model]');
  const guitarFretBoardMatInput = document.querySelector('input[data-guitar-fretBoardMat]');
  const guitarNeckMatInput = document.querySelector('input[data-guitar-neckMat]');
  const guitarBodyMatInput = document.querySelector('input[data-guitar-bodyMat]');
  const guitarBodyShapeInput = document.querySelector('input[data-guitar-bodyShape]');
  const guitarNumberOfStringsInput = document.querySelector('input[data-guitar-numberOfStrings]');
  const guitarNumberOfFretsInput = document.querySelector('input[data-guitar-numberOfFrets]');
  const guitarDescriptionInput = document.querySelector('input[data-guitar-description]');
  // const guitarPriceInput = document.querySelector('input[data-guitar-price]');
  // const guitarStocksInput = document.querySelector('input[data-guitar-stocks]');

  guitarIdValue = guitarIdInput.value.trim();
  guitarTypeValue = guitarTypeInput.value.trim();
  guitarBrandValue = guitarBrandInput.value.trim();
  guitarModelValue = guitarModelInput.value.trim();
  guitarFretBoardMatValue = guitarFretBoardMatInput.value.trim();
  guitarNeckMatValue = guitarNeckMatInput.value.trim();
  guitarBodyMatValue = guitarBodyMatInput.value.trim();
  guitarBodyShapeValue = guitarBodyShapeInput.value.trim();
  guitarNumberOfStringsValue = guitarNumberOfStringsInput.value.trim();
  guitarNumberOfFretsValue = guitarNumberOfFretsInput.value.trim();
  guitarDescriptionValue = guitarDescriptionInput.value.trim();
  // guitarPriceValue = guitarPriceInput.value.trim();
  // guitarStocksValue = guitarStocksInput.value.trim();

  if (guitarIdValue && guitarTypeValue && guitarBrandValue && guitarModelValue && guitarFretBoardMatValue && guitarNeckMatValue && guitarBodyMatValue && guitarBodyShapeValue && guitarNumberOfStringsValue && guitarNumberOfFretsValue) {
    guitarArchivingObject = {
      guitarDetail: {
        guitarId: guitarIdValue,
        guitarType: guitarTypeValue,
        guitarBrand: guitarBrandValue,
        guitarModel: guitarModelValue,
        guitarFretBoardMat: guitarFretBoardMatValue,
        guitarNeckMat: guitarNeckMatValue,
        guitarBodyMat: guitarBodyMatValue,
        guitarBodyShape: guitarBodyShapeValue,
        guitarNumOfStrings: guitarNumberOfStringsValue,
        guitarNumOfFrets: guitarNumberOfFretsValue,
        guitarDescription: guitarDescriptionValue,
        // guitarPrice: guitarPriceValue,
        // guitarStocks: guitarStocksValue,
      }
    }

    guitarArchiving(guitarArchivingObject);

  }
});








// Responsible for updating the guitar
function guitarUpdating(formData) {
  // Responsible for updating guitar's information
  const guitarUpdating = new XMLHttpRequest();
  guitarUpdating.open('POST', '../php/guitarUpdating.php', true);

  console.log(guitarModelValue);

  guitarUpdating.onload = function () {
    if (guitarUpdating.status >= 200 && guitarUpdating.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", guitarUpdating.responseText);

        const guitarUpdating_response = JSON.parse(guitarUpdating.responseText);
        if (guitarUpdating_response.success) {
          alert("Guitar information updated");
        } else {
          alert("No selected guitar");
          console.log("Adding new guitar failed:", guitarUpdating.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for Guitar Insertion side:', error);
      }
    } else {
      console.error('Error processing updating:', guitarUpdating.status);
    }
  };

  // Handle network errors
  guitarUpdating.onerror = function () {
    console.error('Network error while updating guitar');
  };

  // Send the `orderedDataParameter` array as JSON to the server
  guitarUpdating.send(formData);
}



// Responsible for archiving the guitar
function guitarArchiving(guitarParameter) {
  // Responsible for archiving guitar's information
  const guitarArchiving = new XMLHttpRequest();
  guitarArchiving.open('POST', '../php/guitarArchiving.php', true);
  guitarArchiving.setRequestHeader('Content-Type', 'application/json');

  guitarArchiving.onload = function () {
    if (guitarArchiving.status >= 200 && guitarArchiving.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", guitarArchiving.responseText);

        const guitarArchiving_response = JSON.parse(guitarArchiving.responseText);
        if (guitarArchiving_response.success) {
          alert("Guitar archived");
        } else {
          alert("No selected guitar");
          console.log("Archiving new guitar failed:", guitarArchiving.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for Guitar archiving side:', error);
      }
    } else {
      console.error('Error processing archiving:', guitarArchiving.status);
    }
  };

  // Handle network errors
  guitarArchiving.onerror = function () {
    console.error('Network error while archiving order');
  };

  // Send the `orderedDataParameter` array as JSON to the server
  guitarArchiving.send(JSON.stringify(guitarParameter));
}