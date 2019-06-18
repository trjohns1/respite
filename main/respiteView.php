
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

            <H1>Respite</H1>

            <p>Respite is a responsive web application framework</p>
            <p>Respite offers the following features:</p>
            <ul>
               <li>Quick creation of new applications.</li>
               <li>Responsive web design adapts to computers, tablets, and smartphones.</li>
               <li>Full HTML5 / CSS3 implementation.</li>
               <li>MySQL templates support easy database-driven applications.</li>
               <li>Model / View / Controller architecture.</li>
               <li>Separate View with automatic form control generators makes forms quick and reduce errors.</li>
               <li>Javascript widget templates.</li>
            </ul>


            <p class="group_label">App Panel Form Elements</p>
            <div class="group">
               <?php printControlText('appPanelText', & $view, 'Text Label', 'Text helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlPassword('appPanelPassword', & $view, 'Password Label', 'Password helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTextArea('appPanelTextArea', & $view, 'TextArea Label', 'TextArea helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlCheckbox('appPanelCheckbox1', & $view, 'Box Label 1', 'Checkbox', 'Checkbox helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlLabelOnly('LabelOnly', 'LabelOnly helper text goes here'); ?>
               <?php printControlCheckbox('appPanelCheckbox2', & $view, 'Box Label 2', '', '', 'dirty'); ?>
               <?php printControlCheckbox('appPanelCheckbox3', & $view, 'Box Label 3', '', '', 'dirty'); ?>
               <?php printControlCheckbox('appPanelCheckbox4', & $view, 'Box Label 4', '', '', 'dirty'); ?>
               <?php printControlCheckbox('appPanelCheckbox5', & $view, 'Box Label 5', '', '', 'dirty'); ?>
               <?php printControlCheckbox('appPanelCheckbox6', & $view, 'Box Label 6', '', '', 'dirty'); ?>
               <hr />
               <?php printControlSelect('appPanelSelect', & $view, 'Select Label', 'Select helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlSelectMulti('appPanelSelectMulti', & $view, 'SelectMulti Label', 'SelectMulti helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlRadio('appPanelRadio', & $view, 'Radio Label', 'Radio helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlFile('appPanelFile', & $view, 'File Label', 'File helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlColor('appPanelColor', & $view, 'Color Label', 'Color helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDate('appPanelDate', & $view, 'Date Label', 'Date helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDatetime('appPanelDatetime', & $view, 'Datetime Label', 'Datetime helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDatetimeLocal('appPanelDatetime-local', & $view, 'Datetime-local Label', 'Datetime-local helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlEmail('appPanelEmail', & $view, 'Email Label', 'Email helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlMonth('appPanelMonth', & $view, 'Month Label', 'Month helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlNumber('appPanelNumber', & $view, 'Number Label', 'Number helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlRange('appPanelRange', & $view, 'Range Label', 'Range helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlSearch('appPanelSearch', & $view, 'Search Label', 'Search helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTel('appPanelTel', & $view, 'Tel Label', 'Tel helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTime('appPanelTime', & $view, 'Time Label', 'Time helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlURL('appPanelURL', & $view, 'URL Label', 'URL helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlWeek('appPanelWeek', & $view, 'Week Label', 'Week helper text goes here', 'dirty'); ?>
            </div>
            


            <p class="group_label">Group Label (Group Widget)</p>
            <div class="group">
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Note</label>
                  </div>
                  <div class="GroupRight">
                      <p class="note">Lorem ipsum dolor sit amet, <a href=#>mauris nonummy</a> quisque adipiscing, quis quod non interdum velit, est nonummy diam ipsum sem. Dolor sed pellentesque etiam feugiat lorem volutpat, vehicula porta semper proin congue, malesuada amet ac. Vel nam auctor cras nunc ut, fermentum vitae turpis dictum congue a quia, amet ornare nunc varius id, fringilla sed elit natoque felis mi. Sed mollis risus lorem per ornare sem. Dolor ultrices donec ut mattis nulla, felis fermentum, vitae hendrerit dignissim. Egestas sed lobortis tellus praesent mauris blandit, nibh a eu ultricies eros sed mauris, vitae velit in justo, nibh nullam, neque montes duis orci praesent et lectus.</p>
                      <p class="tinyNote">Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi. Nullam ullamcorper, ligula in mauris neque rhoncus sodales nec, neque lorem vitae, adipiscing eget hac suspendisse, id ullamcorper sed tempor duis elit.</p>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Table</label>
                  </div>
                  <div class="GroupRight">
                      <table border="1">
                         <tr>
                            <th>Header 1</th>
                            <th>Header 2</th>
                         </tr>
                         <tr>
                            <td>row 1, cell 1</td>
                            <td>row 1, cell 2</td>
                         </tr>
                         <tr>
                            <td>row 2, cell 1</td>
                            <td>row 2, cell 2</td>
                         </tr>
                      </table>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Unordered List</label>
                  </div>
                  <div class="GroupRight">
                     <ul>
                        <li>List Item 1</li>
                        <li>List Item 2</li>
                        <li>List Item 3</li>
                     </ul>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Ordered List</label>
                  </div>
                  <div class="GroupRight">
                     <ol>
                        <li>List Item 1</li>
                        <li>List Item 2</li>
                        <li>List Item 3</li>
                     </ol>
                   </div>
               </div>
               <div class="group_item_close"></div>

            </div>

            <hr/>

            <H1>App panel</H1>
            <hr />
            <p>This is a paragraph.</p>
            <p>This is a <a href=#>link</a> to another page.</p>
            <p>This is an <a href="http://www.cnn.com">external</a> link.</p>
            <H1>Heading 1</H1>
            <H2>Heading 2</H2>
            <H3>Heading 3</H3>
            <H4>Heading 4</H4>
            <H5>Heading 5</H5>

            <p>Est eu vitae vulputate, dui nec sed ut vel dignissim velit, pede lacus dictum id etiam eget, massa accumsan lobortis. Eget interdum magnis, justo sem tristique mauris interdum magna arcu. Integer sit justo orci in metus, elit odio mauris non amet pellentesque eu, amet pariatur.</p>


            <div class="buttonBar">
               <h1>Button Bar</h1>
               <p>The Button Bar in the Application panel is not generally used because action buttons are available in the toolbar. However, this Button Bar is available if needed.</p>
               <a href='#' class='linkButton'>Cancel</a>
               <a href='#' class='linkButton'>Update</a>
               <a href='#' class='linkButton'>Save and Return to This Form</a>
               <a href='#' class='linkButton'>You can have as many link buttons as you want</a>
               <button type="submit" form="formName" formaction="#" formmethod="post">HTML5 Button</button>
               <input type="submit" value="Submit" />
            </div>

            <div class="text">
               <h1>Text Widget</h1>
               <figure class="figureRight">
                  <img src="../../respite/media/accolade.jpg" alt="The Accolade">
                  <figcaption>The Accolade</figcaption>
               </figure>
               <p>Lorem ipsum dolor sit amet, mauris nonummy <a href=#>quisque adipiscing</a>, quis quod non interdum velit, est nonummy diam ipsum sem. Dolor sed pellentesque etiam feugiat lorem volutpat, vehicula porta semper proin congue, malesuada amet ac. Vel nam auctor cras nunc ut, fermentum vitae turpis dictum congue a quia, amet ornare nunc varius id, fringilla sed elit natoque felis mi. Sed mollis risus lorem per ornare sem. Dolor ultrices donec ut mattis nulla, felis fermentum, vitae hendrerit dignissim. Egestas sed lobortis tellus praesent mauris blandit, nibh a eu ultricies eros sed mauris, vitae velit in justo, nibh nullam, neque montes duis orci praesent et lectus. Congue aliquam egestas. Pede morbi diam dui fusce nibh. Senectus aenean amet, morbi odio rutrum nunc, scelerisque aenean sodales quam erat imperdiet, netus nec gravida amet ultricies dolore ante, eu quam aliquam nulla quam imperdiet feugiat. Tellus facilisis, et eget sit non aenean, ut est odio vestibulum proin est sagittis, in odio, libero ut. Tristique vitae, lacus gravida. Aliquam ipsum wisi lectus magna metus, risus fames fames, sed recusandae cum neque wisi vitae taciti.
               </p>
               <figure class="figureLeft">
                  <img src="../../respite/media/shallot.jpg" alt="The Lady of Shallot">
                  <figcaption>The Lady of Shallot</figcaption>
               </figure>
               <p>Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi. Nullam ullamcorper, ligula in mauris neque rhoncus sodales nec, neque lorem vitae, adipiscing eget hac suspendisse, id ullamcorper sed tempor duis elit. Est eu vitae vulputate, dui nec sed ut vel dignissim velit, pede lacus dictum id etiam eget, massa accumsan lobortis. Eget interdum magnis, justo sem tristique mauris interdum magna arcu. Integer sit justo orci in metus, elit odio mauris non amet pellentesque eu, amet pariatur. Lobortis quis vel morbi maecenas urna eros, augue laoreet ut nunc erat etiam pulvinar. Quisque nullam pulvinar, sodales volutpat urna scelerisque phasellus turpis culpa, gravida tempor lorem suspendisse, conubia vel elit ad commodo neque.
               </p>
            </div>

         
            <div class="photo">
               <h1>Photo Widget</h1>
               <figure>
                  <img src="../../respite/media/poet.jpg" alt="The Favorite Poet">
                  <figcaption>The Favorite Poet</figcaption>
               </figure>
            </div>

            <div class="canvas">
               <h1>Canvas Widget</h1>
               <canvas id="logo" width="1000" height="320">
                  <h1>Respite</h1>
                  Your browser cannot display this content because it does not support the HTML canvas tag.
               </canvas>
            </div>

            <div class="respiteGraph">
               <h1>Respite Graph Widget</h1>
               <table border="1">
                   <tr id=graph1-header data-xAxis="Superhero" data-yAxis="Strength" data-barColor="#ff0000" data-margin="30" data-barLabelPerc="30" data-legendSize="2" data-barSize="30">
                      <th>Superhero</th>
                      <th>Strength</th>
                   </tr>                   
                   <tr class="graph1-data" data-name="Superman" data-value="80">
                      <td>Superman</td>
                      <td>80</td>
                   </tr>
                   <tr class="graph1-data" data-name="Hulk" data-value="60">
                      <td>Hulk</td>
                      <td>60</td>
                   </tr>
                   <tr class="graph1-data" data-name="Batman" data-value="15">
                      <td>Batman</td>
                      <td>15</td>
                   </tr>
                   <tr class="graph1-data" data-name="Spiderman" data-value="30">
                      <td>Spiderman</td>
                      <td>30</td>
                   </tr>
                   <tr class="graph1-data" data-name="Flash" data-value="10">
                      <td>Flash</td>
                      <td>10</td>
                   </tr>
                   <tr class="graph1-data" data-name="Ironman" data-value="50">
                      <td>Ironman</td>
                      <td>50</td>
                   </tr>
                </table>
                <button id="graph1-button" type="button" onclick="respiteGraph('graph1')">Show Graph</button>
                <span id="graph1-canvas"></span>
            </div>

            <div class="respiteGraph">
               <h1>Respite Graph Widget</h1>
               <table border="1">
                   <tr id=graph2-header data-xAxis="Super Power" data-yAxis="Hit Points" data-barColor="#009900" data-margin="20" data-barLabelPerc="20" data-legendSize="1" data-barSize="15">
                      <th>Super Power</th>
                      <th>Hit Points</th>
                   </tr>
                   <tr class="graph2-data" data-name="Heat Vision" data-value="40">
                      <td>Heat Vision</td>
                      <td>40</td>
                   </tr>
                   <tr class="graph2-data" data-name="Xray Vision" data-value="0">
                      <td>Xray Vision</td>
                      <td>0</td>
                   </tr>
                   <tr class="graph2-data" data-name="The Force" data-value="30">
                      <td>The Force</td>
                      <td>30</td>
                   </tr>
                   <tr class="graph2-data" data-name="Spider Webs" data-value="50">
                      <td>Spider Webs</td>
                      <td>50</td>
                   </tr>
                   <tr class="graph2-data" data-name="Kryptonite" data-value="-15">
                      <td>Kryptonite</td>
                      <td>-15</td>
                   </tr>
                   <tr class="graph2-data" data-name="Fire Blast" data-value="75">
                      <td>Fire Blast</td>
                      <td>75</td>
                   </tr>
                   <tr class="graph2-data" data-name="Phasers" data-value="60">
                      <td>Phasers</td>
                      <td>60</td>
                   </tr>
                   <tr class="graph2-data" data-name="War Hammer" data-value="35">
                      <td>War Hammer</td>
                      <td>35</td>
                   </tr>
                   <tr class="graph2-data" data-name="Arrow" data-value="5">
                      <td>Arrow</td>
                      <td>5</td>
                   </tr>
                </table>
                <button id="graph2-button" type="button" onclick="respiteGraph('graph2')">Show Graph</button>
                <span id="graph2-canvas"></span>
            </div>

            <div class="location">
               <h1>Location Widget</h1>
               <ul>
                  <li>A: UNC Hospitals</li>
                  <li>B: Carolina Inn</li>
                  <li>Y: Your location</li>
               </ul>
               <p>
                  <img id="map" alt="Map of locations"
                     src="http://maps.google.com/maps/api/staticmap?&amp;size=500x300&amp;sensor=false&amp;maptype=roadmap&amp;markers=color:green|label:A|101+Manning+Drive,+Chapel+Hill,+NC&amp;markers=color:green|label:B|211+Pittsboro+St,+Chapel+Hill,+NC"
                  >
               </p>
            </div>

            <div class="video">
               <h1>Video Widget</h1>
               <video
                  controls="controls"
                  preload="none"
                  poster="../../respite/media/coker.jpg"
                  >
                  <source src="../../respite/media/coker.ogv" type="video/ogg">
                  <source src="../../respite/media/coker.mp4" type="video/mp4">
                  <source src="../../respite/media/coker.webm" type="video/webm">
                  Your browser does not support the video tag
               </video>
            </div>

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

            <H1>Toolbar</H1>

            <p>The Toolbar is the primary place for action buttons. I keeps actions at the top of the page for full screen views. For mobile views, it makes all actions a single click away.</p>            
            <p>The Toolbar also contains the menus for the currently active application.</p>            
            <p>The Toolbar can also contain forms that perform actions that ancillary to the primary application form.</p>    

            <div class="buttonBar">
               <h1>Button Bar</h1>
               <p>Select an action below to use the Respite demo page.</p>
               <input type="submit" name="formActionCancel" value="Cancel" onclick="respiteClean()"/>
               <input type="submit" name="formActionSave" value="Save" onclick="respiteClean()"/>
            </div>


            <div id="toolBarMenu">
               <ul>
			         <li class="toolBarMenuDivider">Applications</li>
			         <li><a href="#">Menu Item 1</a></li>
			         <li><a href="#">Menu Item 2</a></li>
			         <li><a href="#">Menu Item 3</a></li>
                  <li>
                     <ul>
                        <li><a href="#">Submenu Item 1</a></li>
                        <li><a href="#">Submenu Item 2</a></li>
                        <li><a href="#">Submenu Item 3</a></li>
                        <li><a href="#">Submenu Item 4</a></li>
                     </ul>
                  </li>
			         <li><a href="#">Menu Item 4</a></li>
			         <li><a href="#">Menu Item 5</a></li>
			         <li><a href="#">Menu Item 6</a></li>
			         <li class="toolBarMenuDivider"></li>
			         <li><a href="#">Menu Item 7</a></li>
			         <li><a href="#">Menu Item 8</a></li>
			         <li><a href="#">Menu Item 9</a></li>
			         <li class="toolBarMnuDivider"></li>
			         <li><a href="#">Menu Item 10</a></li>
			         <li><a href="#">Menu Item 11</a></li>
               </ul>
            </div>

            <p class="group_label">App Panel Form Elements</p>
            <div class="group">
               <?php printControlText('toolBarText', & $view, 'Text Label', 'Text helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlPassword('toolBarPassword', & $view, 'Password Label', 'Password helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTextArea('toolBarTextArea', & $view, 'TextArea Label', 'TextArea helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlCheckbox('toolBarCheckbox1', & $view, 'Box Label 1', 'Checkbox', 'Checkbox helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlLabelOnly('LabelOnly', 'LabelOnly helper text goes here'); ?>
               <?php printControlCheckbox('toolBarCheckbox2', & $view, 'Box Label 2', '', '', 'dirty'); ?>
               <?php printControlCheckbox('toolBarCheckbox3', & $view, 'Box Label 3', '', '', 'dirty'); ?>
               <?php printControlCheckbox('toolBarCheckbox4', & $view, 'Box Label 4', '', '', 'dirty'); ?>
               <?php printControlCheckbox('toolBarCheckbox5', & $view, 'Box Label 5', '', '', 'dirty'); ?>
               <?php printControlCheckbox('toolBarCheckbox6', & $view, 'Box Label 6', '', '', 'dirty'); ?>
               <hr />
               <?php printControlSelect('toolBarSelect', & $view, 'Select Label', 'Select helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlSelectMulti('toolBarSelectMulti', & $view, 'SelectMulti Label', 'SelectMulti helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlRadio('toolBarRadio', & $view, 'Radio Label', 'Radio helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlFile('toolBarFile', & $view, 'File Label', 'File helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlColor('toolBarColor', & $view, 'Color Label', 'Color helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDate('toolBarDate', & $view, 'Date Label', 'Date helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDatetime('toolBarDatetime', & $view, 'Datetime Label', 'Datetime helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlDatetimeLocal('toolBarDatetime-local', & $view, 'Datetime-local Label', 'Datetime-local helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlEmail('toolBarEmail', & $view, 'Email Label', 'Email helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlMonth('toolBarMonth', & $view, 'Month Label', 'Month helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlNumber('toolBarNumber', & $view, 'Number Label', 'Number helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlRange('toolBarRange', & $view, 'Range Label', 'Range helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlSearch('toolBarSearch', & $view, 'Search Label', 'Search helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTel('toolBarTel', & $view, 'Tel Label', 'Tel helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlTime('toolBarTime', & $view, 'Time Label', 'Time helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlURL('toolBarURL', & $view, 'URL Label', 'URL helper text goes here', 'dirty'); ?>
               <hr />
               <?php printControlWeek('toolBarWeek', & $view, 'Week Label', 'Week helper text goes here', 'dirty'); ?>
            </div>
            
            <p class="group_label">Group Label (Group Widget)</p>
            <div class="group">
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Note</label>
                  </div>
                  <div class="GroupRight">
                      <p class="note">Lorem ipsum dolor sit amet, <a href=#>mauris nonummy</a> quisque adipiscing, quis quod non interdum velit, est nonummy diam ipsum sem. Dolor sed pellentesque etiam feugiat lorem volutpat, vehicula porta semper proin congue, malesuada amet ac. Vel nam auctor cras nunc ut, fermentum vitae turpis dictum congue a quia, amet ornare nunc varius id, fringilla sed elit natoque felis mi. Sed mollis risus lorem per ornare sem. Dolor ultrices donec ut mattis nulla, felis fermentum, vitae hendrerit dignissim. Egestas sed lobortis tellus praesent mauris blandit, nibh a eu ultricies eros sed mauris, vitae velit in justo, nibh nullam, neque montes duis orci praesent et lectus.</p>
                      <p class="tinyNote">Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi. Nullam ullamcorper, ligula in mauris neque rhoncus sodales nec, neque lorem vitae, adipiscing eget hac suspendisse, id ullamcorper sed tempor duis elit.</p>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Table</label>
                  </div>
                  <div class="GroupRight">
                      <table border="1">
                         <tr>
                            <th>Header 1</th>
                            <th>Header 2</th>
                         </tr>
                         <tr>
                            <td>row 1, cell 1</td>
                            <td>row 1, cell 2</td>
                         </tr>
                         <tr>
                            <td>row 2, cell 1</td>
                            <td>row 2, cell 2</td>
                         </tr>
                      </table>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Unordered List</label>
                  </div>
                  <div class="GroupRight">
                     <ul>
                        <li>List Item 1</li>
                        <li>List Item 2</li>
                        <li>List Item 3</li>
                     </ul>
                   </div>
               </div>
               <div class="group_item_close"></div>

               <hr />
               <div class="group_item">
                  <div class="GroupLeft">
                     <label>Ordered List</label>
                  </div>
                  <div class="GroupRight">
                     <ol>
                        <li>List Item 1</li>
                        <li>List Item 2</li>
                        <li>List Item 3</li>
                     </ol>
                   </div>
               </div>
               <div class="group_item_close"></div>

            </div>

            <hr/>

            <H1>App panel</H1>
            <hr />
            <p>This is a paragraph.</p>
            <p>This is a <a href=#>link</a> to another page.</p>
            <p>This is an <a href="http://www.cnn.com">external</a> link.</p>
            <H1>Heading 1</H1>
            <H2>Heading 2</H2>
            <H3>Heading 3</H3>
            <H4>Heading 4</H4>
            <H5>Heading 5</H5>

            <p>Est eu vitae vulputate, dui nec sed ut vel dignissim velit, pede lacus dictum id etiam eget, massa accumsan lobortis. Eget interdum magnis, justo sem tristique mauris interdum magna arcu. Integer sit justo orci in metus, elit odio mauris non amet pellentesque eu, amet pariatur.</p>


            <div class="buttonBar">
               <h1>Button Bar</h1>
               <a href='#' class='linkButton'>Cancel</a>
               <a href='#' class='linkButton'>Update</a>
               <a href='#' class='linkButton'>Save and Return to This Form</a>
               <a href='#' class='linkButton'>You can have as many link buttons as you want</a>
               <button type="submit" form="formName" formaction="#" formmethod="post">HTML5 Button</button>
               <input type="submit" value="Submit" />
            </div>

            <div class="text">
               <h1>Text Widget</h1>
               <figure class="figureRight">
                  <img src="../../respite/media/accolade.jpg" alt="The Accolade">
                  <figcaption>The Accolade</figcaption>
               </figure>
               <p>Lorem ipsum dolor sit amet, mauris nonummy <a href=#>quisque adipiscing</a>, quis quod non interdum velit, est nonummy diam ipsum sem. Dolor sed pellentesque etiam feugiat lorem volutpat, vehicula porta semper proin congue, malesuada amet ac. Vel nam auctor cras nunc ut, fermentum vitae turpis dictum congue a quia, amet ornare nunc varius id, fringilla sed elit natoque felis mi. Sed mollis risus lorem per ornare sem. Dolor ultrices donec ut mattis nulla, felis fermentum, vitae hendrerit dignissim. Egestas sed lobortis tellus praesent mauris blandit, nibh a eu ultricies eros sed mauris, vitae velit in justo, nibh nullam, neque montes duis orci praesent et lectus. Congue aliquam egestas. Pede morbi diam dui fusce nibh. Senectus aenean amet, morbi odio rutrum nunc, scelerisque aenean sodales quam erat imperdiet, netus nec gravida amet ultricies dolore ante, eu quam aliquam nulla quam imperdiet feugiat. Tellus facilisis, et eget sit non aenean, ut est odio vestibulum proin est sagittis, in odio, libero ut. Tristique vitae, lacus gravida. Aliquam ipsum wisi lectus magna metus, risus fames fames, sed recusandae cum neque wisi vitae taciti.
               </p>
               <figure class="figureLeft">
                  <img src="../../respite/media/shallot.jpg" alt="The Lady of Shallot">
                  <figcaption>The Lady of Shallot</figcaption>
               </figure>
               <p>Dictum in placerat adipiscing, leo enim mauris, arcu ante sit, ut sed nulla wisi. Nullam ullamcorper, ligula in mauris neque rhoncus sodales nec, neque lorem vitae, adipiscing eget hac suspendisse, id ullamcorper sed tempor duis elit. Est eu vitae vulputate, dui nec sed ut vel dignissim velit, pede lacus dictum id etiam eget, massa accumsan lobortis. Eget interdum magnis, justo sem tristique mauris interdum magna arcu. Integer sit justo orci in metus, elit odio mauris non amet pellentesque eu, amet pariatur. Lobortis quis vel morbi maecenas urna eros, augue laoreet ut nunc erat etiam pulvinar. Quisque nullam pulvinar, sodales volutpat urna scelerisque phasellus turpis culpa, gravida tempor lorem suspendisse, conubia vel elit ad commodo neque.
               </p>
            </div>

         
            <div class="photo">
               <h1>Photo Widget</h1>
               <figure>
                  <img src="../../respite/media/poet.jpg" alt="The Favorite Poet">
                  <figcaption>The Favorite Poet</figcaption>
               </figure>
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

   <div id="menuBarHeader">
      <H1>Menu Bar Header!</H1>
      <hr />
      <h2>Menu H2</h2>
      <h3>Menu H3</h3>
      <h4>Menu H4</h4>
      <h5>Menu H5</h5>
      <p>Base menu p text. This is a place for menu header information.</p>
   </div>

   <div id="menu">
      <p class="menuDivider"></p>
      <ul>
         <?php
            // Insert the list of common applications displayed in the menu bar.
            require_once "../../respite/includes_view/app_menu.php";
         ?>

         <?php // The following html block demonstrates per page menu items ?>
			<li class="menuDivider">Menu Divider</li>
			<li><a href="#">Menu Item 1</a></li>
			<li><a href="#">Menu Item 2</a></li>
			<li><a href="#">Menu Item 3</a></li>
         <li>
            <ul>
               <li><a href="#">Submenu Item 1</a></li>
               <li><a href="#">Submenu Item 2</a></li>
               <li><a href="#">Submenu Item 3</a></li>
               <li><a href="#">Submenu Item 4</a></li>
            </ul>
         </li>
			<li><a href="#">Menu Item 4</a></li>
			<li><a href="#">Menu Item 5</a></li>
			<li><a href="#">Menu Item 6</a></li>
			<li class="menuDivider"></li>
			<li><a href="#">Menu Item 7</a></li>
			<li><a href="#">Menu Item 8</a></li>
			<li><a href="#">Menu Item 9</a></li>
			<li class="menuDivider"></li>
			<li><a href="#">Menu Item 10</a></li>
			<li><a href="#">Menu Item 11</a></li>
         <?php
            $authorizedRoles = array(
               'administrator'
            );
            if (isAuthorized($view['user']['roles'], $authorizedRoles)) {
               echo '<li><a href="#">Hidden Contents</a></li>';
            }
         ?>

      </ul>
      <p class="menuDivider"></p>
   </div>

   <div id="menuBarFooter">
      <h1>Footer H1</h1>
      <h2>Footer H2</h2>
      <h3>Footer H3</h3>
      <h4>Footer H4</h4>
      <h5>Footer H5</h5>
      <p>This is menu bar footer text.</p>

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
   <?php    // RespiteGraph Script ?>
   <script type="application/javascript" src="../../respite/javascripts/respiteGraph.js"></script>
   <?php    // RespiteLocation Script ?>
   <script type="application/javascript" src="../../respite/javascripts/respiteLocation.js"></script>
   <?php   // Google Maps simple API ?>
   <script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
   <?php    // RespiteLogo Script ?>
   <script type="application/javascript" src="../../respite/javascripts/respiteLogo.js"></script>



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
