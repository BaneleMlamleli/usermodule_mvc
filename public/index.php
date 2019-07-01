<!-- 20190619 - Created a index.php for users to login - Banele -->
<!-- 20190620 - Created an SQL statement that will read all the database field then verify the entered user details against the read data.
If the login entered details are correct the variable 'correctDetails' will be true then immediately break out of the while condition.
Redirect to userForm.php page once the user login detail have been correctly verified else it will display an error message -->
<!-- 20190623 - Added an MD5 encryption function for the password - Banele -->

<?php
  include_once("dbconnection.php");
  // checking if the submit button is clicked
  if(isset($_POST["submit"])){
    // getting values passed from the login form and sanitise the data to prevent injection
    // 20190623 - Added an MD5 encryption function for the password
    $usrEmail = mysqli_real_escape_string($conn, stripcslashes($_POST["email"]));
    $usrPassword = md5(mysqli_real_escape_string($conn, stripcslashes($_POST["password"])));

    // 20190620 - Select sql statement to read all the data read from the database then verify the entered user details  - Banele
    $sql = "SELECT * FROM `user`";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    $correctDetails = false;
    if($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
          if(($row['txtEmail'] == $usrEmail) && ($row['txtPassword'] == $usrPassword)){
            //20190620 - If the login entered details are correct this variable will be true then immediately break out.
            $correctDetails = true; break;
          }
        }
    }else{
      echo "<script type=text/javascript>alert('Error! Database is at empty')</script>";
    }

    //20190620 - Redirect to userForm.php page once the user login detail have been correctly verified else it will display an error message
    echo ($correctDetails) ? header("Location: userForm.php") : "<script type=text/javascript>alert('Incorrect login details')</script>";
  }
?>

<!DOCTYPE html>
<html lang="en" class="smart-style-0">
<head>
  <title>Login form</title>
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
    <h2>Login</h2>
    <p>Login in to access the system!</p>
  </div>
  <div class="container">
    <!-- form -->
    <form  action="<?php $_PHP_SELF ?>" method="post">
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email address">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
      </div>
      <div class="form-group row">
        <div class="col">
          <button onclick="return validation()" type="submit" name="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
        </div>
        <div class="form-group col">
          <button type="reset" class="btn btn-primary btn-lg btn-block">Cancel</button>
        </div>
      </div>
      <a href="./registrationForm.php"><p style="text-align: center;">Register as a new user</p></a>
    </form>
  </div>
</body>
<!-- Footer -->
<!-- 20190616 - Added a footer - Banele -->
<footer class="page-footer font-small blue">
  <div class="footer-copyright text-center py-3">© 2019 Copyright. Banele</div>
</footer>
</html>