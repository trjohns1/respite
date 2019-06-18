<?php

// ****************************************************************************************************
// ****************************************************************************************************
// Controller
// ****************************************************************************************************
// ****************************************************************************************************
// All business logic is contained in this file.






// ****************************************************************************************************
// ****************************************************************************************************
// Variables
// ****************************************************************************************************
// ****************************************************************************************************
// All major program variables should be defined here.

// ****************************************************************************************************
// Primary Variables
// ****************************************************************************************************
$userRoles = array(); // A list of the roles that the current user has.
$dbs = array(); // Array holding all database info. Format: $dbs[alias][handle/name]
$view = array(); // $view is a multi-dimensional array that holds all of the data passed by the controller to the view.
$alerts = array(); // Alert messages to be displayed to the user.
$errors = array(); // Error messages to be displayed beside form input fields.
$formData = array(); // Data to be displayed in an html form, including defaults and user input.
$respiteURL = array(); // Holds various components of the active page's URL.
$pageData = array(); // Holds miscellaneous information about the page, such as page and application name.
   $pageData['applicationName'] = "Respite"; // A short, descriptive name for the application of which this page is a part.
                                             // Displayed in the Title Bar.
   $pageData['pageName'] = "Template"; // A short, descriptive name for the page. Displayed in the Title Bar.
   $pageData['viewFilename'] = '../../respite/main/respiteView.php'; // The filename of the view that should be invoked.
$application = array(); // Holds core data that the application needs to pass to the view (aside from form data).








// ****************************************************************************************************
// ****************************************************************************************************
// Includes
// ****************************************************************************************************
// ****************************************************************************************************
// Includes required for functionality
// Includes do not execute code. They merely load functions.

// *Note: to overload, remove the above reference to includes.php and instead individually list all of
// the includes you want from includes.php. You can then substitute the specific ones you wish to 
// override.
require_once "../../respite/includes_controller/includes.php";


// Connection to the database server
// The database file can be changed on a per page basis to control database security
require_once "{$db_configs_path}init_dbs_respite.php";







// ****************************************************************************************************
// ****************************************************************************************************
// Initialization
// ****************************************************************************************************
// ****************************************************************************************************
//

// Set the timezone
date_default_timezone_set('America/New_York');

// Start a PHP session and timeout timer
start_session();

// Authenticate the user
sessionAuthenticate();

// Initialize database connection and get handles to all databases.
init_dbs(& $dbs);

// A list of roles that are allowed to view or execute this page.
$authorizedRoles = array(
   'respite_user'
   );

// Determine if the user has permission to view or execute this page.
// The variable $userRoles will be available throughout the execution of the script
$userRoles = pageAuthorizationCheck($authorizedRoles, $dbs);


// Get URL components of current page.
getURL(& $respiteURL);








// ****************************************************************************************************
// Valid Fields
// ****************************************************************************************************
// Enumerate all fields that the user may submit via http POST.
// Fields are listed by type to allow them to processed appropriately
// These values correspond to the name="", value="" $formData attributes in the View's html form.
// All fields used in the View must be completely modeled here for correct operation.
// If a field is dynamically generated, e.g. from a database, then that field must be modeled
// in the getValidFieldsFromDb() function.


// $lables hold labels for fields that require them for correct operation (select, selectmulti, and radio buttons).
// Other label elements are set in the view when calling the corresponding printControl() routine
// because they are purely user interface elements and do not affect operation.
$labels = array();

// Text fields that can be redisplayed in the view.
// Includes all free text input including buttons, text, date, time, numbers, URLs, email addresses, etc.
$validTextFields = array(
   'formActionCancel',
   'formActionSave',
   'action',
   'appPanelText',
   'appPanelPassword',
   'appPanelTextArea',
   'appPanelColor',
   'appPanelDate',
   'appPanelDatetime',
   'appPanelDatetime-local',
   'appPanelEmail',
   'appPanelMonth',
   'appPanelNumber',
   'appPanelRange',
   'appPanelSearch',
   'appPanelTel',
   'appPanelTime',
   'appPanelURL',
   'appPanelWeek',
   'toolBarText',
   'toolBarPassword',
   'toolBarTextArea',
   'toolBarColor',
   'toolBarDate',
   'toolBarDatetime',
   'toolBarDatetime-local',
   'toolBarEmail',
   'toolBarMonth',
   'toolBarNumber',
   'toolBarRange',
   'toolBarSearch',
   'toolBarTel',
   'toolBarTime',
   'toolBarURL',
   'toolBarWeek',
   );

