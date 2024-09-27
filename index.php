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
        <input class="inputRegForm" type="text" name="username">
      </label>
      <br>
      <label class="nameClass" for="firstname">First Name:
        <br>
        <input class="inputRegForm" type="text" name="firstname">
      </label>
      <br>
      <label class="surnameClass" for="surname">Surname:
        <br>
        <input class="inputRegForm" type="text" name="surname">
      </label>
      <br>
      <label class="passwordClass" for="password">Password:
        <br>
        <input class="inputRegForm" type="password" name="password">
      </label>
      <br>
      <label class="addressClass" for="address">Address:
        <br>
        <input class="inputRegForm" type="text" name="address">
      </label>
      <br>
      <label class="suburbClass" for="suburb">Suburb:
        <br>
        <input class="inputRegForm" type="text" name="suburb">
      </label>
      <br>
      <label class="postcodeClass" for="postcode">Postcode:
        <br>
        <input class="inputRegForm" type="number" name="postcode">
      </label>
      <br>
      <label class="stateClass" for="state">State:
        <br>
        <input class="inputRegForm" type="text" name="state">
      </label>
      <br>
      <label class="mobileClass" for="mobilephone">Mobilephone:
        <br>
        <input class="inputRegForm" type="text" name="mobilephone">
      </label>
      <br>
      <input class="newAccount" type="submit" name="NewAccount" value="NewAccount">
      <br>
      <br>
      <input class="displayData" type="submit" name="checkDetails" value="Display your details">
      <br>
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