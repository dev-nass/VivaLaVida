
// RESPONSIBLE FOR ADDING THE QUANTITY

// UNDERSTAND ALSO THIS CODE
// JavaScript
const items = document.querySelectorAll('.quantity-container'); // Select all items

items.forEach(item => {
  const minusBtn = item.querySelector('.minus');
  const addBtn = item.querySelector('.add');
  const quantityCount = item.querySelector('.quantity-count');

  let quantityValue = 0; // Local quantity for this item

  minusBtn.addEventListener("click", function() {
    if (quantityValue > 1) { // Prevent going below 1
      quantityValue--;
      quantityCount.value = quantityValue;
    }
  });

  addBtn.addEventListener("click", function() {
    // addBtn.style.color = "red";
    quantityValue++;
    quantityCount.value = quantityValue;
  });
});
