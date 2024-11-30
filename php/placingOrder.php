<?php

include "../php/connection.php";


/*
WHOLE FILE IS REPONSIBLE FOR DECREMENTING THE STOCKS:

Get the JSON input from the request:
  •  When you send a JSON payload in a POST request, the data is typically included in the body of the request rather than as URL parameters.
    > The "php://input" stream allows you to access this raw data directly.
    > This is especially useful when the Content-Type of the request is set to application/json, as is the case in your earlier example.

  • The variable $input now contains the raw JSON string sent from the client-side (e.g., your JavaScript code). 
  This string represents the data that the client has sent to the server.
*/
$input = file_get_contents("php://input");

/*
• The first parameter is the JSON string ($input), and the second parameter is a boolean (TRUE in this case) 
  that specifies whether to convert the resulting object into an associative ARRAY.

  SAMPLE !!!!! AFTER RECEIVING AND CONVERTING TO ASSOCIATIVE ARRAY
  [
    ['id' => 1, 'name' => 'Guitar A', 'price' => 200, 'quantity' => 2],
    ['id' => 2, 'name' => 'Guitar B', 'price' => 300, 'quantity' => 1],
  ]

*/
$guitarOrders = json_decode($input, true);

$response = [];

if (!empty($guitarOrders)) {
  foreach ($guitarOrders as $order) {
    $guitarId = (int) $order['id']; // converting the data types to int
    $quantity = (int) $order['quantity']; // converting the data types to int

    // Retrieve current stock
    $stmt = $pdo->prepare("SELECT Stocks FROM guitar WHERE GuitarID = :id");
    $stmt->bindParam(':id', $guitarId, PDO::PARAM_INT);
    $stmt->execute();
    $guitar = $stmt->fetch(PDO::FETCH_ASSOC); // fetch and arrange the data into ASSOCIATIVE ARRAY

    if ($guitar) {
      $currentStock = (int) $guitar['Stocks'];

      // Check if enough stock is available
      if ($currentStock >= $quantity) {
        // Subtract quantity and update stock
        $newStock = $currentStock - $quantity;
        $updateStmt = $pdo->prepare("UPDATE guitar SET Stocks = :newStock WHERE GuitarID = :id");
        $updateStmt->bindParam(':newStock', $newStock, PDO::PARAM_INT);
        $updateStmt->bindParam(':id', $guitarId, PDO::PARAM_INT);
        $updateStmt->execute();

        $response[] = ['guitarId' => $guitarId, 'success' => true, 'message' => 'Stock updated'];
      } else {
        $response[] = ['guitarId' => $guitarId, 'success' => false, 'message' => 'Not enough stock'];
      }
    } else {
      $response[] = ['guitarId' => $guitarId, 'success' => false, 'message' => 'Guitar not found'];
    }
  }
} else {
  $response[] = ['success' => false, 'message' => 'No items received'];
}

echo json_encode($response);
