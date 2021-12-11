<!Doctype html>
<html>
<head>
    <?php require 'metadata.php'; ?>
    <link rel = "stylesheet" type = "text/css" href = "css/user_accounts.css">
    <title>User Accounts</title>
</head>
<body>
    <?php require 'nav.php'; ?>
    

    <div class="row" style = "margin:auto;">
        <div class="col-12 col-md-8">
        
        <?php
            if(isset($_SESSION['deleted_user'])){
                echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Deleted User: " . $_SESSION['deleted_user'] . "</div></center>";
                $_SESSION['deleted_user'] = null;
            }
            if(isset($_SESSION['created_user'])){
                echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Created User: " . $_SESSION['created_user'] . "</div></center>";
                $_SESSION['created_user'] = null;
            }
            if(isset($_SESSION['edit_user'])){
                echo "<center><div class=\"alert alert-success\" role=\"alert\">Successfully Edited User: " . $_SESSION['edit_user'] . "</div></center>";
                $_SESSION['edit_user'] = null;
            }
        ?>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-signin" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Edit</h1>

                <label for="inputOldUser" class="sr-only">Old User</label>
                <input type="text" class="form-control" name = "modal_old_user" id = "old_user" placeholder="" value required autofocus readonly style="width: 20em;">

                <label for="inputEmail" class="sr-only">Name</label>
                <input type="text" class="form-control" name = "modal_name" placeholder="Name" value required autofocus style="width: 20em;">

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" class="form-control" name = "modal_email" placeholder="Email address" value required autofocus style="width: 20em;">
                
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "modal_password" placeholder="Password" value required style="width: 20em;">

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "modal_vpassword" placeholder="Validate Password" value required style="width: 20em;">
                

                <select class="custom-select mr-sm-2" aria-label="Default select example" name = "modal_access_level" style = "width: 20em; margin-left: 1%;" required>
                    <option selected>Access Level</option>
                    <option value="1">1 (User)</option>
                    <option value="3">3 (Super 'Admin + User')</option>
                </select>
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit_modal" class="btn btn-primary">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Edit User: ' + recipient)
  document.getElementById('old_user').value = recipient;
  //document.getElementById('old_user').disabled = true;
  //alert(document.getElementById('old_user').value);
})
</script>



<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form class="form-signin" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Edit</h1>

                <label for="inputOldUser" class="sr-only">Old User</label>
                <input type="text" class="form-control" name = "modal_old_user" id = "old_user_admin" placeholder="" value required autofocus readonly style="width: 20em;">

                <label for="inputEmail" class="sr-only">Name</label>
                <input type="text" class="form-control" name = "modal_name" placeholder="Name" value required autofocus style="width: 20em;">

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" class="form-control" name = "modal_email" placeholder="Email address" value required autofocus style="width: 20em;">
                
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "modal_password" placeholder="Password" value required style="width: 20em;">

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "modal_vpassword" placeholder="Validate Password" value required style="width: 20em;">
                
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name = "submit_modal_admin" class="btn btn-primary">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>



<script>
$('#exampleModal2').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-title').text('Edit User: ' + recipient)
  document.getElementById('old_user_admin').value = recipient;
  //document.getElementById('old_user').disabled = true;
  //alert(document.getElementById('old_user').value);
})
</script>



<?php

    if(isset($_POST['submit_modal'])){
        $old_user = $_POST['modal_old_user'];
        $name = $_POST['modal_name'];
        $email = $_POST['modal_email'];
        $password = $_POST['modal_password'];
        $vpassword = $_POST['modal_vpassword'];
        $access_level = $_POST['modal_access_level'];

        if($password != $vpassword){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
        }
        else if($access_level != "1" && $access_level != "3"){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Access Level!</div></center>";
        }
        else{
            Flight::redirect("/edit/" . $old_user . "/" . $email . "/" . $name . "/" . $password . "/" . $access_level);
        }

        
        //Flight::redirect("/edit/" . $email . "/" . $name . "/" . $password . "/" . $access_level);
    }



    if(isset($_POST['submit_modal_admin'])){
        $old_user = $_POST['modal_old_user'];
        $name = $_POST['modal_name'];
        $email = $_POST['modal_email'];
        $password = $_POST['modal_password'];
        $vpassword = $_POST['modal_vpassword'];
        $access_level = 2;

        if($password != $vpassword){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
        }
        else if($access_level != "1" && $access_level != "2" && $access_level != "3"){
            echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Access Level!</div></center>";
        }
        else{
            Flight::redirect("/edit/" . $old_user . "/" . $email . "/" . $name . "/" . $password . "/" . $access_level);
        }

        
        //Flight::redirect("/edit/" . $email . "/" . $name . "/" . $password . "/" . $access_level);
    }
