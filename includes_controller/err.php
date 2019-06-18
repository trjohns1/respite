<?php

function err($type, $description, $dump=null) {
// Formats error messages and refers the browser to an error display page

   // Copy error messages to SESSION variables so they can be passed to the error display page
   $_SESSION['error']['type'] = $type;
   $_SESSION['error']['description'] = $description;
   $_SESSION['error']['dump'] = $dump;
   $_SESSION['error']['page'] = $_SERVER['HTTP_REFERER'];

   // Redirect to the error display page
   header("Location: ../../respite/main/error.php");

   exit;
}
?>
