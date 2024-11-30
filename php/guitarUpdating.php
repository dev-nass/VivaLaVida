<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../php/connection.php';

// Get POST data
$guitar_id = $_POST['guitarId'];
$guitar_type = $_POST['guitarType'];
$guitar_brand = $_POST['guitarBrand'];
$guitar_model = $_POST['guitarModel'];
$guitar_freboard = $_POST['guitarFretBoardMat'];
$guitar_neck = $_POST['guitarNeckMat'];
$guitar_body_mat = $_POST['guitarBodyMat'];
$guitar_body_shape = $_POST['guitarBodyShape'];
$guitar_num_string = $_POST['guitarNumOfStrings'];
$guitar_num_frets = $_POST['guitarNumOfFrets'];
$guitar_description = $_POST['guitarDescription'];

// Handle the uploaded image
$guitarPicPath = null;
if (isset($_FILES["guitarImage"]) && $_FILES["guitarImage"]["error"] === UPLOAD_ERR_OK) {
  $guitar_image = $_FILES["guitarImage"]["tmp_name"];
  $target_dir = "../image retrieverv2/guitar gallery/";
  $target_file = $target_dir . basename($_FILES["guitarImage"]["name"]);

  // Ensure target directory exists and is writable
  if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
  }

  // Upload the file if provided
  if (move_uploaded_file($guitar_image, $target_file)) {
    $guitarPicPath = $target_file;
  } else {
    echo json_encode(['status' => 'error', 'message' => 'Error uploading image.']);
    exit;
  }
}

error_log("guitarId: " . $_POST['guitarId']);
error_log("guitarType: " . $_POST['guitarType']);

// Update query with $guitarPicPath and description
$sql = "UPDATE guitar SET 
    Type = :type, 
    Brand = :brand,
    Model = :model,
    Guitar_Picture = COALESCE(:guitarPic, Guitar_Picture),
    Fretboard_Material = :fretboardmat,
    Neck_Material = :neckmat,
    Body_Material = :bodymat,
    Body_Shape = :bodyshape,
    Number_of_Strings = :numstring,
    Number_of_Frets = :numfrets,
    Description = :description
WHERE GuitarID = :id";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $guitar_id);
$stmt->bindParam(":type", $guitar_type);
$stmt->bindParam(":brand", $guitar_brand);
$stmt->bindParam(":model", $guitar_model);
$stmt->bindParam(":guitarPic", $guitarPicPath);
$stmt->bindParam(":fretboardmat", $guitar_freboard);
$stmt->bindParam(":neckmat", $guitar_neck);
$stmt->bindParam(":bodymat", $guitar_body_mat);
$stmt->bindParam(":bodyshape", $guitar_body_shape);
$stmt->bindParam(":numstring", $guitar_num_string);
$stmt->bindParam(":numfrets", $guitar_num_frets);
$stmt->bindParam(":description", $guitar_description);

// Execute the update and handle response
if ($stmt->execute()) {
  echo json_encode(['success' => true, 'message' => 'Guitar updated successfully']);
} else {
  echo json_encode(['success' => false, 'message' => 'Failed to update guitar']);
}
