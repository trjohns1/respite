<?php

function sessionAuthenticate()
{
   // User is already authenticated by Shib.
	// This function merely adds an abstraction layer and assigns a username variable.
   // Set Session["username"] to onyen provided by shib.
   // This is what the application will use throughout

   // To use ONYEN attribute released from Shibboleth use this:
   // $_SESSION["username"]=$_SERVER['uid'];

   // To use EPPN attribute released from Shibboleth use this:
   // EPPN is preferred because it is unique, i.e. user@fqdn
   $str = explode('@', $_SERVER['eppn']) ;
   $_SESSION["username"] = $str[0];
}

?>
