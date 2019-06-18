<?php
/* includes.php */
// This file includes all of the common files necessary for most focis php pages
// By requiring includes/includes.php any script gains access to the entire list



// Configuration paramenters for the program
require_once "../../respite/includes_controller/configure.php";

// Ensure that the user is authenticated
require_once "../../respite/includes_controller/sessionAuthenticate.php";

// Redirects if a user is not allowed to view a page. Returns a list of roles.
require_once "../../respite/includes_controller/pageAuthorizationCheck.php";

// Issues the php session_start() command to session enable a page
require_once "../../respite/includes_controller/start_session.php";

// Error handler
require_once "../../respite/includes_controller/err.php";

// Gets the current page URL and its components
require_once "../../respite/includes_controller/getURL.php";

// Sets $queryString so POST pages can be redisplayed
require_once "../../respite/includes_controller/setQueryString.php";

// Verifies input type=date submissions
require_once "../../respite/includes_controller/date_and_time_functions.php";

// Ensures that user submitted data is properly formatted to be redisplayed if necessary
require_once "../../respite/includes_controller/prepFormData.php";

// Packs data into a single data structure for the View
require_once "../../respite/includes_controller/packView.php";

// Displays the View
require_once "../../respite/includes_controller/displayView.php";

?>
