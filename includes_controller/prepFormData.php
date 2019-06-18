<?php
// ****************************************************************************************************
// * prepFormData()
// ****************************************************************************************************
// Strips invalid tags from user supplied data so that the form can be safely redisplayed.
// Provides the user with a notification if elements were stripped.
// Copies user input to $formData so the view can be redisplayed

function prepFormData() {

   //  Variables

   global $validTextFields, $validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $formData, $errors, $alerts;

   // Set an alert message to be displayed if invalid html/php/xml tags are discovered and stripped.
   $alertMessageInvalidTags = "Security Alert: You entered invalid data in the form of computer programming code or markup tags. This data has been removed for security reasons. The fields containing invalid data have been highlighted so that you can change them if desired.";

   $errorMessageInvalidTags = "Security Alert: Invalid tags have been removed from this field.";



   // Copy only those $_POST values that have corresponding $validTextFields values.
   // Set alerts and errors as you check.
   foreach ($validTextFields as $value) {
      if(isset($_POST[$value])) {
         $formData[$value] = strip_tags($_POST[$value]);
         if($formData[$value] != $_POST[$value]) {
            $alerts['menuBar'] = $alertMessageInvalidTags;
            $alerts['appPanel'] = $alertMessageInvalidTags;
            $alerts['toolBar'] = $alertMessageInvalidTags;
            $errors[$value] = $errorMessageInvalidTags;
         }
      }
   }

   // Create a 'checked="checked"' entry for each checkbox that requires it.
   // Loop through each checkbox element
   foreach ($validCheckFields as $key=>$value) {
      if(isset($_POST[$key])) {
         $formData[$key] = 'checked="checked"';
      }
   }

   // Create a 'checked="checked"' entry for each radio button element that requires it.
   // Loop through each radio element
   foreach($validRadioFields as $key=>$value) {
      // Loop through each option of the radio element
      foreach($validRadioFields[$key] as $name=>$submission) {
         // If the submitted radio elemnent equals a valid option, set $formData to 'checked="checked"'
         if(isset($_POST[$key]) && ($_POST[$key] == $submission)) {
            $formData[$name] = 'checked="checked"';
         }
      }
   }


   // Create a 'selected="selected"' entry for each simple selection element that requires it.
   // Loop through each valid select element
   foreach($validSelectFields as $key=>$value) {
      // Loop through each option of the select element
      foreach($validSelectFields[$key] as $name=>$submission) {
         // If the submitted select elemnent equals a valid option, set $formData to 'selected="selected"'
         if(isset($_POST[$key]) && ($_POST[$key] == $submission)) {
            $formData[$name] = 'selected="selected"';
         }
      }
   }


   // Create a 'selected="selected"' entry for each multi selection element that requires it.
   // Loop through each valid select multi element
   foreach($validSelectMultiFields as $key1=>$value1) {
      // Loop through each option of the select element
      foreach($validSelectMultiFields[$key1] as $key2=>$value2) {
         // Loop through each submitted $_POST value to see if it matches the current valid multiselect option       
         if(isset($_POST[$key1])) {
            foreach($_POST[$key1] as $keyPost=>$valuePost){
               if($valuePost == $value2) {
                  $formData[$key2] = 'selected="selected"';
               }
            }

         }
      }
   }

   return;
}
?>
