<?php
  include_once 'add_products_crud2.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="shortcut icon" href="img/lifestyleStore.png" />
        <title>DFOBB</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- latest compiled and minified CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" type="text/css">
        <!-- jquery library -->
        <script type="text/javascript" src="bootstrap/js/jquery-3.2.1.min.js"></script>
        <!-- Latest compiled and minified javascript -->
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <!-- External CSS -->
        <link rel="stylesheet" href="css/style3.css" type="text/css">
    </head>
    <body>
        <div>
            <?php
                require 'header.php';
            ?></div>
            <div class="container">
                <div class="jumbotron">
                    <h1>Hi Seller!</h1>
                    <p>Edit and add all your product here.</p>
                    <div class="col-md-6" style="float: right;">
                    <p><a href="add_products.php" role="button" class="btn btn-primary btn-block" style="border-radius: 12px;  box-shadow: 0 13px 17px 0 rgba(0,0,0,0.25), 0 18px 51px 0 rgba(0,0,0,0.20); ">Add Product</a></p>
                </div>
                </div>
              </div>

            


    <div class="row">

      <div class="container">
        <div class="page-header">
          <h2>Products List</h2>
        </div>
        <!-- <table id="productlist" style="width: 100%; height: 100%;" class="table-dark table-striped table-bordered hover" id="table">
          <thead>
          <tr>
            <th>Product ID</th>
            <th>Name</th>
            <th>Description</th> 
            <th>Price</th>
            <th>Stock</th>
            <th>Picture<br><small>(Clickable)</small></th>
            <th></th>
          </tr>
          </thead>
          <tbody> -->


            
          <?php
          try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $conn->prepare("SELECT * FROM tbl_productsell_delta");
            $stmt->execute();
            $result = $stmt->fetchAll();
          }
          catch(PDOException $e){
            echo "Error: " . $e->getMessage();
          } ?>
            
          <?php
          foreach($result as $readrow) {
              ?>
            <div class="col-md-3 d-flex align-items-stretch">
            <div class="card" style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); max-width: 300px;  padding: 16px;  text-align: center; font-family: arial; margin-bottom: 10px;">

              <?php if(file_exists('pictures_sell/'. $readrow['PICTURE']) && isset($readrow['PICTURE'])){
                $img = 'pictures_sell/'.$readrow['PICTURE'];
                echo '<td><img data-toggle="modal" data-target="#'.$readrow['ID'].'" width=200px height=200px; src="'.$img.'"></td>';
              }
              else{
                $img = 'nophoto.jpg';
                echo '<td><img width=200px%; data-toggle="modal" data-target="#'.$readrow['ID'].'" src="nophoto.jpg"'.'></td>';
              } ?>
              
              <p><?php echo $readrow['NAME']; ?></p>
              <p><?php echo 'RM'.$readrow['PRICE']; ?></p>
              
<!-- 
              <div id="<?php echo $readrow['ID']?>" class="modal fade"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-body">
                  <img src="<?php echo $img ?>" class="img-responsive">
                </div>
              </div> -->


              <td>
                <a href="products_detail_sell.php?pid=<?php echo $readrow['ID']; ?>" class="btn btn-warning btn-xs" role="button">Details</a>
                <a href="add_products.php?edit=<?php echo $readrow['ID']; ?>" class="btn btn-success btn-xs" role="button"> Edit </a>
                <a href="sellerhome.php?delete=<?php echo $readrow['ID']; ?>" onclick="return confirm('Are you sure to delete?');" class="btn btn-danger btn-xs" role="button">Delete</a>
                
              </td>
            </div> 
          </div>
          
            <?php
          }
          $conn = null;
          ?>
            </div>
      </div>
        </div>
     
    

 

            <br><br><br><br><br><br><br><br>
           <footer class="footer">
               <div class="container">
               <center>
                   <p>Copyright &copy DFOBB. All Rights Reserved. | Contact Us: +05 4099 9999</p>
                   <p>This website is developed by Delta Group</p>
               </center>
               </div>
           </footer>
        </div>

         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  
  <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
    
  <script type="application/javascript">
  var loadFile = function (event) {
    var reader = new FileReader();
    reader.onload = function () {
      var output = document.getElementById('productPhoto');
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
    document.getElementById('productImageTitle').innerText = event.target.files[0]['name'];
  };

  $(document).ready(function () {
    $("#productlist").DataTable({
    "lengthMenu": [[5, 20, 50, -1], [5, 20, 50, "All"]]
  });
  });
</script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js%22%3E"></script> -->
    </body>
</html>
