
<?php
// ****************************************************************************************************
// ****************************************************************************************************
// * Controller / View Interface
// ****************************************************************************************************
// ****************************************************************************************************
// All variables that the controller exposes to the view must be documented here.
//
// Unless otherwise documented, all data exposed to the view can be found in the $view array.
// $view is a multi-dimensional associative array of the form:
//    $view[][]...
//
// Note that the degree of the array may vary. $view is not always necessarily two dimensional.
//
// The documentation below shows each data element. Where there are associative indices the name last
// array element is empty and those listed below it show possible values.
//
// Example:
// **$view['sports'][] : an array holding types of sports
//    ['baseball'] : baseball
//    ['soccer'] : soccer
//    ['football'] : American footbal/
//    ['basketball'] : basketball
//
// In this example $view['sports']['soccer'] holds a value related to soccer and
// $view['sports']['basketball'] holds a value related to basketball.
//
//
// Troubleshooting
// Use print_r ($view); to see the entire data structure passed to the view.
// Do not assume that all values are set. The view should test for the presence of a value before
// attempting to present it.
//
// ****************************************************************************************************
// * $view data structure documentation
// ****************************************************************************************************
// 
// ** Alert Messages
// $view['alerts'][] : an array holding alert messages
//    ['menuBar'] : Alert message text for menu bar.
//    ['appPanel'] : Alert message text for app panel.
//    ['toolBar'] : Alert message text for tool bar.
//
// ** Input Errors
// $view['errors']
//    [field] : an array containing all input error messages such as 'This is a required field' or
//              'invalid date format'. 'field' corresponds to the name attribute of the form field.
//
// ** Default User Input
// $view['formData']
//    [field] : An html form may be displayed with default values selected or entered. Or a user may
//              may enter values into form fields but the form is redisplayed to the user
//              because of a failure to enter valid or required data. The $view['default'] array holds
//              these predetermined or user-entered values until the form is submitted without
//              error. 'field' corresponds to the name attribute of the form field.
//
// ** URL Components
// $view['respiteURL'][] : an array holding components of the current URL.
//    ['protocol'] : 'http' or 'https'
//    ['host'] : hostname
//    ['script'] : URL pathname
//    ['params'] : query string of URL if any
//    ['currentURL'] : the full current URL without any parameters
//    ['currentURLParams'] : the full current URL with parameters
//    ['menuBarAnchor'] : menu bar anchor URL
//    ['appPanelAnchor'] : app panel anchor URL
//    ['toolBarAnchor'] : tool bar anchor URL
//
// ** Labels
// $view['labels'] : an array holding labels for form fields that require 'checked=checked' for proper display
//
// ** Valid Text Fields
// $view['validTextFields'] : an array holding all text input fields and buttons
//
// ** Valid Check Fields
// $view['validCheckFields'] : an array holding all valid checkbox form fields
//
// ** Valid Radio Fields
// $view['validRadioFields'] : an array holding all valid radio button form fields
//
// ** Valid Select Fields
// $view['validSelectFields'] : an array holding all valid selection list form fields
//
// ** Valid Select Multi Fields
// $view['validSelectMultiFields'] : an array holding all valid multiple selection list form fields
//
// ** Page Data
// $view['pageData'][] : an array holding information about the page
//    ['applicationName'] : The name of the application of which this view is a part. Displayed in title bar.
//    ['pageName'] : A user friendly name for this page. Displayed in title bar.
//    ['viewFilename'] : This filename. Allows a controller to easily switch views.
//
// ** Application
// $view['application'] : Core data that the application can display.
//
// ** User Data
// $view['user'][] : an array holding user data
//    ['roles'][] : roles that the user currently has. Can be used for selective display.
//
?>

<?php
// ****************************************************************************************************
// * View Testing
// ****************************************************************************************************
// It is possible to test view functionality without any controller being present.
// Fields from the Controller/View Interface can be set here to see their presentation.
// Load this file directly in a browser.
// Example:
// $view['alerts']['toolBar'] = 'Toolbar alert!';
?>



<?php
   // Helper functions to aid in user interface display
   require_once "../../respite/includes_view/print_error.php";
   require_once "../../respite/includes_view/print_formData.php";
   require_once "../../respite/includes_view/printControls.php";
   require_once "../../respite/includes_view/isAuthorized.php";
?>

<?php
// ****************************************************************************************************
// ****************************************************************************************************
// * View
// ****************************************************************************************************
// ****************************************************************************************************
// All display markup follows here
?>


