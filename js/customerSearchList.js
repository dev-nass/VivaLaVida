
const userSearchInput = document.querySelector('input[data-user-search]');
const userRows = document.querySelectorAll('.userRow');

function filteruser() {
  const userSearchBar = userSearchInput.value.toLowerCase();

  userRows.forEach(row => {
    const userIdCol = row.querySelector('th[user-id-col]').textContent.toLowerCase();
    const userEmailCol = row.querySelector('td[user-email-col]').textContent.toLowerCase();
    const cumstomerNumberCol = row.querySelector('td[user-number-col]').textContent.toLowerCase();
    const customerPurchaseStatus = row.querySelector('td[user-purchase-status-col]').textContent.toLocaleLowerCase();

    const matchesSearch = userIdCol.includes(userSearchBar) || userEmailCol.includes(userSearchBar) || cumstomerNumberCol.includes(userSearchBar) || customerPurchaseStatus.includes(userSearchBar);

    row.style.display = matchesSearch ? '' : 'none';
  });
}

userSearchInput.addEventListener('keyup', filteruser); // function here should call without parenthesis