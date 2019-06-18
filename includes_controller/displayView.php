<?php

// ****************************************************************************************************
// * displayView()
// ****************************************************************************************************
// Loads the entire view, causing the html browser to display it.
// displayView() accepts the $view data structure, which contains all data exposed to the view.
// Because displayView() is a function, all other PHP variables (except globals) are hidden from it.

function displayView($view, $pageName) {

   // Load the view
   require_once $pageName;
   return;
}

?>
