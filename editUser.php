<!-- 20190621 - Created editUser.php form. This form will allow viewing all users, edit user and update user details - Banele -->
<!-- 20190621 - Selecting all data from the database and display it on the table - Banele -->
<!-- 20190623 - Created update and delete sql statements that are triggered when button update or delete are clicked. 
I also added sql statement for update and delete - Banele -->

<?php
  include_once("dbconnection.php");

  // listen for update button click
  if(isset($_GET["update"])){
    // getting values from the form
    $dateCreated = mysqli_real_escape_string($conn, $_GET["userDateCreated"]);
    $fname = mysqli_real_escape_string($conn, $_GET["firstname"]);
    $lname = mysqli_real_escape_string($conn, $_GET["lastname"]);
    $id = mysqli_real_escape_string($conn, $_GET["id_number"]);
    $dob = mysqli_real_escape_string($conn, $_GET["dob"]);
    $usrType = mysqli_real_escape_string($conn, $_GET["userType"]);
    $usrEmail = mysqli_real_escape_string($conn, $_GET["email"]);
    $gndr = mysqli_real_escape_string($conn, $_GET["gender"]);
    $usrNote = mysqli_real_escape_string($conn, $_GET["userNote"]);
    $statusActive = empty($_GET["active"]);
    $statusInactive = empty($_GET["inactive"]);
    ($statusActive) ? $usrStatus = "Active" : $usrStatus = "Inactive";
    ($statusInactive) ? $usrStatus = "Active" : $usrStatus = "Inactive";

    // 20190623 - Updating user details based on the user's unique ID Number - Banele
    $updateUserStmt = "UPDATE `user` SET `txtFirstname`=?,`txtLastname`=?,`txtIDNumber`=?,`txtDOB`=?,
    `txtGender`=?,`txtUserType`=?,`txtEmail`=?, `txtUserDateCreated`=?,`txtStatus`=?,`txtUserNote`=?
    WHERE txtIDNumber = $id";
    $stmt = mysqli_stmt_init($conn);
    if(mysqli_stmt_prepare($stmt, $updateUserStmt)){
      mysqli_stmt_bind_param($stmt, "ssssssssss", $fname, $lname, $id, $dob, $gndr, $usrType, $usrEmail, $dateCreated, $usrStatus, $usrNote);
      mysqli_stmt_execute($stmt);
      echo "<script type=text/javascript>alert('User details successfully updated')</script>";
    }else{
      echo "<script type=text/javascript>alert('Error! User details were not update')</script>";
    }
  }

  // listen for delete button click.
  if(isset($_GET["delete"])){
    $id = mysqli_real_escape_string($conn, $_GET["id_number"]);
    // 20190623 - Deleting user details based on the user's unique ID Number - Banele
    $sql = "DELETE FROM `user` WHERE txtIDNumber = $id";
    if(mysqli_query($conn, $sql)){
      echo "<script type=text/javascript>alert('User details successfully Deleted')</script>";
    }else{
      echo "<script type=text/javascript>alert('Error! User details not deleted')</script>";
    }
  }
?>

