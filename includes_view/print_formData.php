<?php

// View Helper Function

function print_formData($key, $formData) {
// Print input errors with css style
      if (isset($formData[$key])) {
      echo (htmlentities($formData[$key]));
   }
}

?>