// Checkbox fields that require 'checked="checked"' to be redisplayed in the view.
$validCheckFields = array();

   // Value definitions
   $validCheckFields['appPanelCheckbox1'] = '1';
   $validCheckFields['appPanelCheckbox2'] = '2';
   $validCheckFields['appPanelCheckbox3'] = '3';
   $validCheckFields['appPanelCheckbox4'] = '4';
   $validCheckFields['appPanelCheckbox5'] = '5';
   $validCheckFields['appPanelCheckbox6'] = '6';
   $validCheckFields['toolBarCheckbox1'] = '1';
   $validCheckFields['toolBarCheckbox2'] = '2';
   $validCheckFields['toolBarCheckbox3'] = '3';
   $validCheckFields['toolBarCheckbox4'] = '4';
   $validCheckFields['toolBarCheckbox5'] = '5';
   $validCheckFields['toolBarCheckbox6'] = '6';

// Radio button fields that require 'checked="checked"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validRadioFields = array();

   // Value definitions
   $validRadioFields['appPanelRadio']['appPanelRadioOption1'] = 'One';
   $validRadioFields['appPanelRadio']['appPanelRadioOption2'] = 'The Other';
   $validRadioFields['toolBarRadio']['toolBarRadioOption1'] = 'One';
   $validRadioFields['toolBarRadio']['toolBarRadioOption2'] = 'The Other';
   // Label definitions
   $labels['appPanelRadio']['appPanelRadioOption1'] = 'Radio One';
   $labels['appPanelRadio']['appPanelRadioOption2'] = 'Radio The Other';
   $labels['toolBarRadio']['toolBarRadioOption1'] = 'Radio One';
   $labels['toolBarRadio']['toolBarRadioOption2'] = 'Radio The Other';


// Select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validSelectFields = array();

   // Value definitions
   $validSelectFields['appPanelSelect']['appPanelSelectOption1'] = 'userSelect1';
   $validSelectFields['appPanelSelect']['appPanelSelectOption2'] = 'userSelect2';
   $validSelectFields['appPanelSelect']['appPanelSelectOption3'] = 'userSelect3';
   $validSelectFields['appPanelSelect']['appPanelSelectOption4'] = 'userSelect4';
   $validSelectFields['appPanelSelect']['appPanelSelectOption5'] = 'userSelect5';
   $validSelectFields['appPanelSelect']['appPanelSelectOption6'] = 'userSelect6';
   $validSelectFields['appPanelSelect']['appPanelSelectOption7'] = 'userSelect7';
   $validSelectFields['toolBarSelect']['toolBarSelectOption1'] = 'userSelect1';
   $validSelectFields['toolBarSelect']['toolBarSelectOption2'] = 'userSelect2';
   $validSelectFields['toolBarSelect']['toolBarSelectOption3'] = 'userSelect3';
   $validSelectFields['toolBarSelect']['toolBarSelectOption4'] = 'userSelect4';
   $validSelectFields['toolBarSelect']['toolBarSelectOption5'] = 'userSelect5';
   $validSelectFields['toolBarSelect']['toolBarSelectOption6'] = 'userSelect6';
   $validSelectFields['toolBarSelect']['toolBarSelectOption7'] = 'userSelect7';
   // Label definitions
   $labels['appPanelSelect']['appPanelSelectOption1'] = 'Option1';
   $labels['appPanelSelect']['appPanelSelectOption2'] = 'Option2';
   $labels['appPanelSelect']['appPanelSelectOption3'] = 'Option3';
   $labels['appPanelSelect']['appPanelSelectOption4'] = 'Option4';
   $labels['appPanelSelect']['appPanelSelectOption5'] = 'Option5';
   $labels['appPanelSelect']['appPanelSelectOption6'] = 'Option6';
   $labels['appPanelSelect']['appPanelSelectOption7'] = 'Option7';
   $labels['toolBarSelect']['toolBarSelectOption1'] = 'Option1';
   $labels['toolBarSelect']['toolBarSelectOption2'] = 'Option2';
   $labels['toolBarSelect']['toolBarSelectOption3'] = 'Option3';
   $labels['toolBarSelect']['toolBarSelectOption4'] = 'Option4';
   $labels['toolBarSelect']['toolBarSelectOption5'] = 'Option5';
   $labels['toolBarSelect']['toolBarSelectOption6'] = 'Option6';
   $labels['toolBarSelect']['toolBarSelectOption7'] = 'Option7';