<!DOCTYPE html>
<html lang="en" class="smart-style-0">
<head>
  <title>Edit user form</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script type="text/javascript" src=".\clientsideUserFormValidation.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<style>
    .jumbotron-background {
      background: linear-gradient(to bottom, #00ffff 15%, #cc99ff 95%);
    }
</style>

<body>
  <div class="jumbotron jumbotron-background jumbotron-fluid text-center">
      <h2>Edit user form</h2>
      <p>View, Edit and Update user details!</p>
      <div>
      <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="./userForm.php"><b><h3>Home</h3></b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><b><h3>|</h3></b></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./editUser.php"><b><h3>Edit User</h3></b></a>
      </li>
    </ul>
    </div>
  </div>
  <div class="container">
    <!-- 20190616 - Table to display the entered data -->
    <div>
      <h3 style="text-align: center;">Entered user information</h3> <p></p>
    </div>
    <!-- Table -->
    <table id="tableData" name="tableData" class="table table-striped container container-fluid">
      <thead class="thead-dark">
        <tr></tr>
        <th scope="col">#</th>
        <th scope="col">User date created</th>
          <th scope="col">Firstname</th>
          <th scope="col">Lastname</th>
          <th scope="col">ID Number</th>
          <th scope="col">D.O.B</th>
          <th scope="col">E-Mail</th>
          <th scope="col">User type</th>
          <th scope="col">Gender</th>
          <th scope="col">User status</th>
          <th scope="col">User notes</th>
        </tr>
      </thead>
      <tr>
        <tr>
          <!-- 20190621 - Selecting all data from the database and display it on the table - Banele -->
          <?php
            $sql = "SELECT * FROM `user`";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            $correctDetails = false;
            if($resultCheck > 0){
                while($row = mysqli_fetch_assoc($result)){
                  echo "<tr><th scope=\"row\">".$row['intUserID']."</th>".
                  "<td>".$row['txtUserDateCreated']."</td>".
                  "<td>".$row['txtFirstname']."</td>".
                  "<td>".$row['txtLastname']."</td>".
                  "<td>".$row['txtIDNumber']."</td>".
                  "<td>".$row['txtDOB']."</td>".
                  "<td>".$row['txtEmail']."</td>".
                  "<td>".$row['txtUserType']."</td>".
                  "<td>".$row['txtGender']."</td>".
                  "<td>".$row['txtStatus']."</td>".
                  "<td>".$row['txtUserNote']."</td>".
                  "</tr>";
                }
              }else{
                echo "<script type=text/javascript>alert('Error! Database is at empty')</script>";
            }
          ?>
        </tr>
      </tbody>
    </table>
    <script type="text/javascript" defer>
      var tbl = document.getElementById("tableData");
      // index 0 is for the table header hence I will start at index 1
      for(var a = 1; a < tbl.rows.length; a++){
        tbl.rows[a].onclick = function(){
          // index zero is for  userID hence I will start at index 1
          document.getElementById("userDateCreated").value = this.cells[1].innerHTML;
          document.getElementById("firstname").value = this.cells[2].innerHTML;
          document.getElementById("lastname").value = this.cells[3].innerHTML;
          document.getElementById("id_number").value = this.cells[4].innerHTML;
          document.getElementById("dob").value = this.cells[5].innerHTML;
          document.getElementById("email").value = this.cells[6].innerHTML;
          var gndr = this.cells[8].innerText;
          (gndr == "Male") ? document.getElementById("gender_male").checked = true : document.getElementById("gender_female").checked = true;
          var st = this.cells[9].innerText;
          (st == "Active") ? document.getElementById("active").checked = true : document.getElementById("inactive").checked = true;
          document.getElementById("userNote").value = this.cells[10].innerHTML;
        };
      }
    </script>
    <!-- form -->
    <form  action="<?php $_PHP_SELF ?>" method="get">
      <br><br>
      <h3 style="text-align: center;">Update selected user information</h3> <p></p>
      <div class="form-group">
        <label for="todayDate">User date created:</label>
        <input class="form-control text-center" type="date" id="userDateCreated" name="userDateCreated" value="<?php echo date("Y-m-d"); ?>">
      </div>
      <!-- Firstname input field -->
      <div class="form-group">
        <label for="firstname">Firstname:</label>
        <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname">
      </div>
      <!-- Lastname input field -->
      <div class="form-group">
        <label for="Lastname">Lastname:</label>
        <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname">
      </div>
      <!-- ID number input field -->
      <div class="form-group">
        <label for="id_number">ID Number:</label>
        <input type="number" class="form-control" id="id_number" placeholder="Enter 13 digit ID number" name="id_number">
      </div>
      <!-- Date of birth input field -->
      <div class="form-group">
        <label for="id_number">Date of birth:</label>
        <input type="date" class="form-control" id="dob" name="dob">
      </div>
      <!-- E-mail address input field -->
      <div class="form-group">
        <label for="email">E-mail address:</label>
        <input type="email" class="form-control" id="email" placeholder="name@domain.co.za" name="email">
      </div>
      <!-- User type selection dropdown -->
      <div class="form-group">
        <label for="user-type">User type</label>
        <select class="form-control" id="userType" name="userType">
          <option>Administrator</option>
          <div class="dropdown-divider"></div>
          <option>Developer</option>
          <div class="dropdown-divider"></div>
          <option>Technical user</option>
        </select>
      </div>
      <!-- Gender selection radio button -->
      <div>
        <label style="padding-right: 50px;">Gender: </label>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio"  name="gender" id="gender_male" value="Male">
          <label class="form-check-label" for="gender_male">Male</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio"  name="gender" id="gender_female" value="Female">
          <label class="form-check-label" for="gender_female">Female</label>
        </div>
      </div>
      <!-- User active, inactive or inactive checkbox status -->
      <!-- 20190618 - Added a checkbox called inactive - Banele -->
      <label style="padding-right: 25px;">User status: </label>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="active" id="active" value="active">
        <label class="form-check-label" for="active">Active</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="inactive" id="inactive" value="inactive">
        <label class="form-check-label" for="inactive">Inactive</label>
      </div>
      <!-- User notes -->
      <div class="form-group">
        <textarea class="form-control" id="userNote" name="userNote" rows="3" placeholder="User notes"></textarea>
      </div>
      <!-- 20190616 - Added an inline button to clear the form called 'Cancel' - Banele -->           
      <div class="form-group row">
        <div class="col">
          <button onclick="return validation()" type="submit" name="update" class="btn btn-primary btn-lg btn-block">Update</button>
        </div>
        <div class="form-group col">
          <button type="submit" name="delete" id="button" class="btn btn-primary btn-lg btn-block">Delete</button>
        </div>
        <div class="form-group col">
          <button type="reset" class="btn btn-primary btn-lg btn-block">Clear form</button>
        </div>
      </div>
    </form>
  </div>
</body>
<!-- Footer -->
<!-- 20190616 - Added a footer - Banele -->
<footer class="page-footer font-small blue">
  <div class="footer-copyright text-center py-3">© 2019 Copyright. Banele</div>
</footer>
</html>