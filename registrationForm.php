<!-- 20190619 - Created a registration form - Banele -->
<!-- 20190623 - Added an MD5 encryption function for the password. Also added a link to redirect back to the login form
once user has successfully registered - Banele -->
<!-- 20190623 - Select sql statement to read all the data from the database then check if the entered ID number already exist or not  - Banele -->

<?php
  include_once("dbconnection.php");
    // Assigning empty string values to the variables so that the table can display blank fields 
    $dateCreated = "";
    $fname = "";
    $lname = "";
    $id = "";
    $dob = "";
    $usrType = "";
    $gndr = "";
    $usrStatus = "";
    $usrNote = "";

  // checking if the submit button is clicked
  if(isset($_POST["submit"])){
    //assigned variables with the data from the form
    // 20190623 - Added an MD5 encryption function for the password
    $dateCreated = mysqli_real_escape_string($conn, date("Y-m-d"));
    $fname = mysqli_real_escape_string($conn, $_POST["firstname"]);
    $lname = mysqli_real_escape_string($conn, $_POST["lastname"]);
    $id = mysqli_real_escape_string($conn, $_POST["id_number"]);
    $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
    $usrType = mysqli_real_escape_string($conn, $_POST["userType"]);
    $usrEmail = mysqli_real_escape_string($conn, $_POST["email"]);
    $usrPassword = md5(mysqli_real_escape_string($conn, $_POST["password"]));
    $gndr = mysqli_real_escape_string($conn, $_POST["gender"]);
    $usrNote = mysqli_real_escape_string($conn, $_POST["userNote"]);
    $statusActive = empty($_POST["active"]);
    $statusInactive = empty($_POST["inactive"]);
    ($statusActive) ? $usrStatus = "Active" : $usrStatus = "Inactive";
    ($statusInactive) ? $usrStatus = "Active" : $usrStatus = "Inactive";
    $checkIdExist = 0; // This value will increment by 1 everytime there is a match/similar ID number found.
    // 20190623 - Select sql statement to read all the data from the database then check if the entered ID number already exist or not  - Banele
    $sql = "SELECT * FROM `user`";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck >= 1){
        while($row = mysqli_fetch_assoc($result)){
          // checking to see if entered ID number exist in the database
          if($row['txtIDNumber'] == $id){
            echo "<script type=text/javascript>alert('Error! User ID Number already exist')</script>";
            $checkIdExist++; break;
          }
        }
        // If there is no ID match the following condition will be executed
        if($checkIdExist == 0){
          // prepared insert sql statement to insert all the data read from the form
          // 20190619 - Fixed the sql statement as it was not working because I was using the backticks signs instead of single quotes in the column names. - Banele 
          $insertUserStmt = "INSERT INTO `user` (`txtFirstname`, `txtLastname`, `txtIDNumber`, `txtDOB`, `txtGender`, `txtUserType`, `txtEmail`, `txtPassword`, `txtUserDateCreated`, `txtStatus`, `txtUserNote`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          if(mysqli_stmt_prepare($stmt, $insertUserStmt)){
            mysqli_stmt_bind_param($stmt, "sssssssssss", $fname, $lname, $id, $dob, $gndr, $usrType, $usrEmail, $usrPassword, $dateCreated, $usrStatus, $usrNote);
            mysqli_stmt_execute($stmt);
            echo "<script type=text/javascript>alert('User details successfully inserted')</script>";
          }else{
            echo "<script type=text/javascript>alert('Error! User details were not inserted')</script>";
          }
        }
    }else{
      // prepared insert sql statement to insert all the data read from the form
      // 20190619 - Fixed the sql statement as it was not working because I was using the backticks signs instead of single quotes in the column names. - Banele 
      $insertUserStmt = "INSERT INTO `user` (`txtFirstname`, `txtLastname`, `txtIDNumber`, `txtDOB`, `txtGender`, `txtUserType`, `txtEmail`, `txtPassword`, `txtUserDateCreated`, `txtStatus`, `txtUserNote`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = mysqli_stmt_init($conn);
      if(mysqli_stmt_prepare($stmt, $insertUserStmt)){
        mysqli_stmt_bind_param($stmt, "sssssssssss", $fname, $lname, $id, $dob, $gndr, $usrType, $usrEmail, $usrPassword, $dateCreated, $usrStatus, $usrNote);
        mysqli_stmt_execute($stmt);
        echo "<script type=text/javascript>alert('User details successfully inserted')</script>";
      }else{
        echo "<script type=text/javascript>alert('Error! User details were not inserted')</script>";
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en" class="smart-style-0">
<head>
  <title>Registration form</title>
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
    <h2>Register form</h2>
    <p>Register user details!</p>
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="public/index.php"><b><h3>Login page</h3></b></a>
      </li>
    </ul>
  </div>
  <div class="container">
    <!-- form -->
    <form  action="<?php $_PHP_SELF ?>" method="post">
      <fieldset disabled>
        <div class="form-group">
          <label for="todayDate">User date created:</label>
          <input class="form-control text-center" type="text" id="userDateCreated" name="userDateCreated" value="<?php echo date("Y-m-d"); ?>">
        </div>
      </fieldset>
      <!-- Firstname input field -->
      <div class="form-group">
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
        <!-- password input field -->
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
        </div>
        <!-- confirm password input field -->
        <div class="form-group">
          <label for="confirmPassword">Confirm Password:</label>
          <input type="password" class="form-control" id="confirmPassword" placeholder="Enter same password to confirm" name="confirmPassword">
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
            <button onclick="return validation()" type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
          </div>
          <div class="form-group col">
            <button type="reset" class="btn btn-primary btn-lg btn-block">Cancel</button>
          </div>
        </div>
      </div>
    </form>
    <!-- 20190616 - Table to display the entered data -->
    <div>
      <br><br>
      <h3 style="text-align: center;">Entered user information</h3> <p></p>
    </div>
    <!-- Table -->
    <table class="table table-striped container container-fluid">
      <thead class="thead-dark">
        <tr></tr>
        <th scope="col">#</th>
        <th scope="col">User date created</th>
        <th scope="col">Firstname</th>
        <th scope="col">Lastname</th>
        <th scope="col">ID Number</th>
        <th scope="col">D.O.B</th>
        <th scope="col">User type</th>
        <th scope="col">Gender</th>
        <th scope="col">User status</th>
        <th scope="col">User notes</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <!-- 20190617 - Fixed form bug. It was not displaying other form data. - Banele -->
          <th scope="row">1</th>
          <td><?php echo $dateCreated; ?></td>
          <td><?php echo $fname;?></td>
          <td><?php echo  $lname;?></td>
          <td><?php echo $id;?></td>
          <td><?php echo $dob;?></td>
          <td><?php echo $usrType;?></td>
          <td><?php echo $gndr;?></td>
          <td><?php echo $usrStatus;?></td>
          <td><?php echo $usrNote;?></td>
        </tr>
      </tbody>
    </table>
  </div>
</body>
<!-- Footer -->
<!-- 20190616 - Added a footer - Banele -->
<footer class="page-footer font-small blue">
  <div class="footer-copyright text-center py-3">© 2019 Copyright. Banele</div>
</footer>
</html>