

<?php

# USED BY RIGHT CONTENT userUpdatingPurchaseStatus()
# Codes sole purpose is to update the Purchase_Status to Walk-In

include '../php/connection.php';

$input = file_get_contents("php://input"); // receive the data from JS
$guitarOrders = json_decode($input, true);

$newuserInformation = $guitarOrders['userDetail'];
$userId = isset($newuserInformation['userId']) ? (int) $newuserInformation['userId'] : 0;

if ($userId === 0) {
    // Handle invalid or missing userId
    echo json_encode(['success' => false, 'message' => 'Invalid user ID']);
    exit;
}

try {
    $purchaseStatus = "Walk-in";
    $updateSql = "UPDATE user
                  SET Purchase_Status = :purchase_status 
                  WHERE User_ID = :userid";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindParam(":purchase_status", $purchaseStatus);
    $updateStmt->bindParam(":userid", $userId);

    if ($updateStmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Updating purchase status done'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No rows updated. Either User_ID is invalid or Purchase_Status is already "Walk-In".'
        ]);
    }
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}


?>