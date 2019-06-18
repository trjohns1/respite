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
   $pageData['pageName'] = "Home"; // A short, descriptive name for the page. Displayed in the Title Bar.
   $pageData['viewFilename'] = '../../respite/main/respiteHomeView.php'; // The filename of the view that should be invoked.
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
   'resource_user'
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
$validTextFields = array();

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

      // Display error: err($type, $description, $dump)
      err('Post Too Big', 'You have attempted to upload a file that exceeds the maximum allowed by the server.');
   }

   // Strip all tags from submitted data to ensure it is safe to display and process
   // Copy user selections to  $formdata in case the view needs to be redisplayed
   prepFormData();

   // Determine which button was pressed and execute the appropriate processor
   switch(true) {
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
// * end of controller
// ****************************************************************************************************
?>
