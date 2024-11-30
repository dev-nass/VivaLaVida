
// Validates the customerAdding.php ensuring that all fields are filled

const customerAddingForm = document.querySelector('#customerAddingForm');
const validatorTextDiv = document.querySelector('.validatorText-container');
const validatorText = document.querySelector('.validatorTextTrue');
const validatorTextv2 = document.querySelector('.validatorTextFalse');

const customerPasswordInput = document.querySelector('.customer_password_input');
const customerRePasswordInput = document.querySelector('.customer_repassword_input');


customerAddingForm.addEventListener('submit', (event) => {

  event.preventDefault();
  const formData = new FormData(customerAddingForm);
  const inputs = customerAddingForm.querySelectorAll('.input-search');

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


  if (isFormValid) {
    let customerPassword_value = customerPasswordInput.value.trim();
    let customerRePassword_value = customerRePasswordInput.value.trim();


    if (customerPassword_value.length < 8) {
      isFormValid = false;

      // Show Error Message; Ensure that the error message including its container will show
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Password must be 8 letters long.";
    }

    // Checks if password and re-type password are the same
    else if (customerPassword_value !== customerRePassword_value) {
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
    const customerUploadData = new XMLHttpRequest();
    customerUploadData.open('POST', '../php/customerUploadHandler.php', true);
    customerUploadData.onload = function () {
      console.log(customerUploadData.responseText);  // Log response to see its content
      if (customerUploadData.status >= 200 && customerUploadData.status < 400) {
        try {
          const customerUploadingReponse = JSON.parse(customerUploadData.responseText);
          console.log(customerUploadingReponse); // Log the parsed response

          // WHY IN RIGHT CONTENT .success is working
          if (customerUploadingReponse.status === 'success') {
            // Show success message after successful upload
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-success');
            validatorText.innerText = "Customer is added successfully.";
            validatorText.classList.add('text-success');
          } else {
            // Show error message if the response is not successful
            validatorTextDiv.classList.remove('d-none');
            validatorTextDiv.classList.add('d-block');
            validatorTextDiv.classList.add('alert-danger');
            validatorText.innerText = "Credentials or Customer already exists.";
            validatorText.classList.add('text-danger');
          }
        } catch (error) {
          console.log('Error parsing JSON for Adding User side: ', error);
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


    customerUploadData.onerror = function () {
      // Handle network error or failed request
      console.error('Network error or request failure.');
      validatorTextDiv.classList.remove('d-none');
      validatorTextDiv.classList.add('d-block');
      validatorTextDiv.classList.add('alert-danger');
      validatorText.innerText = "Network error or request failure. Please try again.";
      validatorText.classList.add('text-danger');
    };

    customerUploadData.send(formData);
  }
});