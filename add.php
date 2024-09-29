<?php
session_start();

// 1: Global variables
$username = "";
$firstName = "";
$surname = "";
$password = "";
$address = "";
$suburb = "";
$postcode = "";
$state = "";
$mobilephone = "";
$message = "";


// 2: Handle events by calling correct function
if (filter_input(INPUT_SERVER, "REQUEST_METHOD") == "POST") {
  if (filter_input(INPUT_POST, "NewAccount")) {
    newAccount();
    // Redirect back to index.php 
    header("Location: index.php?message=" . urlencode($message));
    exit;
  }
  if (filter_input(INPUT_POST, "checkDetails")) {
    displayDetails();
  }

  if (filter_input(INPUT_POST, "editData")) {
    editDetails();
  }

  if (filter_input(INPUT_POST, "deleteData")) {
    deleteAccount();
  }

}

//function newAccount
function newAccount()
{
  global $username, $firstName, $surname, $password, $address, $suburb, $postcode, $state, $mobilephone, $message;
  //get the inputted values
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
  $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
  $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
  $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
  $suburb = filter_input(INPUT_POST, "suburb", FILTER_SANITIZE_STRING);
  $postcode = filter_input(INPUT_POST, "postcode", FILTER_SANITIZE_STRING);
  $state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
  $mobilephone = filter_input(INPUT_POST, "mobilephone", FILTER_SANITIZE_STRING);

  // connect to database
  try {
    require_once "dbconnection.php";
    //To avoid duplicate usernames
    $query = $conn->prepare("SELECT COUNT(*) FROM user WHERE username = :username");
    $query->bindParam(":username", $username);
    $query->execute();
    $count = $query->fetchColumn();

    if ($count > 0) {
      $message = "Can't create an account, your username already existed! Please choose another one";
      return;
    }
    //Password Must be at least 8 characters in length
    if (strlen($password) <= 8) {
      $message = "Password must be more than 8 characters always";
      return;
    }

    //SQL INSERT statement
    $query = "INSERT INTO user (username, firstName, surname, password, address, suburb, postcode, state, mobilephone) VALUES (:username, :firstName, :surname, :password, :address , :suburb, :postcode, :state , :mobilephone);";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":firstName", $firstName);
    $stmt->bindParam(":surname", $surname);
    $stmt->bindParam(":password", $password);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":suburb", $suburb);
    $stmt->bindParam(":postcode", $postcode);
    $stmt->bindParam(":state", $state);
    $stmt->bindParam(":mobilephone", $mobilephone);

    $stmt->execute();


    //Test if INSERT statement worked
    if (!$stmt) {
      $message = "<h2><font color='red'>An error ocurred. A new account could not be created</h2>";
    } else {
      $message = "<h2><font color='green'>A new account was created</h2>";
    }

  } catch (PDOException $e) {
    $message = "Database connection failed with the gollowing error: " . $e->getMessage();
  }

  $conn = null;
}

//function displayDetails

function displayDetails()
{
  global $username, $firstName, $surname, $password, $address, $suburb, $postcode, $state, $mobilephone, $message;

  // get the username value
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
  //connect to database
  try {
    require_once "dbconnection.php";

    //SQL SELECT statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch();

    //Test if SELECT statement worked
    if ($result == null) {
      $message = "An error ocurred. The username doesn't exist or has been entered incorrectly. Please check again";
    } else {
      $_SESSION['username'] = $result['username'];
      $_SESSION['firstName'] = $result['firstName'];
      $_SESSION['surname'] = $result['surname'];
      $_SESSION['password'] = $result['password'];
      $_SESSION['address'] = $result['address'];
      $_SESSION['suburb'] = $result['suburb'];
      $_SESSION['postcode'] = $result['postcode'];
      $_SESSION['state'] = $result['state'];
      $_SESSION['mobilephone'] = $result['mobilephone'];

    }

  } catch (PDOException $e) {
    $message = "Database connection failed with the following error: " . $e->getMessage();
  }
  // Redirect back to index.php with message (if needed)
  header("Location: index.php?message=" . urlencode($message));
  exit;

}

