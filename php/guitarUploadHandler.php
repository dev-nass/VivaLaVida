<?php

include "../php/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    // gets the inputs by their names
    $brand = $_POST["guitarBrandInput"];
    $model = $_POST["guitarModelInput"];
    $type = $_POST["guitarTypeInput"];
    $fretboardMat = $_POST["fretboardMaterialInput"];
    $neckMat = $_POST["neckMaterialInput"];
    $bodyMat = $_POST["bodyMaterialInput"];
    $bodyShape = $_POST["bodyShapeInput"];
    $numOfStrings = $_POST["numberOfStringsInput"];
    $numOfFrets = $_POST["numberOfFretsInput"];
    $price = $_POST["guitarPriceInput"];
    $stocks = $_POST["guitarStocksInput"];
    $description = $_POST['guitarDescriptionInput'];

    /*
      GUITAR IMAGE HANDLER:
  
      - $_FILES is a superglobal array in PHP that is automatically populated when a form with the attribute enctype="multipart/form-data" is submitted and contains file inputs.
      - temp_name is a KEY in this array that stores the file in temporary file path.
      - $_FILES['guitarImageInput']['name'] contains the original file name that was uploaded (e.g., guitar.jpg).
      - hence, $guitarImg will hold the value "/tmp/php1234.tmp" (the temporary file path), which you can then use to move the file to its final destination using move_uploaded_file().
    */

    $guitarImg = $_FILES["guitarImageInput"]["tmp_name"];
    // $guitarImgName = $_FILES["guitarImageInput"]["name"]; Original file name
    $target_dir = "../image retrieverv2/guitar gallery/";
    $target_file = $target_dir . basename($_FILES["guitarImageInput"]["name"]);

    // Ensure target directory exists and is writable
    if (!is_dir($target_dir)) {
      mkdir($target_dir, 0777, true);
    }

    // UPLOADS THE FILES TO SERVER DIRERCTORY
    if (move_uploaded_file($guitarImg, $target_file)) {

      $checkGuitarSql = "SELECT Brand, Model FROM guitar WHERE Brand = :brand AND Model = :model";
      $checkStmt = $pdo->prepare($checkGuitarSql);
      $checkStmt->execute([
        ":brand" => $brand,
        ":model" => $model,
      ]);

      if($checkStmt->rowCount() > 0) {
        echo json_encode([
          'status' => 'error', // Changed to 'error' for consistency
          'message' => 'Guitar already exist'
        ]);
      } else {
        // insert into database
        $sql = "INSERT INTO guitar (Brand, Model, Type, Fretboard_Material, Neck_Material, Body_Material, Body_Shape, Number_of_Strings, Number_of_Frets, Price, Stocks, Guitar_Picture, Description) VALUES (:Brand, :Model, :Type, :FretboardMat, :NeckMat, :BodyMat, :BodyShape, :Strings, :Frets, :Price, :Stocks, :GuitarPic, :Description)";
        $stmt = $pdo->prepare($sql);

        $stmt->execute([
          ":Brand" => $brand,
          ":Model" => $model,
          ":Type" => $type,
          ":FretboardMat" => $fretboardMat,
          ":NeckMat" => $neckMat,
          ":BodyMat" => $bodyMat,
          ":BodyShape" => $bodyShape,
          ":Strings" => $numOfStrings,
          ":Frets" => $numOfFrets,
          ":Price" => $price,
          ":Stocks" => $stocks,
          ":GuitarPic" => $target_file,
          ":Description" => $description,
        ]);

        echo json_encode([
          'status' => 'success',
          'message' => 'Guitar has been uploaded successfully.'
        ]);
      } 
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Error uploading image.'
      ]);

      
    }
  } catch (PDOException $e) {
    echo json_encode([
      'status' => 'error',
      'message' => 'Database error: ' . $e->getMessage()
    ]);
  }
}
