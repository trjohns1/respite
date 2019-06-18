<?php
// ****************************************************************************************************
// * setQueryString()
// ****************************************************************************************************
// Sets the $queryString variable for use throughout the program. This ensures that $queryString
// is available in both GET and POST requests. It allows POST requests to have access to the
// query string of the original GET request, in case a form needs to be redisplayed on POST because
// a user entered invalid information in the form.

function setQueryString() {

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$queryString = $_SERVER['QUERY_STRING'];
	}
	else {
		$queryString = $_POST['queryString'];
	}

	// Clean potential injection attack vectors
	$queryString = addslashes(strip_tags(trim($queryString)));

	return $queryString;
}

?>