//function editDetails
function editDetails()
{
  global $username, $firstName, $surname, $password, $address, $suburb, $postcode, $state, $mobilephone, $message;
  // get the inputted values
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
  $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
  $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
  $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
  $suburb = filter_input(INPUT_POST, "suburb", FILTER_SANITIZE_STRING);
  $postcode = filter_input(INPUT_POST, "postcode", FILTER_SANITIZE_STRING);
  $state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
  $mobilephone = filter_input(INPUT_POST, "mobilephone", FILTER_SANITIZE_STRING);

  //connect to database

  try {
    require_once "dbconnection.php";
    //Determine if Username is valid or not
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $result = $stmt->fetch();


    //if IF is valid then undertake edit
    if ($result !== null) {
      //SQL UPDATE statement
      $stmt = $conn->prepare("UPDATE user SET firstName = :firstName, surname = :surname, password = :password, address = :address, suburb = :suburb, postcode = :postcode, state = :state, mobilephone = :mobilephone WHERE username = :username");

      $stmt->bindParam(":firstName", $firstName);
      $stmt->bindParam(":surname", $surname);
      $stmt->bindParam(":password", $password);
      $stmt->bindParam(":address", $address);
      $stmt->bindParam(":suburb", $suburb);
      $stmt->bindParam(":postcode", $postcode);
      $stmt->bindParam(":state", $state);
      $stmt->bindParam(":mobilephone", $mobilephone);
      $stmt->bindParam(":username", $username);

      $stmt->execute();
      $message = "<h1><font color='red'>Your account has been successfully updated!</h1>";

    } else {
      $message = "An error ocurred. The username is not valid. You can only edit your data with a registered username";
    }

  } catch (PDOException $e) {
    $message = "Database connection failed with the following error: " . $e->getMessage();
  }
  // Redirect back to index.php with message (if needed)
  header("Location: index.php?message=" . urlencode($message));
  exit;

}

//function deleteAccount

function deleteAccount()
{
  global $username, $firstName, $surname, $password, $address, $suburb, $postcode, $state, $mobilephone, $message;
  // get the inputted values
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
  $firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
  $surname = filter_input(INPUT_POST, "surname", FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
  $address = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
  $suburb = filter_input(INPUT_POST, "suburb", FILTER_SANITIZE_STRING);
  $postcode = filter_input(INPUT_POST, "postcode", FILTER_SANITIZE_STRING);
  $state = filter_input(INPUT_POST, "state", FILTER_SANITIZE_STRING);
  $mobilephone = filter_input(INPUT_POST, "mobilephone", FILTER_SANITIZE_STRING);

  //connect to database
  try {
    require_once "dbconnection.php";

    //Determine if username is valid or not
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = :username");
    $stmt->bindParam(":username", $username);
    $stmt->execute();
    $result = $stmt->fetch();

    //if username is valid then delete the record
    if ($result !== false) {
      //SQL DELETE statement
      $stmt = $conn->prepare("DELETE FROM user WHERE username = :username");
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $result = $stmt->execute();

      //Test if DELETE statement worked
      if ($result) {
        $message = "The account with the username of " . $username . " was deleted successfully";
        // clear the global variable values
        $username = "";
        $firstName = "";
        $surname = "";
        $address = "";
        $suburb = "";
        $postcode = "";
        $state = "";
        $mobilephone = "";
        $password = "";

      } else {
        $message = "An error ocurred. The username is not valid. You can only delete an account with a valid username";
      }
    } else {
      $message = "Thr username is not valid. Not account was found to delete ";
    }
  } catch (PDOException $e) {
    $message = "Database connection failed with the following error " . $e->getMessage();
  }
  // Redirect back to index.php with message (if needed)
  header("Location: index.php?message=" . urlencode($message));
  exit;
}