<?php
   // Includes required for TEX functionality
   require_once "../../respite/includes_view/header.php";
?>

<form id="mainForm" action="<?php echo $view['respiteURL']['currentURL']?>" method="POST" enctype="multipart/form-data">

<?php
// ****************************************************************************************************
// * Title Bar
// ****************************************************************************************************
?>
   <div id="titleBar">
      <a href="<?php echo $view['respiteURL']['menuBarAnchor'] ?>"> <img src="../../respite/css/images/icon_menu.png" alt="menu icon" id="icon_menu"></a>
      <p id="titleBarText"><?php echo $view['pageData']['applicationName']. ": " . $view['pageData']['pageName'] ?></p>
      <a href="<?php echo $view['respiteURL']['appPanelAnchor'] ?>"> <img src="../../respite/css/images/icon_home.png" alt="home icon" id="icon_home"></a>
      <a href="<?php echo $view['respiteURL']['toolBarAnchor'] ?>"> <img src="../../respite/css/images/icon_tools.png" alt="tools icon" id="icon_tools"></a>
   </div>





<?php
// ****************************************************************************************************
// * App Panel
// ****************************************************************************************************
?>

   <div id="appPanelOuter">

      <?php // Divider ?>
      <div class="divider" id="appPanelOuterDivider">
      </div>

      <div id="appPanel">

            <?php
               // If there is an app panel alert display it.
               if (isset($view['alerts']['appPanel'])) {
                  echo '<div class="alert">';
                  echo '<h1>Alert !</h1>';
                  echo '<p>' . $view['alerts']['appPanel'] . '</p>';
                  echo '</div>';
               }
            ?>

            <h1>Respite</h1>
            <p>Welcome to the Respite homepage.</p>

            <p>Respite is responsive PHP web framework for building database enabled web applications.</p>
            <p>The Full template includes every conceivable HTML5 element in all places in the user interface. The basic template provides a skeleton page. A good starting place for creating a page is to copy the basic template, and then copy/paste needed elements from the full template.</p>

      </div>
   </div>













<?php
// ****************************************************************************************************
// * Tool Bar
// ****************************************************************************************************
?>
   
   <div id="toolBarOuter">

      <?php // Divider ?>
      <div class="divider" id="toolBarOuterDivider">
      </div>

      <div id="toolBar">

            <?php
               // If there is a tool bar alert disply it.
               if (isset($view['alerts']['toolBar'])) {
                  echo '<div class="alert">';
                  echo '<h1>Alert !</h1>';
                  echo '<p>' . $view['alerts']['toolBar'] . '</p>';
                  echo '</div>';
               }
            ?>

            <div id="toolBarMenu">
               <ul>
			<li class="toolBarMenuDivider">Select a Resource</li>
                  <li><a href="../../respite/main/respiteFullTemplate.php">Full Template</a></li>
                  <li><a href="../../respite/main/respiteBasicTemplate.php">Basic Template</a></li>
               </ul>
            </div>


       </div>
   </div>





</form>





<?php
// ****************************************************************************************************
// * Menu Bar
// ****************************************************************************************************
?>

<div id="menuBar">

   <?php // Divider ?>
   <div class="divider" id="menuBarDivider">
   </div>


   <?php
      // If there is a menu bar alert disply it.
      if (isset($view['alerts']['menuBar'])) {
         echo '<div class="alert">';
         echo '<h1>Alert !</h1>';
         echo '<p>' . $view['alerts']['menuBar'] . '</p>';
         echo '</div>';
      }
   ?>
   <div id="menu">
      <p class="menuDivider"></p>
      <ul>
         <?php
            // Insert the list of common applications displayed in the menu bar.
            require_once "../../respite/includes_view/app_menu.php";
         ?>

      </ul>
      <p class="menuDivider"></p>
   </div>
</div>









<?php
// ****************************************************************************************************
// * Scripts
// ****************************************************************************************************
// Javascript includes go here to ensure the page is fully loaded before execution begins
//
// Common scripts for all pages
   require_once "../../respite/includes_view/scripts.php";
?>

<?php // Scripts unique to this page ?>



<?php
// ****************************************************************************************************
// * Footer
// ****************************************************************************************************
   require_once "../../respite/includes_view/footer.php";
?>




<?php
// ****************************************************************************************************
// * End of View
// ****************************************************************************************************
?>