// Multi select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validSelectMultiFields = array();

   // Value definitions
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption1'] = 'userSelect1';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption2'] = 'userSelect2';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption3'] = 'userSelect3';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption4'] = 'userSelect4';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption5'] = 'userSelect5';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption6'] = 'userSelect6';
   $validSelectMultiFields['appPanelSelectMulti']['appPanelSelectMultiOption7'] = 'userSelect7';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption1'] = 'userSelect1';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption2'] = 'userSelect2';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption3'] = 'userSelect3';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption4'] = 'userSelect4';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption5'] = 'userSelect5';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption6'] = 'userSelect6';
   $validSelectMultiFields['toolBarSelectMulti']['toolBarSelectMultiOption7'] = 'userSelect7';
   // Label definitions
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption1'] = 'Option1';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption2'] = 'Option2';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption3'] = 'Option3';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption4'] = 'Option4';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption5'] = 'Option5';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption6'] = 'Option6';
   $labels['appPanelSelectMulti']['appPanelSelectMultiOption7'] = 'Option7';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption1'] = 'Option1';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption2'] = 'Option2';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption3'] = 'Option3';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption4'] = 'Option4';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption5'] = 'Option5';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption6'] = 'Option6';
   $labels['toolBarSelectMulti']['toolBarSelectMultiOption7'] = 'Option7';












// ****************************************************************************************************
// ****************************************************************************************************
// Main Control Structure
// ****************************************************************************************************
// ****************************************************************************************************
// Set initial values.
// If the request is a GET, then set page default form data and display the page.
// If the request is a POST, clean the submitted data.
// Determine which button the user pressed.
// If the submitted data is invalid, redisplay the form with error messages.
// If the submitted data is good, process the data and redirect the user to another page.
// Use a separate case statement for each named submit button.
// Use separate validate() and process() functions for each submit button in the html form.
// This allows different validation rules and business logic depending upon the button pressed.



// Static valid fields are set in the Variables section.
// Valid fields derived from the database must be set here.
if(!getValidFieldsFromDb($dbs, & $validTextFields, & $validCheckFields, & $validRadioFields, & $validSelectFields, & $validSelectMultiFields)) {
   // Error getting fields from database

   // Display error: err($type, $description, $dump)
   err('Database Error','This system has encountered an error attempting to load valid fields from the database.');
}

