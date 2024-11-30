# Files Overview
### Admin Side
- (<code>adminCLI.php</code>) used for creating admin account.
- (<code>orderingGuitar.php</code>) is for the actual POS.
- (<code>guitarUploadingForrm.php</code>) is for adding new guitar.
- (<code>employeeAdding.php</code>) (only for admin) is for adding new employee
- (<code>guitarTablePage.php</code>) is for (Read, Edit, Delete) of guitars.
- (<code>guitarTablePagePrice&Sto</code>)cks.php is extension of the former, but for stocks and price.
- (<code>orderViewTable.php</code>) is for visual representation of urder table.
- (<code>transactionViewTable.php</code>) is the same as the former, but for transaction table.
- (<code>customerViewTable.php</code>) same but for customer.

# Registration & Logging in:
- Username & Email can use for logging in. The code is altered so that the process for
creating Employee or User acc detects whether the username or the email is already existing in
either table, but its exsistence not explicitly indicated.
- The data instances are now used for dynamic nav bar contents.
- Additional <code>$_SESSION[]</code> are also added for email and password not just for username; At the Admin side these instances of data are used for getting the EmployeeID. The ID is used for transaction table as FK and the username as content for the receipt.



# Core Learning
- implement <code>Picture</code>, <code>Source</code> & <code>img</code> enabling different picture to be shown on different screen sizes.
- Always plays the <code>script</code> tags at the very bottom.
- Understand the concpet behind searching / filtering that is applied through JS.
- Understand the MySQL especially the one at the guitarTable
- You cannot use splice to an object{}, instead use <code>delete</code>. Used for guitarOrder[] and guitarQuantities{}
- Attribute for only accepting the specified file type for (<input type="file">) <code>accept="image/png, image/jpeg"</code>


# Reusable Code
- Allow text only <code>oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');"</code>
- Text only with space <code>oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');"</code>
- Number only  <code>oninput="this.value = this.value.replace(/[^0-9 ]/g, '');"</code>
- For contact number (number, and some special characters) <code>oninput="this.value = this.value.replace(/[^0-9+\-() ]/g, '');"</code>

# Additional Tasks
- All images should be 500x500.
- Add to cart and wishlist.
- Most order is counting the total rows a guitarid is shown not the total quantity
- total order has an issue

- Quantity per index still not updating

- Chanage the Custom JS (TableData) of <code>orderTable.php & transactionViewTable.php & customerViewTable.php</code> if sir denied the request and instructed you should have action btns.

# Sir Borg Pending Questions
- What are the relationship to be followed in UPDATE & DELETE; These are the RESTRICT, NULL, CASCADE.
- It okay to implement that kind of search. For instance 20, instead of prioritizing the 20 transactionID it also includes the date (2024)
- What did sir mentioned about the password hashing