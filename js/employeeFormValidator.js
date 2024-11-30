
// Validates the employeeAdding.php ensuring that all fields are filled

const employeeAddingForm = document.querySelector('#employeeAddingForm');
const validatorTextDiv = document.querySelector('.validatorText-container');
const validatorText = document.querySelector('.validatorTextTrue');
const validatorTextv2 = document.querySelector('.validatorTextFalse');

const employeePasswordInput = document.querySelector('.employee_password_input');
const employeeRePasswordInput = document.querySelector('.employee_repassword_input');


employeeAddingForm.addEventListener('submit', (event) => {

  event.preventDefault();
  const formData = new FormData(employeeAddingForm);
  const inputs = employeeAddingForm.querySelectorAll('.input-search');

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



  // Will only run if isFormValid evaluates to true
  if (isFormValid) {
    let employeePassword_value = employeePasswordInput.value.trim();
    let employeeRePassword_value = employeeRePasswordInput.value.trim();

    if (employeePassword_value.length < 8) {
      isFormValid = false;

      // Show Error Message; Ensure that the error message including its container will show
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Password must be 8 letters long.";
    }

    // Checks if password and re-type password are the same
    else if (employeePassword_value !== employeeRePassword_value) {
      isFormValid = false;

      // Show Error Message; Ensure that the error message including its container will show
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Not matching password.";
    }
  }





  // If the isFormValid is still true
  if (isFormValid) {
    const employeeUploadData = new XMLHttpRequest();
    employeeUploadData.open('POST', '../php/employeeUploadHandler.php', true);
    employeeUploadData.onload = function () {
      console.log(employeeUploadData.responseText);  // Log response to see its content
      if (employeeUploadData.status >= 200 && employeeUploadData.status < 400) {
        try {
          const employeeUploadingReponse = JSON.parse(employeeUploadData.responseText);
          console.log(employeeUploadingReponse); // Log the parsed response

          // WHY IN RIGHT CONTENT .success is working
          if (employeeUploadingReponse.status === 'success') {
            // Show success message after successful upload
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-success');
            validatorText.innerText = "Employee is added successfully.";
            validatorText.classList.add('text-success');
          } else {
            // Show error message if the response is not successful
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-danger');
            validatorText.innerText = "Credentials or Employee already exists.";
            validatorText.classList.add('text-danger');
          }
        } catch (error) {
          console.log('Error parsing JSON for Adding Employee side: ', error);
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


    employeeUploadData.onerror = function () {
      // Handle network error or failed request
      console.error('Network error or request failure.');
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Network error or request failure. Please try again.";
      validatorText.classList.add('text-danger');
    };

    employeeUploadData.send(formData);
  }
});