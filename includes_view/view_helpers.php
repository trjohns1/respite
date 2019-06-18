<?php

// View Helper Functions
   
function print_error($key, $errors) {
// Print input errors with css style
      if (isset($errors[$key])) {
      echo "<p class=\"error\">".$errors[$key]."</p>";
   }
}

function print_formData($key, $formData) {
// Print input errors with css style
      if (isset($formData[$key])) {
      echo (htmlentities($formData[$key]));
   }
}

?>
