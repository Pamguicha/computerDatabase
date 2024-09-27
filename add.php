<?php

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
  }
  if (filter_input(INPUT_POST, "checkDetails")) {
    displayDetails();
  }
  // Redirect back to index.php 
  header("Location: index.php?message=" . urlencode($message));
  exit;

}


//function newAccount
function newAccount()
{
  global $username, $firstName, $surname, $password, $address, $suburb, $postcode, $state, $mobilephone, $message;
  //get the inputted values
  $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
  $firstName = filter_input(INPUT_POST, "firstname", FILTER_SANITIZE_STRING);
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
      $message = "Can't create account, your username already existed! Please choose another one";
      return;
    }
    //Password Must be at least 8 characters in length
    if (strlen($password) <= 8) {
      $message = "Password must be more than 8 characters always";
      return;
    }

    //SQL INSERT statement
    $query = "INSERT INTO user (username, firstname, surname, password, address, suburb, postcode, state, mobilephone) VALUES (:username, :firstname, :surname, :password, :address , :suburb, :postcode, :state , :mobilephone);";
    $stmt = $conn->prepare($query);

    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":firstname", $firstName);
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
    $stmt = $conn->query("SELECT * FROM user WHERE username=" . $username);
    $result = $stmt->fetch();

    //Test if SELECT statement worked
    if ($result == null) {
      $message = "An error ocurred. The username doesn't exist or has been entered incorrectly. Please check again";
    } else {
      $username = $result[0];
      $firstName = $result[1];
      $surname = $result[2];
      $password = $result[3];
      $address = $result[4];
      $suburb = $result[5];
      $postcode = $result[6];
      $state = $result[7];
      $mobilephone = $result[8];

    }

  } catch (PDOException $e) {
    $message = "Database connection failed with the following error: " . $e->getMessage();
  }
  $conn = null;

}