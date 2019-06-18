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
   $pageData['pageName'] = "My Account"; // A short, descriptive name for the page. Displayed in the Title Bar.
   $pageData['viewFilename'] = '../../respite/main/myAccountView.php'; // The filename of the view that should be invoked.
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
   'formActionLogout',
   'nameFirst',
   'nameLast',
   'telephone',
   'email'
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
   err('Database Error', 'The system has encountered an error attempting to load valid fields from the database.');
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
            processSave($dbs);
         }
         break;
      case (isset($formData['formActionLogout'])): 
        if (!validateLogout()) {
           // Errors were found so pack presentation variables and redisplay the view
            packView();
            displayView($view, $pageData['viewFilename']);
         }
         else {
            // No errors were found so process the form
            processLogout();
         }
         break;
      default:
         // Do this if the user's submit request is unrecognized
         header("Location: ../../respite/main/unknownRequest.php");
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
      err('Database Error', 'This system has encountered an error attempting to load valid fields from the database.');
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
   $results = array(); // hold the query results
   $username = $_SESSION['username']; // username for query is the logged in user

   // Database lookups inserted here

   // Create the query
   $query = "SELECT name_first, name_last, telephone, email FROM " . $dbs['respite']['name'] . ".user WHERE username = :username";

   // Make the query
   try {
      // Prepare the query
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->bindParam('username', $username, PDO::PARAM_STR);
      $stmt->execute();

   }
   catch(PDOException $e) {
      // Display error: err($type, $description, $dump)
      err('Database Error', 'The system has encountered an error while attempting to connect to the database in getDefaultsFromDb()');
   }

   // Extract and display the results
   while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $results[] = $row;
   }

   // If no results were returned, then the user was not found.
   if(count($results) == 0) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "No user was found with the name {$_SESSION['username']}.<br/>Please report this to your system administrator.");
   }

   // If more than one result returned, then there is more than one user with that username.
   if(count($results) > 1) {
      // Display error: err($type, $description, $dump)
      err('Database Error', "More than one user was found with the name {$_SESSION['username']}.<br/>Please report this to your system administrator.");
   }

   // Process the data
   $formData['nameFirst'] = $results[0]['name_first'];
   $formData['nameLast'] = $results[0]['name_last'];
   $formData['email'] = $results[0]['email'];
   $formData['telephone'] = $results[0]['telephone'];

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

   if(empty($errors)) {
      // There were no errors
      return true;
   }
   else {
      // There were errors
      return false;
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

   // Alert message to inform use that there are errors somewhere in the form
   $alertMessageFormErrors = "There are errors in your submission. Please review highlighted fields and resubmit.";


   // *** Check for required fields ***
   // Set required submission elements. Note that form fields and file uploads are processed separately
   // because PHP treats them differently.
   // Requirement checks are for existence only, not valid values. Checks for valid values are
   // performed after requirement checks.

   // Required form fields listed here.
   $requiredFields = array(
      'nameFirst',
      'nameLast',
      'telephone',
      'email'
      );

   // Loop through the list of required fields checking for their existence
   foreach ($requiredFields as $value) {
      if(($_POST[$value] == '') || !isset($_POST[$value])) {
         $errors[$value] = $value . ' is a required field.';
      }
   }

   // *** Data Validation ***
   // Check that submitted values fall within accepable ranges

   // nameFirst Validation
   $textMaxLength = 255;
   if(!isset($errors['nameFirst'])) {
      if(strlen($_POST['nameFirst']) > $textMaxLength) {
         $errors['nameFirst'] = 'Max length exceeded. Max length is ' . $textMaxLength . ' characters.';
      }
   }

   // nameLast Validation
   $textMaxLength = 255;
   if(!isset($errors['nameLast'])) {
      if(strlen($_POST['nameLast']) > $textMaxLength) {
         $errors['nameLast'] = 'Max length exceeded. Max length is ' . $textMaxLength . ' characters.';
      }
   }

   // Telephone validation
   $appPanelTelMinChars = 2;
   $appPanelTelMaxChars = 25;
   if((strlen($_POST['telephone']) < $appPanelTelMinChars) || (strlen($_POST['telephone']) > $appPanelTelMaxChars)) {
      $errors['telephone'] = 'Telephone number must be between ' . $appPanelTelMinChars . ' and ' . $appPanelTelMaxChars . ' characters';
   }

   // Email validation
   if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = 'invalid email address';
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

function processSave($dbs) {

   $query = "UPDATE {$dbs['respite']['name']}.user SET ".
      "name_first = :nameFirst, " .
      "name_last = :nameLast, " .
      "telephone = :telephone, " .
      "email = :email " .
      "WHERE username = :username";

   // Make the query
   try {
      // Prepare the query
      $stmt = $dbs['respite']['handle']->prepare($query);
      $stmt->bindParam('nameFirst', $_POST['nameFirst'], PDO::PARAM_STR);
      $stmt->bindParam('nameLast', $_POST['nameLast'], PDO::PARAM_STR);
      $stmt->bindParam('email', $_POST['email'], PDO::PARAM_STR);
      $stmt->bindParam('telephone', $_POST['telephone'], PDO::PARAM_STR);
      $stmt->bindParam('username', $_SESSION['username'], PDO::PARAM_STR);
      $stmt->execute();
   }
   catch(PDOException $e) {
      // Display error: err($type, $description, $dump)
      err('Database Error', 'The system encountered an error connecting to the database in processSave()');
   }

   header("Location: ../../respite/main/home.php");

   return;
}


// ****************************************************************************************************
// * validateLogout()
// ****************************************************************************************************
// Validates submitted data for the process associated with the selected submit button.
// Ensures that all required fields contain data and all data meets validation requirements.
// Call this function with $errors and $alerts by reference to allow them to change those values.
// If errors are detected, error messages are placed in $errors.
// Returns true if all data is valid. Returns false if there are errors.

function validateLogout() {

   if(empty($errors)) {
      // There were no errors
      return true;
   }
   else {
      // There were errors
      return false;
   }
}



// ****************************************************************************************************
// * processLogout()
// ****************************************************************************************************
// This is the primary function that executes business logic on the data submitted by the user
// for the selected submit button.

function processLogout() {

   session_start();
   session_destroy();
   $redirect = "https://" . $_SERVER['HTTP_HOST'] . "/Shibboleth.sso/Logout";
   header("Location: $redirect");
   return;
}


// ****************************************************************************************************
// * end of controller
// ****************************************************************************************************
?>