?>



        <center>
            <h1 class = "h3 font-weight-normal" id = "title" >User Accounts</h1>
        </center>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Access Level</th>
                <th scope="col">Edit</th>
                </tr>
            </thead>
            <tbody>

            <?php
    

                    $result = Database::get_users();
                    $count = 0;
                    while( ($row = $result->fetch_assoc()) ){
                        $count++;
                        echo "
                        <tr>
                            <form method = \"post\">
                            <td>" . $count . "</td>
                            <td>" . $row['name'] . "</td>
                            <td><a href = \"mailto: " . $row['email'] . "\">" . $row['email'] . "</td>
                            <td>" . $row['password'] . "</td>
                            <td>" . $row['access_level'] . "</td>
                            <td>"; if($row['access_level'] == 2){ echo "<a data-toggle=\"modal\" data-target=\"#exampleModal2\" data-whatever=\"" . $row['email'] . "\"" . $row['email'] . "\"><span style = \"color: #b300b3;\"><i class=\"fas fa-edit\"></i></span></button>&emsp;";} else{echo "<a data-toggle=\"modal\" data-target=\"#exampleModal\" data-whatever=\"" . $row['email'] . "\"" . $row['email'] . "\"><span style = \"color: #b300b3;\"><i class=\"fas fa-edit\"></i></span></button>&emsp;";} echo "<a href =\"delete/" . $row['email'] . "/" . $row['access_level'] . "/" . $row['id'] . "\"><span style = \"color: red;\"><i class=\"far fa-trash-alt\"></i></span></a></td>
                            </form>
                        </tr>";
                        
                        //echo "id: " . $row['id'] . " name: " . $row['name'] . " email: " . $row['email'] . " access level: " . $row['access_level'] . "<br>";
                    }

                    
                
                ?>

            </tbody>
        </table>

    </div>

    <div class="col-6 col-md-4">
        <center>
            <?php
            
            if(isset($_POST['create_submit'])){
                $name = $_POST['create_name'];
                $email = $_POST['create_email'];
                $password = $_POST['create_password'];
                $vpassword = $_POST['create_vpassword'];
                $access_level = $_POST['create_access_level'];

                if($password != $vpassword){
                    echo "<center><div class=\"alert alert-danger\" role=\"alert\">Passwords do not match!</div></center>";
                }
                else if($access_level != "1" && $access_level != "2" && $access_level != "3"){
                    echo "<center><div class=\"alert alert-danger\" role=\"alert\">Invalid Access Level!</div></center>";
                }
                else{
                    Database::add_user($email, $password, $name, $access_level);
                    if($access_level == "1" || $access_level == "3"){
                        Database::add_timesheet($email);
                        //Database::update_timesheet($id, 0, 0, 0, 0, 0, 0, 0);----
                    }
                    $_SESSION['created_user'] = $email;
                    header("Refresh:0");
                  
                }
            }

            ?>

            <form class="form-signin" method="post">
                <h1 class="h3 mb-3 font-weight-normal">Create New User</h1>
                
                <label for="inputEmail" class="sr-only">Name</label>
                <input type="text" class="form-control" name = "create_name" placeholder="Name" value required autofocus style="width: 20em;">

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="email" class="form-control" name = "create_email" placeholder="Email address" value required autofocus style="width: 20em;">
                
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "create_password" placeholder="Password" value required style="width: 20em;">

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" class="form-control" name = "create_vpassword" placeholder="Validate Password" value required style="width: 20em;">
                

                <select class="custom-select mr-sm-2" aria-label="Default select example" name = "create_access_level" style = "width: 20em; margin-left: 1%;" required>
                    <option selected>Access Level</option>
                    <option value="1">1 (User)</option>
                    <option value="2">2 (Admin)</option>
                    <option value="3">3 (Super 'Admin + User')</option>
                </select>


                <button class="btn btn-lg btn-primary btn-block" type="submit" name = "create_submit" style="width: 16em;">Create User</button>
                
            </form>
        </center>
    </div>
<!-- </div> -->

<?php require 'footer.php'; ?>
</body>
</html>