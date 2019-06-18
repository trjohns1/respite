<?php

// ****************************************************************************************************
// * packView()
// ****************************************************************************************************
// Copies all presentation data to the $view data structure.

function packView() {

   global $view, $formData, $alerts, $errors, $respiteURL, $validTextFields, $validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $labels, $pageData, $application, $userRoles;

   // Copies data from the controller into variables to be exposed to the view.
   // All variables that the controller exposes to the view must be packed here.
   $view['alerts'] = $alerts;
   $view['errors'] = $errors;
   $view['formData'] = $formData;
   $view['respiteURL'] = $respiteURL;
   $view['labels'] = $labels;
   $view['validTextFields'] = $validTextFields;
   $view['validCheckFields'] = $validCheckFields;
   $view['validRadioFields'] = $validRadioFields;
   $view['validSelectFields'] = $validSelectFields;
   $view['validSelectMultiFields'] = $validSelectMultiFields;
   $view['pageData'] = $pageData;
   $view['application'] = $application;
   $view['user']['roles'] = $userRoles;

   return;
}

?>
