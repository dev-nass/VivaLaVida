/*
  THE PROCESS GOES LIKE THIS:
  1. Select the elements
  2. Adds an event listener to these elements
  3. Use the filterGuitars() functions each time a change occurs within these elements
*/


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

// Trigger filterGuitars once the page loads
document.addEventListener('DOMContentLoaded', filterGuitars);