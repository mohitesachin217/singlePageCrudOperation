<?php 


require_once('connection.php');


  
  if(isset($_POST) && !empty($_POST)){
    
    
    $term = filter_var($_POST['term'], FILTER_SANITIZE_STRING);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $relation = filter_var($_POST['relation'], FILTER_SANITIZE_STRING);
    $image  = '';
    $details = filter_var($_POST['details'], FILTER_SANITIZE_STRING);
    $resource = '';

    if(isset($_POST['id']) && !empty($_POST['id']) ){
      $id = filter_var($_POST['id'],FILTER_SANITIZE_NUMBER_INT);
      $sql ="UPDATE `terms` SET `wording` = '$term',`description` = '$description',`relation` = '$relation',`image`= '$image', `details` = '$details' WHERE `id` = $id";
      $resource = mysqli_query($conn,$sql);
      $txt = "Term updated successfully";
    }else{
      $sql = "INSERT INTO `terms` (`wording`,`description`,`relation`,`image`,`details`) VALUES('$term','$description','$relation','$image','$details')";
      $resource = mysqli_query($conn,$sql);
      $txt = "Term added successfully";
    }


    if($resource){
      $message['fail']    = '';
      $message['success'] =  $txt;
    }else{
      $message['success'] = '';
      $message['fail']    = "Failed to add the term";
    }
  }


  /**
   * 
   * 
   * 
   * Edit record section
   * 
   * 
   * 
   * */

  if(isset($_GET['id']) && !empty($_GET['id']) && $_GET['op'] == 'edit' ){
    
    $sql = "SELECT * FROM `terms` WHERE `id` = '".$_GET['id']."'";
    $resource = mysqli_query($conn,$sql);

    $row = mysqli_fetch_assoc($resource);

    $id = $_GET['id'];

    if($resource){
      $message['fail']    = '';
      $message['success'] =  "Resource loaded successfully";
    }else{
      $message['success'] = '';
      $message['fail']    = "Failed to load the resource";
    }
  }



  /**
   * 
   * 
   * 
   * Delete Record section
   * 
   * 
   * 
   * */

  if(isset($_GET['id']) && !empty($_GET['id']) && $_GET['op'] == 'delete' ){
    
    $sql = "DELETE FROM `terms` WHERE `id` = '".$_GET['id']."'";
    $resource = mysqli_query($conn,$sql);

    // $row = mysqli_fetch_assoc($resource);


    if($resource){
      $message['fail']    = '';
      $message['success'] =  "Resource deleted successfully";
    }else{
      $message['success'] = '';
      $message['fail']    = "Failed to delete the resource";
    }
  }


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" >



    <title>Sudoku</title>
  </head>
  <body>
    <div class="" style="width:50%;margin: 150px auto;">
          <?php 
              if(isset($message['success'])&& $message['success']!=''){
                ?>
                    <div class="alert alert-primary" role="alert">
                      <?php echo $message['success'];?>
                    </div>

                <?php
              }

              if(isset($message['fail'])&& $message['fail']!=''){
                ?>
                    <div class="alert alert-danger" role="alert">
                      <?php echo $message['fail'];?>
                    </div>

                <?php
              }
          ?>

          <div class="form-group">
            <h4 for="" style="text-align: center;">Add your term</h4>
          </div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="termform" enctype="multipart/form-data">
        <div class="form-group">
          <label for="exampleFormControlInput1">Term</label>
          <input type="text" class="form-control" id="term" name="term" placeholder="Term" value="<?php echo @$row['wording'];?>">
        </div>
        
        <div class="form-group">
          <label for="exampleFormControlInput1">Description</label>
          <input type="text" class="form-control" id="description" name="description" placeholder="description"  value="<?php echo @$row['description'];?>">
        </div>

        <div class="form-group">
          <label for="exampleFormControlInput1">Relation</label>
          <input type="text" class="form-control" id="relation" name="relation" placeholder="Relation"  value="<?php echo @$row['relation'];?>">
        </div>
       
        <div class="form-group">
          <label for="exampleFormControlInput1">Image</label>
          <input type="file" class="form-control" id="file" name="file" placeholder="Upload Image"  value="<?php echo @$row['image'];?>">
        </div>

         <div class="form-group">
            <label for="exampleFormControlTextarea1">Details</label>
            <textarea class="form-control" name="details" id="details" rows="3"> <?php echo @$row['details'];?></textarea>
          </div>

          <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo @$id;?>">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
          </div>
      </form>
    </div>


    <div class="" style="width:50%;margin: 150px auto;">
      <table class="table datatable-terms " id="myTable">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Terms</th>
            <th scope="col">Description</th>
            <th scope="col">relation</th>
            <th scope="col">Details</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
      <?php 
      
        $sql = "SELECT * FROM `terms` WHERE 1";
        $resource = mysqli_query($conn,$sql);
        $count = 1;
        while($row = mysqli_fetch_assoc($resource)){
            ?> 
                <tr>
                  <th scope="row"><?php echo $count;?></th>
                  <td><?php echo $row['wording'];?></td>
                  <td><?php echo $row['description'];?></td>
                  <td><?php echo $row['relation'];?></td>
                  <td><?php echo $row['details'];?></td>
                  <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id'];?>&op=edit">Edit</a></td>
                  <td><a href="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $row['id'];?>&op=delete">Delete</a></td>
                </tr>
            <?php
            $count++;
        }
    ?>

         </tbody>
      </table>
  
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" ></script>
    <script type="text/javascript">
      jQuery(document).ready( function () {
        jQuery('#myTable').DataTable();
      });
    </script>
  </body>
</html>
