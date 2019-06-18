<?php

// View Helper Function
   
function print_error($key, $errors) {
// Print input errors with css style
      if (isset($errors[$key])) {
      echo "<p class=\"error\">".$errors[$key]."</p>";
   }
}

?>
