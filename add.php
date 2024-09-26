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

    // Redirect back to index.php with the message
    header("Location: index.php?message=" . urlencode($message));
    exit;

  }
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
      $message = "An error ocurred. A new account could not be created";
    } else {
      $message = "A new account was created";
    }

  } catch (PDOException $e) {
    $message = "Database connection failed with the gollowing error: " . $e->getMessage();
  }

  $conn = null;
}

