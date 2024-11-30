<?php

// NOTE USED ANYMORE

include 'php/connection.php';

try {
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to sum up total sales per month based on transaction date
    $stmt = $pdo->prepare("
        SELECT DATE_FORMAT(transaction.Transaction_Date, '%Y-%m') AS month, SUM(urder.Total_Price) AS total_sales
        FROM `Transaction`
        JOIN `urder` ON Transaction.id = urder.Transaction_ID
        GROUP BY month
        ORDER BY month ASC
    ");
    
    

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    var_dump($data);
    echo json_encode($data);

} catch(PDOException $e) {
    echo 'Connection Failed: ' . $e->getMessage();
}
?>
