<?php

// Creates a PHP session and sets inactivity timeout period

function start_session() {

   session_start();
    
   // set timeout period in seconds
   $inactive = 18000;
    
   // check to see if $_SESSION['timeout'] is set
   if(isset($_SESSION['timeout']) ) {
	   $session_life = time() - $_SESSION['timeout'];
	   if($session_life > $inactive) {
         header("Location: ../../respite/main/logout.php");
      }
   }
   $_SESSION['timeout'] = time();
}

?>
