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
$application = array(); // Holds core data that the application needs to pass to the view (aside from form data).
$pageData = array(); // Holds miscellaneous information about the page, such as page and application name.
   $pageData['applicationName'] = "Respite"; // A short, descriptive name for the application of which this page is a part.
                                             // Displayed in the Title Bar.
   $pageData['pageName'] = "Basic Template"; // A short, descriptive name for the page. Displayed in the Title Bar.
   $pageData['viewFilename'] = '../../respite/main/respiteBasicTemplateView.php'; // The filename of the view that should be invoked.









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

// Start a PHP session and timeout timer
start_session();

// Authenticate the user
sessionAuthenticate();

// Initialize database connection and get handles to all databases.
init_dbs(& $dbs);

// Get URL components of current page.
getURL(& $respiteURL);

// A list of roles that are allowed to view or execute this page.
$authorizedRoles = array(
   'respite_administrator'
   );

// Determine if the user has permission to view or execute this page.
// The variable $userRoles will be available throughout the execution of the script
$userRoles = pageAuthorizationCheck($authorizedRoles, $dbs);




// ****************************************************************************************************
// Valid Fields
// ****************************************************************************************************
// Enumerate all fields that the user may submit via http POST.
// Fields are listed by type to allow them to processed appropriately
// These values correspond to the name="", value="" $formData attributes in the View's html form.
// All fields used in the View must be completely modeled here for correct operation.
// If a field is dynamically generated, e.g. from a database, then that field must be modeled
// in the getValidFieldsFromDb() function.


// $lables holds labels for fields that require them for correct operation (select, selectmulti, and radio buttons).
// Other label elements are set in the view when calling the corresponding printControl() routine
// because they are purely user interface elements and do not affect operation.
$labels = array();

// Text fields that can be redisplayed in the view.
// Includes all free text input including buttons, text, date, time, numbers, URLs, email addresses, etc.
$validTextFields = array(
   'formActionCancel',
   'formActionSave',
   'appPanelText',
   'appPanelTextArea'
   );

// Checkbox fields that require 'checked="checked"' to be redisplayed in the view.
$validCheckFields = array();

   // Value definitions

// Radio button fields that require 'checked="checked"' to be redisplayed in the view.
// Entries are of the form:
// $formElementName[name][formDataKey] = 'value';
$validRadioFields = array();

   // Value definitions

   // Label definitions


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

// Set the query string
	$formData['queryString'] = setQueryString(& $formData);

// Check request type
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
   // Request is a GET

	// Load (non-form) data the page needs to display from databases or other sources
	setPageData(& $formData, $dbs);

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
         if (!validateCancel($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, & $errors, & $alerts)) {
            // Errors were found so pack presentation variables and redisplay the view
				setPageData(& $formData, $dbs);
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
				setPageData(& $formData, $dbs);
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
// * setPageData()
// ****************************************************************************************************
// Sets the default form selections for a page when viewed for the first time.
// Defaults may be set statically or pulled from a database

function setPageData($formData, $dbs) {

	// $formData['queryString'] contains the query string if needed
	// It is unparsed and unvalidated.

	return;
}


// ****************************************************************************************************
// * setPageDefaults()
// ****************************************************************************************************
// Sets the default form selections for a page when viewed for the first time.
// Defaults may be set statically or pulled from a database

function setPageDefaults($formData, $dbs) {

   // Set static form data here
   $formData['appPanelText'] = 'Default Text.';
   $formData['appPanelTextArea'] = 'Default Text. Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi.';


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

function validateCancel($validCheckFields, $validRadioFields, $validSelectFields, $validSelectMultiFields, $dbs, $errors, $alerts) {

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

   header("Location: ../../respite/main/respiteHome.php");
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
      'appPanelTextArea'
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


   // Textarea Validation
   $textAreaMaxLength = 255;
   if(!isset($errors['appPanelTextArea'])) {
      if(strlen($_POST['appPanelTextArea']) > $textAreaMaxLength) {
         $errors['appPanelTextArea'] = 'Max length exceeded. Max length is ' . $textAreaMaxLength . ' characters.';
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
