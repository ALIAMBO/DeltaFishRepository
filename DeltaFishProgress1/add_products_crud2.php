<?php

include_once 'db.php';

$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$extention = ['gif','jpg', 'jpeg',];
function uploadPhoto($file, $id)
{
  global $extention;
  $target_dir = "pictures_sell/";
  $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));
  
  $newfilename = "{$id}.{$imageFileType}";

  if ($file['error'] == 4)
    return 4;
    // Check if image file is a actual image or fake image
  if (!getimagesize($file['tmp_name']))
    return 0;
    // Check file size
  if ($file["size"] > 10000000)
    return 1;
    // Allow certain file formats
  if (!in_array($imageFileType, $extention))
    return 2;

  if (!move_uploaded_file($file["tmp_name"], $target_dir.$newfilename))
    return 3;

  return array('status' => 200, 'name' => $newfilename, 'ext' => $imageFileType);
}

//Create
if (isset($_POST['create'])) {
  // if ($_SESSION['ulevel'] == 'Admin')  {
    $uploadStatus = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);
    if (isset($uploadStatus['status'])) {
      try {

   $stmt = $conn->prepare("INSERT INTO tbl_productsell_delta(ID, NAME, PRICE, DESCRIPTION, STOCK, PICTURE) VALUES(:pid, :name, :price, :description, :stock, :image )");


      $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
      $stmt->bindParam(':image', $uploadStatus['name']);

    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description =  $_POST['description'];
    $stock = $_POST['stock'];

    $stmt->execute();
      }
      catch(PDOException $e){
        $_SESSION['error'] = "Error while Creating: " . $e->getMessage();
      }
    } else {
      if ($uploadStatus == 0)
        $_SESSION['error'] = "Please make sure the file uploaded is an image.";
      elseif ($uploadStatus == 1)
        $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
      elseif ($uploadStatus == 2)
        $_SESSION['error'] = "Sorry, only ".join(", ",$extention)." files are allowed.";
      elseif ($uploadStatus == 3)
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
      elseif ($uploadStatus == 4)
        $_SESSION['error'] = 'Please upload an image.';
      elseif ($uploadStatus == 5)
        $_SESSION['error'] = 'File already exists. Please rename your file before upload.';
      else
        $_SESSION['error'] = "An unknown error has been occurred.";
    }
  // } else {
  //   $_SESSION['error'] = "Sorry, but you don't have permission to create a new product.";
  //}
  header("LOCATION: sellerhome.php");
  exit();
}

//Update

if (isset($_POST['update'])) {
  // if ($_SESSION['ulevel'] == 'Admin')  {
    try {
    $stmt = $conn->prepare("UPDATE tbl_productsell_delta SET ID = :pid,NAME = :name, PRICE = :price, DESCRIPTION = :description, STOCK = :stock
        WHERE ID = :oldpid");
     
      $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
      $stmt->bindParam(':name', $name, PDO::PARAM_STR);
      $stmt->bindParam(':price', $price, PDO::PARAM_INT);
      $stmt->bindParam(':description', $description, PDO::PARAM_STR);
      $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);
      $stmt->bindParam(':oldpid', $oldpid, PDO::PARAM_STR);
       
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description =  $_POST['description'];
    $stock = $_POST['stock'];
    $oldpid = $_POST['oldpid'];

    $stmt->execute();

    // header("Location: products.php");

      $flag  = uploadPhoto($_FILES['fileToUpload'], $_POST['pid']);

      if (isset($flag['status'])){
        $stmt = $conn->prepare("UPDATE tbl_productsell_delta SET PICTURE = :image WHERE ID = :pid LIMIT 1");
        $stmt->bindParam(':image', $flag['name']);
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
        //kt product.php line 138
        if(pathinfo(basename($_POST['filename']), PATHINFO_EXTENSION)!=$flag['ext'])
          unlink("pictures_sell/{$_POST['filename']}");
      } elseif ($flag != 4) {
        if ($flag == 0)
          $_SESSION['error'] = "Please make sure the file uploaded is an image.";
        elseif ($flag == 1)
          $_SESSION['error'] = "Sorry, only file with below 10MB are allowed.";
        elseif ($flag == 2)
          $_SESSION['error'] = "Sorry, only ".join(", ",$extention)." files are allowed.";
        elseif ($flag == 3)
          $_SESSION['error'] = "Sorry, there was an error uploading your file.";
        else
          $_SESSION['error'] = "An unknown error has been occurred.";
      }
      clearstatcache();//saja sebab kadang2 tk clear cache
    }
    catch(Exception $e){
      $_SESSION['error'] = "Error while Updating: " . $e->getMessage();
    }
 // }
  // else {
  //   $_SESSION['error'] = "Sorry, but you don't have permission to update this product.";
  //   header("LOCATION: {$_SERVER['PHP_SELF']}");
  //   exit();
  // }

  if (isset($_SESSION['error']))
    header("LOCATION: {$_SERVER['REQUEST_URI']}");
  else
    header("Location: sellerhome.php");
  exit();
}

//Delete
if (isset($_GET['delete'])) {
  // if ($_SESSION['ulevel'] == 'Admin')  {
    try {
      $pid = $_GET['delete'];
      $query = $conn->query("SELECT PICTURE FROM tbl_productsell_delta WHERE ID = '{$pid}' LIMIT 1")->fetch(PDO::FETCH_ASSOC);
      if (isset($query['PICTURE'])) {
      // Delete Query
        $stmt = $conn->prepare("DELETE FROM tbl_productsell_delta WHERE ID = :pid");
        $stmt->bindParam(':pid', $pid);
        $stmt->execute();
      // Delete Image
        unlink("pictures_sell/{$query['PICTURE']}");
      }
    }
    catch(PDOException $e)
    {
      $_SESSION['error'] = "Error while Deleting: " . $e->getMessage();
    }
  // } else {
  //   $_SESSION['error'] = "Sorry, but you don't have permission to delete this product.";
  // }
  header("LOCATION: {$_SERVER['PHP_SELF']}");
  exit();
}


//Edit
if (isset($_GET['edit'])) {

  try {

    $stmt = $conn->prepare("SELECT * FROM tbl_productsell_delta WHERE ID = :productid");

    $stmt->bindParam(':productid', $pid, PDO::PARAM_STR);

    $pid = $_GET['edit'];

    $stmt->execute();

    $editrow = $stmt->fetch(PDO::FETCH_ASSOC);
  }

  catch(PDOException $e)
  {
    echo "Error: " . $e->getMessage();
  }
}

$conn = null;
?>