// Check request type
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   // Request is a GET

   // Set any default values the form should have when first loaded
   setPageDefaults(& $formData, $dbs);

   // Pack presentation variables and display the view
   packView();
   displayView($view, $pageData['viewFilename']);
}
else {
   // Request is a POST

   // Make sure the POST does not exceed post_max_size set in PHP configuration
   if (empty($_POST) && $_SERVER['CONTENT_LENGTH'] > 0) {

      // Display error: err($type, $description, $dump)
      err('Post Too Big', 'You have attempted to upload a file that exceeds the maximum allowed by the server.');

      exit;
   }

   // Strip all tags from submitted data to ensure it is safe to display and process
   // Copy user selections to  $formdata in case the view needs to be redisplayed
   prepFormData();

   // Determine which button was pressed and execute the appropriate processor
   switch(true) {
      case (isset($formData['formActionCancel'])):
         if (!validateCancel()) {
            // Errors were found so pack presentation variables and redisplay the view
            packView();
            displayView($view, $pageData['viewFilename']);
         }
         else {
            // No errors were found so process the form
            processCancel();
         }
         break;
      case (isset($formData['formActionSave'])): 
        if (!validateSave($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, & $errors, & $alerts)) {
           // Errors were found so pack presentation variables and redisplay the view
            packView();
            displayView($view, $pageData['viewFilename']);
         }
         else {
            // No errors were found so process the form
            processSave();
         }
         break;
      default:
         // Do this if the user's submit request is unrecognized

         // Display error: err($type, $description, $dump)
         $dump = print_r($_POST, TRUE);
         err('Unknown Request', 'You have submitted a request that is not recognized by this script.', $dump);

         exit;
   }
}
// end of main control structure
?>










<?php
// ****************************************************************************************************
// ****************************************************************************************************
// * Functions
// ****************************************************************************************************
// ****************************************************************************************************


// ****************************************************************************************************
// * getValidFieldsFromDb()
// ****************************************************************************************************
// Static valid fields are set in the Variables section.
// Valid fields derived from the database must be set here.
// Set dynamic valid fields just like static ones.

function getValidFieldsFromDb($dbs, $validTextFields, $validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields) {

   $errorCount = 0;

   // Database lookups inserted here

   // Process the data
   if($errorCount == 0) {
      return TRUE;
   }
   else {
      return FALSE;
   }
}

// ****************************************************************************************************
// * setPageDefaults()
// ****************************************************************************************************
// Sets the default form selections for a page when viewed for the first time.
// Defaults may be set statically or pulled from a database

function setPageDefaults($formData, $dbs) {

   // Set static form data here
   $formData['appPanelText'] = 'Default Text.';
   $formData['appPanelPassword'] = 'default password';
   $formData['appPanelTextArea'] = 'Default Text. Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi.';
   $formData['appPanelCheckbox1'] = 'checked="checked"';
   $formData['appPanelCheckbox2'] = 'checked="checked"';
   $formData['appPanelCheckbox3'] = 'checked="checked"';
   $formData['appPanelCheckbox4'] = 'checked="checked"';
   $formData['appPanelCheckbox5'] = 'checked="checked"';
   $formData['appPanelCheckbox6'] = 'checked="checked"';
   $formData['appPanelSelectOption4'] = 'selected="selected"'; // Select dropdown list. Select one ---
   $formData['appPanelSelectMultiOption2'] = 'selected="selected"'; // Select dropdown list. Select several
   $formData['appPanelSelectMultiOption4'] = 'selected="selected"'; // Select dropdown list. Select several
   $formData['appPanelRadioOption2'] = 'checked="checked"'; // Radio buttons. Select one ---
   $formData['appPanelColor'] = '#ff0000';
   $formData['appPanelDate'] = '1776-07-04';
   $formData['appPanelDatetime'] = '2013-04-23T11:35Z';
   $formData['appPanelDatetime-local'] = '2013-04-23T11:35';
   $formData['appPanelEmail'] = 'user@example.com';
   $formData['appPanelMonth'] = '1787-02';
   $formData['appPanelNumber'] = '22';
   $formData['appPanelRange'] = '25'; // Note that range must have a default value
   $formData['appPanelSearch'] = 'enter search term(s)';
   $formData['appPanelTel'] = '(919) ';
   $formData['appPanelTime'] = '11:15';
   $formData['appPanelURL'] = 'http://www.example.com';
   $formData['appPanelWeek'] = '2013-W05';



   // Set database-derived default form data
   if(!getDefaultsFromDb(& $formData, $dbs)) {
      // Error getting fields from database

      // Display error: err($type, $description, $dump)
      err('Database Error', 'This system has encountered an error attempting to load default values from the database in getDefaultsFromDb().');
   }

   return;
}





