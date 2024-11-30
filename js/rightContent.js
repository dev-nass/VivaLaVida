
/*

FUNCTIIONS USED:
  addGuitar() - trigger when "add item" buttons is clicked on each items
  placeOrder() - where all the magic happen; this is called whenever the "place order" button is clicked



AJAX FLOW OVERVIEW:
  .open() specify what method (GET/POST), where the handler is (URL), and what kind (Asynchronous/True or Synchronous/False)
    true -  means that the process is asynchronous, meaning the code will continue to execute while the request is being processed.

  .onload() this is an event handler for the data TO BE received.
    .onload is a part of XMLHttpRequest (XHR) object and is used to define a function that will be executed when the response to an asynchronous request is received successfully.

  .send() sends the actual request to the server side script PHP

    So why is the .onload() is declared before the .send()? This is because of the Asynchronous characterisitic
  that AJAX has. The computer / browser reads the code line-by-line first without execution caused by Async. The issue
  is, if its done differently, if the computer / browser sends the request without even knowing how to handle SHITSSS yare na.



OTHER BUILT-IN METHOD USED:
  variableName = new XMLHttpsRequest() creates new Object enabling the acccess of these built-in method
  JSON.parse() The data received from the PHP script is converted into JSON using JSON_ENCODE (used on php) but for some reason, JS cannot use this data as a JSON properly yet until you use JSON.parse()
  .setRequestHeader() is explained thoroughly below
*/

let guitarOrders = []; // used for holding the guitar orders; this is an array that contains object [ {...}, {...} ]
let totalPrice = 0.00; // used inside both of the function
let retrievedTransactionId = 0; // you know what this is, read u dumb pluck
let isReceiptBtnAppeared = false; // used at receiptPrinter function so the print receipt btn appear only once
let guitarQuantities = {}; // object that store quantities for each guitarId; store the guitarId as key : and quantity as value

// These two are reponsible for adding the Employee Information at the receiptPrinter
let employeeId = document.querySelector('.employee-id').value;
let employeeName = document.querySelector('.employee-name').value;

let orderData = {}; // an object that holds everything; reponsible for passing the data to the server-side scripting

// All of which are used for user information at the modal
let userIdValue = '';
let userFnameValue = '';
let userLnameValue = '';
let userEmailValue = '';
let userNumberValue = '';

let userUpdatingObject = {}; // holds the values that will be passed to userUpdating() and eventually to the server-side scripting and thus update the data on the database

let quantityValue = 1; // modified version of the previous one; This is just used for additional condition



