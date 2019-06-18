<?php

// Checks if a user's roles match any of the authorized roles.
// Use this function to selectively echo html view elements to the display.
// $userRoles is an array of the user's roles
// $authorizedRoles is an array of those roles that are allowed.
// Returns true if the user roles have any matches in the authorized roles.

function isAuthorized($userRoles, $authorizedRoles) {

   // Count the number of authorized roles that the user has
   $found = 0;

   foreach($authorizedRoles as $key=>$value) {
	   if(in_array($authorizedRoles[$key], $userRoles)){
         $found++;
      }
   }

   if($found) {
      return TRUE;
   }
   else {
      return FALSE;
   }
}
?>
