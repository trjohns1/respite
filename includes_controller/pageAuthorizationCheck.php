<?php

function pageAuthorizationCheck($authorizedRoles, $dbs) {
   // Determines if a user is authorized to view the page.
   // If the user is not authorized, the user is redirected to a "Not Authorized" message page.
   // If the user is authorized, the function returns an array containing the user's roles:

   $userRoles = array(); // Holds a list of a user's roles.

   // The query string with database handles and aliases
   $query = 'SELECT * FROM ' . $dbs['respite']['name'] . '.role WHERE ' . $dbs['respite']['name'] . '.role.username = :username';

   // Make the query
   try {
      // Prepare the query
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->bindParam('username', $_SESSION['username'], PDO::PARAM_STR);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      echo 'An error occurred accessing the database in module pageAuthorizationCheck.<br/>Please report this to your system administrator.';
      exit;
   }

   // Extract the results
   $result = $stmt->fetch(PDO::FETCH_ASSOC);

   // If no results were returned the user was not found and is not authorized
   if(empty($result)) header('Location: ../../respite/main/unauthorized.php');

   // Drop the 'username' element from the array
   unset($result['username']);

   // Remove any null values returned from the database
   foreach($result as $key=>$value){
      if (is_null($result[$key])) {
         unset($result[$key]);
      }
   }

	// Count the number of authorized roles that the user has
	$found = 0;
	foreach($authorizedRoles as $key=>$value) {
   	$found = $found + $result[$value];
	}

	// If the user has no roles that are authorized, redirect.
	if($found==0) {
   	header('Location: ../../respite/main/unauthorized.php');
   	exit;
	}

   // Copy $results into a clean array $userRoles
   foreach($result as $key=>$value){
      if($value) {
         $userRoles[] = $key;
      }
   }

   // Determine if system is in offline mode for maintenance. If so, redirect.

   // The query string with database handles and aliases
   $query = "SELECT value FROM {$dbs['respite']['name']}.system WHERE parameter = 'offline'";

   // Make the query
   try {
      // Prepare the query
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      echo 'An error occurred accessing the database in module pageAuthorizationCheck.<br/>Please report this to your system administrator.';
      exit;
   }

   // Extract the results
   $result = $stmt->fetch(PDO::FETCH_ASSOC);

   // If the system is in offline mode, and the user is not an administrator, get the offlineMessage and display an error.
   if(($result['value']==1) && !in_array('respite_administrator', $userRoles)) {

      // Query for the offline message
      // The query string with database handles and aliases
      $query = "SELECT value FROM {$dbs['respite']['name']}.system WHERE parameter = 'offlineMessage'";

      // Make the query
      try {
         // Prepare the query
         $stmt = $dbs['respite']['handle']->prepare($query);
         $stmt->execute();
      }
      catch(PDOException $ex) {
         echo 'An error occurred accessing the database in module pageAuthorizationCheck.<br/>Please report this to your system administrator.';
         exit;
      }
      // Extract the results
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      // Make message available to offlineMessage.php
      $_SESSION['offlineMessage'] = $result['value'];
      // Redirect
      header("Location: ../../respite/main/offlineMessage.php");

      exit;

   }

	return $userRoles;
}


?>