// TRIGGERS WHEN THE "ADD ITEM" BUTTON IS CLICKED !!!!!
function addGuitar(guitarId) {
  const orderedItemContainer = document.querySelector('.ordered-items'); // first child of the right-content div on orderingGuitar.php
  const existingGuitar = orderedItemContainer.querySelector(`span[data-guitar-id="${guitarId}"]`); // used for checking if another card item should be created for added ordered guitar

  const myServerRequest = new XMLHttpRequest(); // Send an AJAX request to the server to fetch the guitar details
  myServerRequest.open('GET', `../php/addingOrderedGuitar.php?GuitarID=${guitarId}`, true); // Configuring the URL to send the request to and also retrive the data through GET

  myServerRequest.onload = function () {
    if (myServerRequest.status >= 200 && myServerRequest.status < 400) {
      const guitarInstance = JSON.parse(myServerRequest.responseText); // guitarInstance get the response from the server
      // console.log("Full response from server:", myServerRequest.responseText) for debugging



      if (quantityValue >= 1) {
        // if that span element that contains the guitarId is not existing yet go here
        if (!existingGuitar) {
          guitarQuantities[guitarId] = quantityValue; // create a new property(key : value) pair. where the 'key' is the guitarId receiveid, and 'value' is quantityValue; e.g.,(guitarId 1 : 69)
          document.querySelector('.ordered-items').innerHTML += `
            <div style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); background-color: var(--clr-white); border: 1px solid #222;" class="card mb-3 p-2" data-guitar-id="${guitarInstance.GuitarID}">
              <div class="row w-100">

                <div class="col-4">
                  <img style="height: 100%; min-width: 100%;" src="${guitarInstance.Guitar_Picture}" class="img-fluid rounded-start" alt="guitarImage">
                </div>

                <div class="col-5 p-0">
                  <div class="card-body p-0 h-100">
                    <span class="d-none" data-guitar-id="${guitarInstance.GuitarID}">${guitarInstance.GuitarID}</span>
                    <h5 class="card-title darkViva-text m-1" style="font-size: 1rem;">${guitarInstance.Model}</h5>
                    <p class="card-text darkViva-text m-1" style="font-size: .9rem;">${guitarInstance.Brand}</p>
                    <div class="d-flex">
                      <span onclick="itemRemover(${guitarId}, ${guitarInstance.Price})" style="cursor: pointer;" class="quantity-control minus brown-button w-25">-</span>
                      <p class="card-text darkViva-text m-1 mx-1">x<small class="quantityText text-body-secondary" data-guitar-id="${guitarInstance.GuitarID}">${quantityValue}</small></p>
                      <!-- NEW LEARNING: CREATE NEW ATTRIBUTE THAT IS USED FOR SELECTING THE INPUT AND THE ID IT CONTAINS FOR AN INSTANCE -->
                      <span onclick="itemAdding(${guitarId}, ${guitarInstance.Price})" style="cursor: pointer;" class="quantity-control add brown-button w-25">+</span>
                    </div>
                  </div>
                </div>

                <div class="col-3 p-0 d-flex flex-column justify-content-between align-items-center">
                  <p class="total-price-item" style="color: #198754; font-size: 1rem;" data-guitar-id="${guitarInstance.GuitarID}">${(parseFloat(guitarInstance.Price) * guitarQuantities[guitarId]).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                  <button onclick="removedItemAsWhole(${guitarId})" class="btn btn-danger remove-button"><i class="fa-solid fa-trash-can"></i></button>
                </div>

              </div>
            </div>
          `;

          totalPrice = totalPrice + parseFloat(guitarInstance.Price);
          // Update the HTML
          document.querySelector('.totalPriceText').innerHTML = `<p>Total : </p>`;
          document.querySelector('.totalPriceValue').innerHTML = `${totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
          alert("Guitar Added");
        }






        // console.log('Guitar Quantity ' + quantityValue); used for debugging
        // console.log('Guitar Price ' + guitarInstance.Price * quantityValue); used for debugging




        const index = guitarOrders.findIndex(function (element) {
          return element.id === guitarId;
        });
        /*
         index has possible values:
         - (0) or higher signifying that it founds an existing guitarOrder
         - (-1) or others, signifying that it didn't find anything
        */


        // if the former happens, it will only increment the value witin the quantity property
        // the latter happens, it will create a new index of object
        if (index === -1) {
          guitarOrders.push({
            id: guitarInstance.GuitarID,
            name: `${guitarInstance.Brand} ${guitarInstance.Model}`,
            price: parseFloat(guitarInstance.Price),
            quantity: quantityValue
          });
        }



        // console.log("Guitar Quantity Array: ", guitarQuantities);
        console.log("Guitar Orders: ", guitarOrders);
      }



    } else {
      console.error('Error fetching guitar details:', myServerRequest.status);
    }
  };

  // Handle network errors
  myServerRequest.onerror = function () {
    console.error('Request failed.');
  };

  // Send the request
  myServerRequest.send();
}


// -------------------------------  QUANTITY OPERATIONS: ----------------------------------------------------------------
// Used for adding one quantity to the guitar
function itemAdding(guitarId, guitarOriginalPrice) {
  const index = guitarOrders.findIndex(function (element) {
    return element.id === guitarId;
  });
  /*
    index has possible values:
    - (0) or higher signifying that it has found an existing guitarOrder and now contains the index
    - (-1) or others, signifying that it didn't find anything
  */

  // if the former happens, this will execute; remember you are using !==, don't get confused pluck of sheet
  if (index !== -1) {
    // updated totalPrice shouldn't be place here because it will result to negative value

    // gets the 'property' (key : value) within guitarQuantites based on guitarId received
    // check if the value (quantity) within that key (guitarId) is equal or greater than 1
    if (guitarQuantities[guitarId] >= 1) {
      guitarQuantities[guitarId] += 1; // add 1 quantity on the value, since each click should only add 1
      guitarOrders[index].quantity = guitarQuantities[guitarId]; // updates the actual quantity
      // console.log("VALUE RNNN ", guitarQuantities[guitarId], guitarId);  
      console.log("Guitar Orders: ", guitarOrders);
      totalPrice = totalPrice + (parseFloat(guitarOriginalPrice) * quantityValue);
      document.querySelector('.totalPriceValue').innerHTML = `${totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.querySelector(`small[data-guitar-id="${guitarId}"]`).innerText = guitarQuantities[guitarId]; // this is the quantity text
      document.querySelector(`p[data-guitar-id="${guitarId}"]`).innerText =
        (parseFloat(guitarOriginalPrice) * guitarQuantities[guitarId]).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }); // this is the green text (price)

    }
  }
}


// Used for decrementing one quantity & if reacehd 0 remove the front-end updates alonmgside it
function itemRemover(guitarId, guitarOriginalPrice) {
  const divCardInstance = document.querySelector(`div[data-guitar-id="${guitarId}"`); // select the main card; this variable is used for removing the element if 0 quantity is found
  const index = guitarOrders.findIndex(function (element) {
    return element.id === guitarId;
  });
  /*
    index has possible values:
    - (0) or higher signifying that it has found an existing guitarOrder and now contains the index
    - (-1) or others, signifying that it didn't find anything
  */

  // if the former happens, this will execute; remember you are using !==, don't get confused pluck of sheet
  if (index !== -1) {
    // updated totalPrice shouldn't be place here because it will result to negative value

    // gets the 'property' (key : value) within guitarQuantites based on guitarId received
    // check if the value (quantity) within that key (guitarId) is equal or greater than 1
    if (guitarQuantities[guitarId] >= 1) {
      totalPrice -= guitarOrders[index].price;
      guitarQuantities[guitarId] -= 1; // removes 1 quantity on the value, since each click should only minus 1
      guitarOrders[index].quantity = guitarQuantities[guitarId]; // updates the actual quantity
      // console.log("VALUE RNNN ", guitarQuantities[guitarId], guitarId);
      document.querySelector('.totalPriceValue').innerHTML = `${totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.querySelector(`small[data-guitar-id="${guitarId}"]`).innerText = guitarQuantities[guitarId]; // this is the quantity text
      document.querySelector(`p[data-guitar-id="${guitarId}"]`).innerText =
        (parseFloat(guitarOriginalPrice) * guitarQuantities[guitarId]).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }); // this is the green text (price)

      // used for automatically removing the card element and the index if 0 quantity is found
      if (guitarQuantities[guitarId] === 0) {
        guitarOrders.splice(index, 1); // index is the actual index, 1 signifies that only one item can be removed
        divCardInstance.remove();
      }
    }
    // console.log("SLAYYYED AN ENEMY"); used for debugging
    // console.log("NEW ORDERRRS AT REMOVE FUNCTION ", guitarOrders); used for debugging
  }
}


// Remove the whole guitar "Trash Can btn"
function removedItemAsWhole(guitarId) {
  const divCardInstance = document.querySelector(`div[data-guitar-id="${guitarId}"`); // select the main card; this variable is used for removing the element if 0 quantity is found
  const index = guitarOrders.findIndex(function (element) {
    return element.id === guitarId;
  });

  /*
    index has possible values:
    - (0) or higher signifying that it has found an existing guitarOrder and now contains the index
    - (-1) or others, signifying that it didn't find anything
  */

  if (index !== -1) {

    if (guitarQuantities[guitarId] >= 1) {
      totalPrice -= (guitarOrders[index].price * guitarOrders[index].quantity);
      document.querySelector('.totalPriceValue').innerHTML = `${totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      guitarOrders.splice(index, 1); // removed the whole index
      delete guitarQuantities[guitarId]; // If `guitarQuantities` is a map-like object

      if (divCardInstance) {
        divCardInstance.remove();
        alert("Guitar Removed");
        console.log("Guitar order: ", guitarOrders);
      } else {
        console.warn(`No card instance found for guitarId: ${guitarId}`);
      }

      // console.log("Removed all", guitarOrders); used for debugging purposes
      // console.log("Remove alls", guitarQuantities); used for debugging purposes
    }
  }
}






// --------------------------------- USER MODAL OPERATIONS: ----------------------------------------------------------------
// Event listener for the "Select" buttons
document.querySelectorAll('.select-btn').forEach(button => {
  button.addEventListener('click', function () {
    // Find the row that contains the clicked button
    const row = this.closest('tr');

    // Extract values from the row
    const userIdInput = row.querySelector('th[user-id-col]').textContent.trim();
    const userFnameInput = row.querySelector('td[user-fname-col').textContent.trim();
    const userLnameInput = row.querySelector('td[user-lname-col').textContent.trim();
    const userEmailInput = row.querySelector('td[user-email-col]').textContent.trim();
    const userNumberInput = row.querySelector('td[user-number-col]').textContent.trim();

    // Set the values to the modal's input fields
    userIdValue = document.querySelector('input[data-user-id]').value = userIdInput;
    userFnameValue = document.querySelector('input[data-user-fname]').value = userFnameInput;
    userLnameValue = document.querySelector('input[data-user-lname]').value = userLnameInput;
    userEmailValue = document.querySelector('input[data-user-email]').value = userEmailInput;
    userNumberValue = document.querySelector('input[data-user-number]').value = userNumberInput;
  });
});


document.querySelector('.update-btn').addEventListener('click', function () {

  const userIdInput = document.querySelector('input[data-user-id]');
  const userFnameInput = document.querySelector('input[data-user-fname]');
  const userLnameInput = document.querySelector('input[data-user-lname]');
  const userEmailInput = document.querySelector('input[data-user-email]');
  const userNumberInput = document.querySelector('input[data-user-number]');

  // Set the values to the modal's input fields
  userIdValue = userIdInput.value.trim();
  userFnameValue = userFnameInput.value.trim();
  userLnameValue = userLnameInput.value.trim();
  userEmailValue = userEmailInput.value.trim();
  userNumberValue = userNumberInput.value.trim();

  if (userEmailValue && userNumberValue) {
    userUpdatingObject = {
      userDetail: {
        userId: userIdValue,
        user_fname: userFnameValue,
        user_lname: userLnameValue,
        email: userEmailValue,
        number: userNumberValue,
      }
    }

    userUpdating(userUpdatingObject);
  } else {
    alert("Ensure that all fields are filled before updating");
  }
});


document.querySelector('.proceed-btn').addEventListener('click', function () {

  const userIdInput = document.querySelector('input[data-user-id]');
  const userFnameInput = document.querySelector('input[data-user-fname]');
  const userLnameInput = document.querySelector('input[data-user-lname]');
  const userEmailInput = document.querySelector('input[data-user-email]');
  const userNumberInput = document.querySelector('input[data-user-number]');

  // Set the values to the modal's input fields
  userIdValue = userIdInput.value.trim();
  userFnameValue = userFnameInput.value.trim();
  userLnameValue = userLnameInput.value.trim();
  userEmailValue = userEmailInput.value.trim();
  userNumberValue = userNumberInput.value.trim();

  if (userEmailValue && userNumberValue) {
    document.querySelector('.customer-row').classList.remove('d-none');
    document.querySelector('.customer-row').innerHTML = `
    <h6>Selected user:</h6>
    <hr style="border: 1px solid #a0bbaf !important;">
    <div class="row" style="font-size: .8rem !important;">
      <div class="col-3 pe-0"
        <p>Name: </p>
        <p>Email: </p>
        <p>Number:</p>
      </div>
      <div class="col-8 ps-0">
        <p>${userFnameValue} ${userLnameValue}</p>
        <p>${userEmailValue}</p>
        <p>${userNumberValue}</p>
      </div>
    </div>
    
    
    `;
  }

});




// FILTERING SIDE / FILTER GUITARS
const searchGuitarInput = document.getElementById('searchGuitarAdmin-input');
const guitarCardDiv = document.querySelectorAll('.guitar-cards');
const brandCheckboxes = document.querySelectorAll('.brand-filter');
const modelCheckboxes = document.querySelectorAll('.model-filter');
const typeCheckboxes = document.querySelectorAll('.type-filter');
const fretboardCheckboxes = document.querySelectorAll('.fretboard-filter');
const neckCheckboxes = document.querySelectorAll('.neck-filter');
const bodyMaterialCheckboxes = document.querySelectorAll('.body-material-filter');
const bodyShapeCheckboxes = document.querySelectorAll('.body-shape-filter');
const stringsCheckboxes = document.querySelectorAll('.strings-filter');
const fretsCheckboxes = document.querySelectorAll('.frets-filter');

const minPriceInput = document.getElementById('minPrice');
const maxPriceInput = document.getElementById('maxPrice');

function filterGuitars() {
  const searchQuery = searchGuitarInput.value.toLowerCase();

  /*
  Get selected brands

  Array.from() convert an array like object into an actual array; The selector for brandCheckboxes uses querySelectorAll which returns nodelist that are array like. In order for this nodelist to use methods such as .filter and .map it has to be an actual array first.

  .filter(PARAMETER => RETURN those who are .checked) only select those checkboxes that are selected
  .map(PARAMETER => RETURN the values of these checkboxes and convert them to lowercase)
  */
  // gets the selected brands
  const selectedBrands = Array.from(brandCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  // gets the selected models
  const seletectedModel = Array.from(modelCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  // gets the selected type
  const selectedType = Array.from(typeCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  // Gets selected values for each new attribute
  const selectedFretboard = Array.from(fretboardCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  const selectedNeck = Array.from(neckCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  const selectedBodyMaterial = Array.from(bodyMaterialCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  const selectedBodyShape = Array.from(bodyShapeCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value.toLowerCase());

  const selectedStrings = Array.from(stringsCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value);

  const selectedFrets = Array.from(fretsCheckboxes)
    .filter(checkbox => checkbox.checked)
    .map(checkbox => checkbox.value);


  // Get price range values
  const minPrice = minPriceInput.value || 0;  // Default to 0 if empty
  const maxPrice = maxPriceInput.value || Infinity;  // Default to Infinity if empty


  guitarCardDiv.forEach(card => {
    const modelSearch = card.querySelector('.card-guitar-model').textContent.toLowerCase();
    const brandSearch = card.querySelector('.card-guitar-brand').textContent.toLowerCase();
    const brand = card.getAttribute('data-guitar-brand').toLowerCase(); // this two are <div> elements the card element and this as attribute
    const model = card.getAttribute('data-guitar-model').toLowerCase();
    const type = card.getAttribute('data-guitar-type').toLowerCase(); // this two are <div> elements the card element and this as attribute
    const fretboard = card.getAttribute('data-guitar-fretboard').toLowerCase();
    const neck = card.getAttribute('data-guitar-neck').toLowerCase();
    const bodyMaterial = card.getAttribute('data-guitar-body-material').toLowerCase();
    const bodyShape = card.getAttribute('data-guitar-body-shape').toLowerCase();
    const strings = card.getAttribute('data-guitar-strings');
    const frets = card.getAttribute('data-guitar-frets');
    const price = parseFloat(card.getAttribute('data-guitar-price'));  // Adjust selector if needed

    // Check if card matches search query, selected brands, selected types, and price range
    // THE REAL MAGIC LIES HERE
    /*
      These variables contains true or false depending on the situation but more of them are using OR operator which always returns true
    */
    const matchesSearch = modelSearch.includes(searchQuery) || brandSearch.includes(searchQuery) || type.includes(searchQuery);
    const matchesBrand = selectedBrands.length === 0 || selectedBrands.includes(brand);
    const matchesModel = seletectedModel.length === 0 || seletectedModel.includes(model);
    const matchesType = selectedType.length === 0 || selectedType.includes(type);
    const matchesFretboard = selectedFretboard.length === 0 || selectedFretboard.includes(fretboard);
    const matchesNeck = selectedNeck.length === 0 || selectedNeck.includes(neck);
    const matchesBodyMaterial = selectedBodyMaterial.length === 0 || selectedBodyMaterial.includes(bodyMaterial);
    const matchesBodyShape = selectedBodyShape.length === 0 || selectedBodyShape.includes(bodyShape);
    const matchesStrings = selectedStrings.length === 0 || selectedStrings.includes(strings);
    const matchesFrets = selectedFrets.length === 0 || selectedFrets.includes(frets);

    const matchesPrice = price >= minPrice && price <= maxPrice; // UNDERSTAND BOTH OF THESE


    // Show card if all conditions are met
    // So this statement will always return TRUE event if its using AND operator since the value being compared uses OR
    card.style.display = matchesSearch && matchesBrand && matchesModel && matchesType && matchesFretboard && matchesNeck && matchesBodyMaterial && matchesBodyShape && matchesStrings && matchesFrets && matchesPrice ? 'block' : 'none';
  });
}

// Add event listeners for search bar, checkboxes, and price inputs
searchGuitarInput.addEventListener('keyup', filterGuitars);
brandCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars)); // this is the node list using forEach() array. The foreach ensure that each node has event listener and every time the nodelist's node triggers a change "checked" or "unchecked", since these are check boxes, it will triggers the filterGuitars() function.
modelCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
typeCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
fretboardCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
neckCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
bodyMaterialCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
bodyShapeCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
stringsCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));
fretsCheckboxes.forEach(checkbox => checkbox.addEventListener('change', filterGuitars));

minPriceInput.addEventListener('input', filterGuitars);
maxPriceInput.addEventListener('input', filterGuitars);




// The main reason why this function is a mix & match of multiple proccesses can be explain on placingOrder.php
function placeOrder() {
  if (guitarOrders.length === 0) {
    alert("Your cart is empty!");
    return;
  }

  // TRIGGERS WHEN PLACE ORDER IS CLICKED & REDUCES THE QUANTITY !!!!!
  const guitarSubtractingStock = new XMLHttpRequest();
  guitarSubtractingStock.open('POST', '../php/placingOrder.php', true);

  /* 
  By setting the Content-Type to application/json, you're informing the server that the data you are sending (e.g., a JSON string) 
  should be treated as JSON. This is important for the server to correctly parse and process the incoming data.

  SAMPLE !!!!! BEFORE SENDING
  [
    { id: 1, name: "Guitar A", price: 200, quantity: 2 },
    { id: 2, name: "Guitar B", price: 300, quantity: 1 }
  ]

  THE RECEIVED FORMAT ARE ON THE placingOrder.php FILE
   */

  guitarSubtractingStock.setRequestHeader('Content-Type', 'application/json'); // Sending JSON data

  // Log the guitarOrders array to verify it has the correct data
  // console.log("Placing order with items:", guitarOrders); used for debugging

  // This should be placed inside here not at the top as global; When the code runs it automatically gets the .value of the amountPaidInput however by that time the input doesnt have value yet, but still asigns the value to amountPaidValue, resulting in an <empty string> and redenring it useless
  const amountPaidInput = document.querySelector('input[bayadKoPo]'); // get the amound given by the user
  let amountPaidValue = amountPaidInput.value;




  if (userFnameValue && userLnameValue && userEmailValue && userNumberValue) {
    if (amountPaidValue >= totalPrice) {
      // Handling the server's response
      guitarSubtractingStock.onload = function () {
        if (guitarSubtractingStock.status >= 200 && guitarSubtractingStock.status < 400) {
          try {
            const response = JSON.parse(guitarSubtractingStock.responseText);
            // NEWLY ADDED
            // Check if all orders succeeded
            const allSuccess = response.every((order) => order.success);

            if (allSuccess) {
              alert("Order placed successfully!");
              // Optionally, clear the guitarOrders array and reset the UI
              // guitarOrders = [];
              // document.querySelector('.ordered-items').innerHTML = '';
              // document.querySelector('.item-prices').innerHTML = '';
            } else {
              // Handle partial or complete failure
              const failedOrders = response.filter((order) => !order.success);
              const errorMessages = failedOrders.map((order) => `${order.message} (Guitar ID: ${order.guitarId})`);
              alert(`Failed to place order for the following items:\n${errorMessages.join("\n")}`);
            }
          } catch (error) {
            console.log('Error parsing JSON:', error);
          }
        } else {
          console.log("Not enough guitar stocks");
          console.error('Error placing order:', guitarSubtractingStock.status);
        }
      };

      // Handle network errors
      guitarSubtractingStock.onerror = function () {
        console.error('Having Network Error:', guitarSubtractingStock.error);
      };

      // Send the `guitarOrders` array as JSON to the server
      guitarSubtractingStock.send(JSON.stringify(guitarOrders));

      // READY THE VARIABLES FOR TRANSACTION TABLE
      let change = amountPaidValue - totalPrice;

      orderData = {
        guitarOrders: guitarOrders, // The array of guitar orders
        transactionDetails: { // Transaction-related details
          employee_id: employeeId,
          employee_name: employeeName,
          amount_due: totalPrice,
          amount_paid: amountPaidValue,
          sukli: change,
        },
        userDetail: {
          userId: userIdValue,
          user_fname: userFnameValue,
          user_lname: userLnameValue,
          email: userEmailValue,
          number: userNumberValue,
        }
      };











      // RESPONSIBLE FOR ADDING / INSERTING TO THE TRANSACTION
      const myTransactionPosting = new XMLHttpRequest();
      myTransactionPosting.open('POST', '../php/transactionAdding.php', true);
      myTransactionPosting.setRequestHeader('Content-Type', 'application/json'); // Sending JSON data

      // console.log("Sucesssss", JSON.stringify(orderData)); Debugging purposes

      myTransactionPosting.onload = function () {
        console.log('Raw server response:', myTransactionPosting.responseText); // Log the raw response for debugging
        if (myTransactionPosting.status >= 200 && myTransactionPosting.status < 400) {
          try {
            const transactionResponse = JSON.parse(myTransactionPosting.responseText);
            // Just added additional conditional block for checking if last transaction id is korique
            if (transactionResponse.success) {
              console.log(orderData.userDetail);
              const retrievedTransactionId = transactionResponse['transactionId'];
              console.log('Transaction ID:', retrievedTransactionId);

              orderData.transactionDetails.transactionId = retrievedTransactionId; // adds new property on orderData array of object; this is received and used for printing receipt
              receiptPrinter(orderData);
            } else {
              console.error('Transaction failed:', transactionResponse.message);
            }
          } catch (error) {
            console.log('Error parsing JSON for Transaction side: ', error);
          }
        } else {
          console.error('Error processing transaction:', myTransactionPosting.status);
        }
      };

      // Handle network errors
      myTransactionPosting.onerror = function () {
        console.error('Network error while placing order');
      };

      // Send the `guitarOrders` array as JSON to the server
      myTransactionPosting.send(JSON.stringify(orderData));









      // RESPONSIBLE FOR UPDATING THE USER PURCHASE_STATUS COLUMN
      const userUpdatingPurchaseStatus = new XMLHttpRequest();
      userUpdatingPurchaseStatus.open('POST', '../php/customerUpdatingPurchaseStatus.php', true);
      userUpdatingPurchaseStatus.setRequestHeader('Content-Type', 'application/json'); // Sending JSON data

      // console.log("Sucesssss", JSON.stringify(orderData)); Debugging purposes

      userUpdatingPurchaseStatus.onload = function () {
        console.log('Raw server response:', userUpdatingPurchaseStatus.responseText); // Log the raw response for debugging
        if (userUpdatingPurchaseStatus.status >= 200 && userUpdatingPurchaseStatus.status < 400) {
          try {
            const userUpdatingResponse = JSON.parse(userUpdatingPurchaseStatus.responseText);
            // Just added additional conditional block for checking if last transaction id is korique
            if (userUpdatingResponse.success) {
              console.log('Updating purchase status: ', userUpdatingResponse);
            } else {
              console.error('Updating purchase status failed:', userUpdatingResponse.message);
            }
          } catch (error) {
            console.log('Error parsing JSON for Updating purchase status side: ', error);
          }
        } else {
          console.error('Error processing updating purchase side:', userUpdatingPurchaseStatus.status);
        }
      };

      // Handle network errors
      userUpdatingPurchaseStatus.onerror = function () {
        console.error('Network error while placing order');
      };

      // Send the `orderData` array as JSON to the server
      userUpdatingPurchaseStatus.send(JSON.stringify(orderData));


    } else if (amountPaidValue < totalPrice) {
      alert("Insufficient amount");
    }
  } else {
    alert("No user Information Indicated at Modal");
  }


}






function receiptPrinter(orderedDataParameter) {
  const receiptPrinter = new XMLHttpRequest();
  receiptPrinter.open('POST', '../php/receiptPrinter.php', true);
  receiptPrinter.setRequestHeader('Content-Type', 'application/json');

  // Set response type to 'blob' to handle binary PDF data
  receiptPrinter.responseType = 'blob'; // Added by GPT

  // Event handler for successful data load
  receiptPrinter.onload = function () {
    if (receiptPrinter.status >= 200 && receiptPrinter.status < 400) {
      try {
        // Create a blob link to download or view the PDF
        const blob = new Blob([receiptPrinter.response], { type: 'application/pdf' }); // Added by GPT
        const url = URL.createObjectURL(blob); // Added by GPT
        if (!isReceiptBtnAppeared) {
          document.querySelector('.receipt-generate-container').innerHTML += `
            <a href="${url}" class="d-none d-sm-inline-block btn brown-button shadow-sm w-100" target="_blank">
              <i class="fas fa-download fa-sm text-white-50"></i> Generate Receipt
            </a>
          `;
          isReceiptBtnAppeared = true;
        }


      } catch (e) {
        console.log("Could not parse server response as JSON:", receiptPrinter.responseText);
      }
    } else {
      console.log("Error: No receipt generated.");
    }
  };

  // Network error handler
  receiptPrinter.onerror = function () {
    console.log("Network error while printing the receipt");
  };

  // Send the JSON data to the server
  receiptPrinter.send(JSON.stringify(orderedDataParameter));
}







function userUpdating(orderedDataParameter) {
  // Responsible for updating user's information
  const userUpdating = new XMLHttpRequest();
  userUpdating.open('POST', '../php/customerUpdating.php', true);
  userUpdating.setRequestHeader('Content-Type', 'application/json');

  userUpdating.onload = function () {
    if (userUpdating.status >= 200 && userUpdating.status < 400) {
      try {
        // Log the raw response to verify if it's in JSON format
        console.log("Server response:", userUpdating.responseText);

        // Attempt to parse JSON
        const userUpdating_response = JSON.parse(userUpdating.responseText);

        if (userUpdating_response.success) {

          // Not needed; but incase of error undo
          // Repsonsible for retrieving the new userID and automatically displaying it on input[data-user-id]
          // const retrieveduserId = userUpdating_response['userId'];
          // const userIdInput = document.querySelector('input[data-user-id]');
          // userIdInput.value = retrieveduserId;
          // userIdValue = userIdInput.value;

          alert("Customer information updated");
        } else {
          alert("No selected customer");
          console.log("Adding new user failed:", userUpdating.responseText);
        }
      } catch (error) {
        console.log('Error parsing JSON for user Updating side:', error);
      }
    } else {
      console.error('Error processing transaction:', userUpdating.status);
    }
  };

  // Handle network errors
  userUpdating.onerror = function () {
    console.error('Network error while placing order');
  };

  // Send the `orderedDataParameter` array as JSON to the server
  userUpdating.send(JSON.stringify(orderedDataParameter));
}