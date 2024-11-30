
/* 
  - Validates the guitarUploadingForm.php ensure that the form won't be submitted until the requirement
  are met.

*/

const guitarUploadingForm = document.querySelector('#guitarUploadingForm');
const validatorTextDiv = document.querySelector('.validatorText-container');
const validatorText = document.querySelector('.validatorTextTrue');
const validatorTextv2 = document.querySelector('.validatorTextFalse');

guitarUploadingForm.addEventListener('submit', (event) => {

  event.preventDefault();
  const formData = new FormData(guitarUploadingForm);
  const inputs = guitarUploadingForm.querySelectorAll('.input-search');

  let isFormValid = true;

  // Clear previous validation messages
  validatorTextDiv.classList.remove('d-block', 'alert-danger', 'alert-success');
  validatorText.classList.remove('text-danger', 'text-success');
  validatorText.innerText = "";

  // Check for empty inputs
  for (let i = 0; i < inputs.length; i++) {
    const inputInstance = inputs[i];
    if (!inputInstance.value.trim()) {
      isFormValid = false;
      inputInstance.classList.add('is-invalid'); // built-in bootstrap class for showing the red outline

      // Show Error Message; Ensure that the error message including its container will show
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Please fill in all fields.";
      validatorText.classList.add('text-danger');
    } else {
      inputInstance.classList.remove('is-invalid'); // removes the adde bootstrap class for red outline
    }
  }

  // If the isFormValid is still true
  if (isFormValid) {
    const guitarUploadData = new XMLHttpRequest();
    guitarUploadData.open('POST', '../php/guitarUploadHandler.php', true);
    guitarUploadData.onload = function () {
      console.log(guitarUploadData.responseText);  // Log response to see its content
      if (guitarUploadData.status >= 200 && guitarUploadData.status < 400) {
        try {
          const guitarUploadingReponse = JSON.parse(guitarUploadData.responseText);
          console.log(guitarUploadingReponse); // Log the parsed response

          // WHY IN RIGHT CONTENT .success is working
          if (guitarUploadingReponse.status === 'success') {
            // Show success message after successful upload
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-success');
            validatorText.innerText = "Guitar is added successfully.";
            validatorText.classList.add('text-success');
          } else {
            // Show error message if the response is not successful
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-danger');
            validatorText.innerText = "Guitar already exists.";
            validatorText.classList.add('text-danger');
          }
        } catch (error) {
          console.log('Error parsing JSON for Guitar Uploading side: ', error);
        }
      } else {
        // Request failed, handle error
        validatorTextDiv.classList.remove('d-none');
        validatorTextDiv.classList.add('d-block');
        validatorTextDiv.classList.add('alert-danger');
        validatorTextv2.innerText = "Request failed. Please try again.";
        validatorTextv2.classList.add('text-danger');
      }
    };


    guitarUploadData.onerror = function () {
      // Handle network error or failed request
      console.error('Network error or request failure.');
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Network error or request failure. Please try again.";
      validatorText.classList.add('text-danger');
    };

    guitarUploadData.send(formData);
  }
});
