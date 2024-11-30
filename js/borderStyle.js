
// USED FOR ADDING COLORED BORDER FOR THE CARD BODY TO THE ADDED GUITAR

const cardGroup = document.querySelectorAll('.card-group'); // used for selecting child and iteration of the children
const placeOrderContainer = document.querySelector('.place-order-container'); // used for removing d-none


cardGroup.forEach(card => {
  const selectItemBtnInstance = card.querySelector('.addItem'); // the selected item after click "Select Item" button
  const btnsContainer = card.querySelector('.btn-displayer'); // instace of container of quantity buttons and inputs
  
  const addItemBtnInstance = card.querySelector('.border-giver'); // border color / "Add Item" button
  const individualCard = card.querySelector('.card'); // card Instance

  // If the "Add Item" is clicked this will happen 
  addItemBtnInstance.addEventListener("click", function() {
    individualCard.classList.add('darkBorder');
    placeOrderContainer.classList.remove('d-none');
  });
});