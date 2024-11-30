<?php
// logout.php
session_start();

if (empty($_SESSION)) {
  // If the session is empty, redirect to the login page
  header("Location: ../loginForm.php");
  exit();
} else {
  // If the session is not empty, log the user out
  session_unset();
  session_destroy();

  // Redirect to the login page after logging out
  header("Location: ../loginForm.php");
  exit();
}
