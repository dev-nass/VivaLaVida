
<?php

  // the argument is received from admin / orderingGuitar.php
  // // UNDERSTAND THIS CODE  

  // getGuitarDetails.php

  // Database connection (replace with your actual connection setup)
  include "../php/connection.php";

  // Get the guitar ID from the AJAX request
  /* 
  • After receiving the data it request the ID from the URL is retrieved and converts to INT
  • However if it didn't retrieve anything it will set it to 0.
  */
  $guitarId = isset($_GET['GuitarID']) ? (int) $_GET['GuitarID'] : 0;

  if ($guitarId > 0) {
    // Fetch the guitar details from the database
    $stmt = $pdo->prepare("SELECT * FROM guitar WHERE GuitarID = :id");
    $stmt->bindParam(':id', $guitarId, PDO::PARAM_INT);
    $stmt->execute();

    $guitar = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return the data requested in JSON format
    // if the guitar is TRUTHY or it contains a valid data
    if ($guitar) {
      /*
      CONVERT THIS; In short, it convert it into JSON format
      • ['GuitarID' => 1, 'Name' => 'Fender Stratocaster', 'Price' => 1200]
        into
      • {"GuitarID":1,"Name":"Fender Stratocaster","Price":1200}
      */
      echo json_encode($guitar);
    } else {
      /*
      If no valid guitar data is found, this line creates an associative array with an 
        error message: ['error' => 'Guitar not found'].
      This array is then converted into a JSON string using json_encode(), and sent back as the response to the client.
        the output would be: {"error":"Guitar not found"}
      */ 
      echo json_encode(['error' => 'Guitar not found']);
    }
  } else {
    echo json_encode(['error' => 'Invalid guitar ID']);
  }
  ?>