<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet">
  <title>Registration form | Computer Force</title>
</head>
<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : '';
$surname = isset($_SESSION['surname']) ? $_SESSION['surname'] : '';
$password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
$address = isset($_SESSION['address']) ? $_SESSION['address'] : '';
$suburb = isset($_SESSION['suburb']) ? $_SESSION['suburb'] : '';
$postcode = isset($_SESSION['postcode']) ? $_SESSION['postcode'] : '';
$state = isset($_SESSION['state']) ? $_SESSION['state'] : '';
$mobilephone = isset($_SESSION['mobilephone']) ? $_SESSION['mobilephone'] : '';

//Clear the session data after use
session_unset();
//Include the database connection file
require_once("dbConnection.php");

?>

<body>
  <img class="logo" src="images/logoCf.png" alt="an image of the logo of Computer Force">
  <?php
  include 'navigation.php';
  ?>
  <h1 class="title">Create an account</h1>
  <main class="container-registration">
    <form action="add.php" method="post" name="add" class="form-container">
      <label class="userClass" for="username">Username:
        <br>
        <input class="inputRegForm" type="text" name="username" value="<?php echo $username; ?>">
      </label>
      <br>
      <label class="nameClass" for="firstname">First Name:
        <br>
        <input class="inputRegForm" type="text" name="firstName" value="<?php echo $firstName; ?>">
      </label>
      <br>
      <label class=" surnameClass" for="surname">Surname:
        <br>
        <input class="inputRegForm" type="text" name="surname" value="<?php echo $surname; ?>">
      </label>
      <br>
      <label class="passwordClass" for="password">Password:
        <br>
        <input class="inputRegForm" type="password" name="password" value="<?php echo $password; ?>">
      </label>
      <br>
      <label class="addressClass" for="address">Address:
        <br>
        <input class="inputRegForm" type="text" name="address" value="<?php echo $address; ?>">
      </label>
      <br>
      <label class="suburbClass" for="suburb">Suburb:
        <br>
        <input class="inputRegForm" type="text" name="suburb" value="<?php echo $suburb; ?>">
      </label>
      <br>
      <label class="postcodeClass" for="postcode">Postcode:
        <br>
        <input class="inputRegForm" type="number" name="postcode" value="<?php echo $postcode; ?>">
      </label>
      <br>
      <label class="stateClass" for="state">State:
        <br>
        <input class="inputRegForm" type="text" name="state" value="<?php echo $state; ?>">
      </label>
      <br>
      <label class="mobileClass" for="mobilephone">Mobilephone:
        <br>
        <input class="inputRegForm" type="text" name="mobilephone" value="<?php echo $mobilephone; ?>">
      </label>
      <br>
      <input class="newAccount" type="submit" name="NewAccount" value="NewAccount">
      <br>
      <br>
      <input class="displayData" type="submit" name="checkDetails" value="Display your details">
      <br>
      <input class="editData" type="submit" name="editData" value="Edit your details">
      <br>
      <input class="deleteBtn" type="submit" name="deleteData" value="Delete your account">

    </form>
    <div name="OutputMessage">
      <?php
      if (isset($_GET['message'])) {
        $message = urldecode($_GET['message']);
        echo $message;
      }


      ?>
    </div>
  </main>

  <?php
  include 'footer.php';
  ?>
</body>

</html>