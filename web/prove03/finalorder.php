<?php

session_start();

  $firstName = htmlspecialchars($_POST["firstname"]);
  $lastName = htmlspecialchars($_POST["lastname"]);
  $address = htmlspecialchars($_POST["address"]);
  $city = htmlspecialchars($_POST["city"]);
  $state = htmlspecialchars($_POST["state"]);
  $zipcode = htmlspecialchars($_POST["zipcode"]);

  $_SESSION["firstname"] = $firstName;
  $_SESSION["lastname"] = $lastName;
  $_SESSION["address"] = $address;
  $_SESSION["city"] = $city;
  $_SESSION["state"] = $state;
  $_SESSION["zipcode"] = $zipcode;

  header("Location: ordercomplete.php");

?>