// ****************************************************************************************************
// * getDefaultsFromDb()
// ****************************************************************************************************
// Static default form values are set in the Variables section.
// Page default values derived from the database must be set here.

function getDefaultsFromDb($formData, $dbs) {

   $errorCount = 0;

   // Database lookups inserted here

   // Process the data

   if($errorCount == 0) {
      return TRUE;
   }
   else {
      return FALSE;
   }
}





// ****************************************************************************************************
// * validateCancel()
// ****************************************************************************************************
// Validates submitted data for the process associated with the selected submit button.
// Ensures that all required fields contain data and all data meets validation requirements.
// Call this function with $errors and $alerts by reference to allow them to change those values.
// If errors are detected, error messages are placed in $errors.
// Returns true if all data is valid. Returns false if there are errors.

function validateCancel() {

   $errorCount = 0;

   if($errorCount == 0) {
      return TRUE;
   }
   else {
      return FALSE;
   }
}



// ****************************************************************************************************
// * processCancel()
// ****************************************************************************************************
// This is the primary function that executes business logic on the data submitted by the user
// for the selected submit button.

function processCancel() {

   header("Location: ../../respite/main/home.php");
   return;
}



// ****************************************************************************************************
// * validateSave()
// ****************************************************************************************************
// Validates submitted data for the process associated with the selected submit button.
// Ensures that all required fields contain data and all data meets validation requirements.
// Call this function with $errors and $alerts by reference to allow them to change those values.
// If errors are detected, error messages are placed in $errors.
// Returns true if all data is valid. Returns false if there are errors.
// Note that this function does not process or type the $_POST data in any way. That is left to the
// specific processing function.

