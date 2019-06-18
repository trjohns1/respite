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
   $pageData['pageName'] = "Off-line"; // A short, descriptive name for the page. Displayed in the Title Bar.
   $pageData['viewFilename'] = '../../respite/main/offlineView.php'; // The filename of the view that should be invoked.
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
   'respite_administrator'
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
   'cancel',
   'activate',
   'offlineMode',
   'message'
   );

// Checkbox fields that require 'checked="checked"' to be redisplayed in the view.
$validCheckFields = array();

   // Value definitions


// Radio button fields that require 'checked="checked"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validRadioFields = array();

   // Value definitions
   $validRadioFields['offlineMode']['offline'] = 'Offline';
   $validRadioFields['offlineMode']['production'] = 'Production';

   // Label definitions
   $labels['offlineMode']['offline'] = 'Off-line';
   $labels['offlineMode']['production'] = 'Production';


// Select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validSelectFields = array();

   // Value definitions

   // Label definitions



// Multi select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Select drop down lists that require 'selected="selected"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validSelectMultiFields = array();

   // Value definitions

   // Label definitions













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
      case (isset($formData['cancel'])):
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
      case (isset($formData['activate'])): 
        if (!validateActivate($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, & $errors, & $alerts)) {
           // Errors were found so pack presentation variables and redisplay the view
            packView();
            displayView($view, $pageData['viewFilename']);
         }
         else {
            // No errors were found so process the form
            processActivate($dbs);
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

   $results = array();

   // Database lookups inserted here

   // Get offline status
   $query = "SELECT parameter, value FROM {$dbs['respite']['name']}.system WHERE parameter = 'offline'";

   // Make the query
   try {
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "The system has encountered an error attempting to access the database.", $ex);
   }
   // Extract and display the results
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
   }


   // Error check the results
   if(is_null(count($results)) || count($results) < 1) {
      err('Database Error', "System mode not found.");
   }
   if(count($results) > 1) {
      err('Database Error', "More than one system mode found.");
   }

   // Make sure the database contains a valid offline value
   if(is_null($results[0]['value'])) {
      err('Database Error', "No valid system mode found.");
   }

   // Set the mode in $formData
   if($results[0]['value']) {
      $formData['offline'] = 'checked="checked"';
   }
   else {
      $formData['production'] = 'checked="checked"';
   }


   // Get offline Message
   $results = array();
   $query = "SELECT parameter, value FROM {$dbs['respite']['name']}.system WHERE parameter = 'offlineMessage'";

   // Make the query
   try {
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "The system has encountered an error attempting to access the database.", $ex);
   }
   // Extract and display the results
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
   }

   // Error check the results
   if(count($results) > 1) {
      err('Database Error', "More than one offline message found.");
   }

   // If message is null, set it to an empty string
   if(is_null(count($results))) {
      $results[0]['value'] = '';
   }

   // Set the mode in $formData
   $formData['message'] = $results[0]['value'];

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

   header("Location: ../../respite/main/adminHome.php");
   return;
}



// ****************************************************************************************************
// * validateActivate()
// ****************************************************************************************************
// Validates submitted data for the process associated with the selected submit button.
// Ensures that all required fields contain data and all data meets validation requirements.
// Call this function with $errors and $alerts by reference to allow them to change those values.
// If errors are detected, error messages are placed in $errors.
// Returns true if all data is valid. Returns false if there are errors.
// Note that this function does not process or type the $_POST data in any way. That is left to the
// specific processing function.

function validateActivate($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, $errors, $alerts) {


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
      'message'
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




   // Textarea Validation
   $textAreaMaxLength = 255;
   if(!isset($errors['message'])) {
      if(strlen($_POST['message']) > $textAreaMaxLength) {
         $errors['message'] = 'Max length exceeded. Max length is ' . $textAreaMaxLength . ' characters.';
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
// * processActivate()
// ****************************************************************************************************
// This is the primary function that executes business logic on the data submitted by the user
// for the selected submit button.

function processActivate($dbs) {

   // Update the system mode

   // Set system mode to 1 or 0
   if($_POST['offlineMode'] == 'Offline') {
      $systemMode = 1;
   }
   else {
      $systemMode = 0;
   }

   // Define the query
   $query = "UPDATE {$dbs['respite']['name']}.system SET " .
      "value = :offline " .
      "WHERE parameter = 'offline'";

   // Make the query
   try {
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->bindParam('offline', $systemMode, PDO::PARAM_STR);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "The system has encountered an error attempting to access the database.", $ex);
   }

   // Update the offline message

   // Define the query
   $query = "UPDATE {$dbs['respite']['name']}.system SET " .
      "value = :message " .
      "WHERE parameter = 'offlineMessage'";


   // Make the query
   try {
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->bindParam('message', $_POST['message'], PDO::PARAM_STR);
      $stmt->execute();
   }
   catch(PDOException $ex) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "The system has encountered an error attempting to access the database.", $ex);
   }

   header("Location: ../../respite/main/adminHome.php");
   return;
}




// ****************************************************************************************************
// * end of controller
// ****************************************************************************************************
?>