function validateSave($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, $errors, $alerts) {


   // Variables

   // An array holding error messages in case of file upload errors.
   $fileUploadErrors = array(
      '0' => 'File upload successful.',
      '1' => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
      '2' => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
      '3' => 'The uploaded file was only partially uploaded.',
      '4' => 'No file was uploaded.',
      '5' => '',
      '6' => 'Missing a temporary folder.',
      '7' => 'Failed to write file to disk.',
      '8' => 'A PHP extension stopped the file upload.',
      );

   // Alert message to inform use that there are errors somewhere in the form
   $alertMessageFormErrors = "There are errors in your submission. Please review highlighted fields and resubmit.";


   // *** Check for required fields ***
   // Set required submission elements. Note that form fields and file uploads are processed separately
   // because PHP treats them differently.
   // Requirement checks are for existence only, not valid values. Checks for valid values are
   // performed after requirement checks.

   // Required form fields listed here.
   $requiredFields = array(
      'appPanelText',
      'appPanelPassword',
      'appPanelTextArea',
      'appPanelCheckbox1',
      'appPanelCheckbox2',
      'appPanelCheckbox3',
      'appPanelCheckbox4',
      'appPanelCheckbox5',
      'appPanelCheckbox6',
      'appPanelSelect',
      'appPanelSelectMulti',
      'appPanelRadio',
      'appPanelColor',
      'appPanelDate',
      'appPanelDatetime',
      'appPanelDatetime-local',
      'appPanelEmail',
      'appPanelMonth',
      'appPanelNumber',
      'appPanelRange',
      'appPanelSearch',
      'appPanelTel',
      'appPanelTime',
      'appPanelURL',
      'appPanelWeek'
      );

   // Loop through the list of required fields checking for their existence
   foreach ($requiredFields as $value) {
      if(($_POST[$value] == '') || !isset($_POST[$value])) {
         $errors[$value] = $value . ' is a required field.';
      }
   }

   // Required file upload fields listed here.
   $requiredFiles = array(
      //  List required file fields here. For example:
      // 'appPanelFile'
      );

   // Loop through the list of required files checking for their existence
   foreach ($requiredFiles as $key=>$value) {
      if(!isset($_FILES[$value]) || $_FILES[$value]['error'] == 4) {
         $errors[$value] = $value . ' is a required field.';
      }
   }

   // *** Data Validation ***
   // Check that submitted values fall within accepable ranges

   // Text Validation
   $textMaxLength = 255;
   if(!isset($errors['appPanelText'])) {
      if(strlen($_POST['appPanelText']) > $textMaxLength) {
         $errors['appPanelText'] = 'Max length exceeded. Max length is ' . $textMaxLength . ' characters.';
      }
   }

   // Password Validation
   $passwordMaxLength = 255;
   $passwordMinLength = 8;
   if(!isset($errors['appPanelPassword'])) {

      if(strlen($_POST['appPanelPassword']) > $passwordMaxLength) {
         $errors['appPanelPassword'] = 'Your password is too long. Max length is ' . $passwordMaxLength . ' characters.';
      }

      if(strlen($_POST['appPanelPassword']) < $passwordMinLength) {
         $errors['appPanelPassword'] = 'Your password is too short. Minimum length is ' . $passwordMinLength . ' characters.';
      }

      if(!preg_match("#[0-9]+#", $_POST['appPanelPassword'])) {
         $errors['appPanelPassword'] = 'Password must include at least one number.';
      }

      if(!preg_match("#[a-z]+#", $_POST['appPanelPassword'])) {
         $errors['appPanelPassword'] = 'Password must include at least one letter.';
      }

      if(!preg_match("#[A-Z]+#", $_POST['appPanelPassword'])) {
         $errors['appPanelPassword'] = 'Password must include at least one CAPITAL letter.';
      }

      if(!preg_match("#\W+#", $_POST['appPanelPassword'])) {
         $errors['appPanelPassword'] = 'Password must include at least one symbol.';
      }
   }

   // Textarea Validation
   $textAreaMaxLength = 255;
   if(!isset($errors['appPanelTextArea'])) {
      if(strlen($_POST['appPanelTextArea']) > $textAreaMaxLength) {
         $errors['appPanelTextArea'] = 'Max length exceeded. Max length is ' . $textAreaMaxLength . ' characters.';
      }
   }

   // Checkbox Validation
   // Loop through all checkboxes ensuring valid entries
   foreach($validCheckFields as $key=>$value) {
      if(isset($_POST[$key]) && ($validCheckFields[$key] != $_POST[$key])) {
         $errors[$key] = 'Invalid value submitted.';
      }
   }

   // Select Validation
   // Loop through all select lists ensuring valid entries
   foreach($validSelectFields as $key1=>$value1) {
      $validMatchCounter = 0;
      foreach($validSelectFields[$key1] as $key2=>$value2) {
         if(isset($_POST[$key1]) && ($value2 == $_POST[$key1])) {
            $validMatchCounter++;
         }
      }
      if($validMatchCounter == 0)  {
         $errors[$key1] = 'Invalid value submitted.';
      }
   }

   // Select Multi Validation
   // Loop through all the select multi lists ensuring valid entries
   $validMatchCounter = array(); // holds a counter for each individual submission
   foreach($validSelectMultiFields as $key1=>$value1) {
      foreach($validSelectMultiFields[$key1] as $key2=>$value2) {
         if(isset($_POST[$key1])) {
            foreach($_POST[$key1] as $value3) {
               if(!isset($validMatchCounter[$key1][$value3])) {
                  $validMatchCounter[$key1][$value3] = 0;
               }
               if($value3 == $value2) {
                  $validMatchCounter[$key1][$value3]++;
               }
            }
         }
      }
   }
   // $validMatchCounter now countains an array of submitted elements and the number of matched valid choices.
   // A zero in the array indicates the submission did not match any valid choices.
   // A number in the array greater than one indicates that the POST contained the same submission more than once.
   // A one in the array indicates that the POST contained exactly one matching valid choice. This is the expected value.
   // Loop through the array. If anything other than a one is found, the submission is invalid.
   foreach($validMatchCounter as $key4=>$value4) {
      foreach($validMatchCounter[$key4] as $key5=>$value5) {
         if($value5 != 1) {
            $errors[$key4] = 'Invalid value submitted.';
         }
      }
   }

   // Radio button validation
   // Loop through all the radio buttons ensuring valid entries
   foreach($validRadioFields as $key1=>$value1) {
      $validMatchCounter = 0;
      foreach($validRadioFields[$key1] as $key2=>$value2) {
         if(isset($_POST[$key1]) && ($_POST[$key1] == $value2)) {
            $validMatchCounter++;
         }
      }
      if($validMatchCounter == 0) {
         $errors[$key1] = 'Invalid radio value submitted.';
      }
   }

   // Loop through the list of required files checking for file upload errors
   foreach ($_FILES as $key=>$value) {
      if($_FILES[$key]['error'] != 0 && $_FILES[$key]['error'] != 4) {
         $errors[$key] = 'Error ' . $_FILES[$key]['error'] . ': ' . $fileUploadErrors[$_FILES[$key]['error']] . ' ' . $key;
      }
   }

   // Color validation
   if(!preg_match('/^#[a-f0-9]{6}$/i', $_POST['appPanelColor'])) {
      $errors['appPanelColor'] = "Invalid color submitted";
   }

   // Date validation
   $appPanelDateMin = '1776-01-01';
   $appPanelDateMax = '1776-12-31';
   if(isValidDate($_POST['appPanelDate'])) {
      if((strtotime($_POST['appPanelDate']) < strtotime($appPanelDateMin)) || (strtotime($_POST['appPanelDate']) > strtotime($appPanelDateMax))) {
            $errors['appPanelDate'] = 'Date must be between ' . $appPanelDateMin . ' and ' . $appPanelDateMax;
       }
   }
   else {
      $errors['appPanelDate'] = "Invalid date (YYYY-MM-DD)";
   }

   // Datetime validation
   $appPanelDatetimeMin = '2011-01-01';
   $appPanelDatetimeMax = '2013-12-31';
   if(isValidDatetime($_POST['appPanelDatetime'])) {
      if((strtotime($_POST['appPanelDatetime']) < strtotime($appPanelDatetimeMin)) || (strtotime($_POST['appPanelDatetime']) > strtotime($appPanelDatetimeMax))) {
            $errors['appPanelDatetime'] = 'Date must be between ' . $appPanelDatetimeMin . ' and ' . $appPanelDatetimeMax;
       }
   }
   else {
      $errors['appPanelDatetime'] = "Invalid date/time (YYYY-MM-DDTHH:MM:SSZ)";
   }

   // Datetime-local validation
   $appPanelDatetimeLocalMin = '2013-01-01';
   $appPanelDatetimeLocalMax = '2013-12-31';
   if(isValidDatetimeLocal($_POST['appPanelDatetime-local'])) {
      if((strtotime($_POST['appPanelDatetime-local']) < strtotime($appPanelDatetimeLocalMin)) || (strtotime($_POST['appPanelDatetime-local']) > strtotime($appPanelDatetimeLocalMax))) {
            $errors['appPanelDatetime-local'] = 'Date must be between ' . $appPanelDatetimeMin . ' and ' . $appPanelDatetimeMax;
       }
   }
   else {
      $errors['appPanelDatetime-local'] = "Invalid date/time (YYYY-MM-DDTHH:MM:SS)";
   }

   // Email validation
   if(!filter_var($_POST['appPanelEmail'], FILTER_VALIDATE_EMAIL)) {
      $errors['appPanelEmail'] = 'invalid email address';
   }

   // Month validation
   $appPanelMonthMin = '1787-01';
   $appPanelMonthMax = '1787-12';
   if(isValidMonth($_POST['appPanelMonth'])) {
      if((strtotime($_POST['appPanelMonth']) < strtotime($appPanelMonthMin)) || (strtotime($_POST['appPanelMonth']) > strtotime($appPanelMonthMax))) {
            $errors['appPanelMonth'] = 'Date must be between ' . $appPanelMonthMin . ' and ' . $appPanelMonthMax;
       }
   }
   else {
      $errors['appPanelMonth'] = "Invalid month (YYYY-MM)";
   }

   // Number validation
   $appPanelNumberMin = 0;
   $appPanelNumberMax = 25;
   if(is_numeric($_POST['appPanelNumber'])) {
      if(($_POST['appPanelNumber'] < $appPanelNumberMin) || ($_POST['appPanelNumber'] > $appPanelNumberMax)) {
         $errors['appPanelNumber'] = 'Input must be between ' . $appPanelNumberMin . ' and ' . $appPanelNumberMax;
      }
   }
   else {
      $errors['appPanelNumber'] = 'Invalid number. Enter an integer or decimal.';
   }

   // Range validation
   $appPanelRangeMin = 5;
   $appPanelRangeMax = 25;
   if(is_numeric($_POST['appPanelRange'])) {
      if(($_POST['appPanelRange'] < $appPanelRangeMin) || ($_POST['appPanelRange'] > $appPanelRangeMax)) {
         $errors['appPanelRange'] = 'Input out of range';
      }
   }
   else {
      $errors['appPanelRange'] = 'Invalid number. Enter an integer or decimal.';
   }

   // Search validation
   // (strip_tags() has already performed on this field)
   $validSearchTerm = true;
   if(!$validSearchTerm) {
      $errors['appPanelSearch'] = 'Invalid search term';
   }

   // Telephone validation
   $appPanelTelMinChars = 2;
   $appPanelTelMaxChars = 25;
   if((strlen($_POST['appPanelTel']) < $appPanelTelMinChars) || (strlen($_POST['appPanelTel']) > $appPanelTelMaxChars)) {
      $errors['appPanelTel'] = 'Telephone number must be between ' . $appPanelTelMinChars . ' and ' . $appPanelTelMaxChars . ' characters';
   }

   // Time validation
   $appPanelTimeMin = '09:00';
   $appPanelTimeMax = '17:00';
   if(isValidTime($_POST['appPanelTime'])) {
      if((strtotime($_POST['appPanelTime']) < strtotime($appPanelTimeMin)) || (strtotime($_POST['appPanelTime']) > strtotime($appPanelTimeMax))) {
            $errors['appPanelTime'] = 'Time must be between ' . $appPanelTimeMin . ' and ' . $appPanelTimeMax;
       }
   }
   else {
      $errors['appPanelTime'] = "Invalid time (HH:MM) or (HH:MM:SS)";
   }

   // URL validation
   if(!filter_var($_POST['appPanelURL'], FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
      $errors['appPanelURL'] = 'invalid URL';
   }

   // Week validation
   $appPanelWeekMin = '2013-W01';
   $appPanelWeekMax = '2013-W06';
   if(!isValidWeek($_POST['appPanelWeek'])) {
      $errors['appPanelWeek'] = "Invalid week (YYYY-W52)";
   }
   else {
      if((strtotime($_POST['appPanelWeek']) < strtotime($appPanelWeekMin)) || (strtotime($_POST['appPanelWeek']) > strtotime($appPanelWeekMax))) {
         $errors['appPanelWeek'] = 'Week must be between ' . $appPanelWeekMin . ' and ' . $appPanelWeekMax;
      }
   }

   // Validation complete
   // Return false if any errors were found. Otherwise return true.
   if(empty($errors)) {
      // There were no errors
      return true;
   }
   else {
      // There were errors
      $alerts['appPanel'] = $alertMessageFormErrors;
      return false;
   }
}

// ****************************************************************************************************
// * processSave()
// ****************************************************************************************************
// This is the primary function that executes business logic on the data submitted by the user
// for the selected submit button.

function processSave() {

   echo "processing Save...<br>\n\n";
   echo "Your HTTP POST contained the following data:<br> \n\n";
   print_r($_POST);
   exit;

   return;
}




// ****************************************************************************************************
// * end of controller
// ****************************************************************************************************
?>
