<?php
   // This page simply displays an "Access Denied" message.
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
      <a href="#menuBarDivider"> <img src="../../respite/css/images/icon_menu.png" alt="menu icon" id="icon_menu"></a>
      <p id="titleBarText">Unauthorized</p>
      <a href="#appPanelOuterDivider"> <img src="../../respite/css/images/icon_home.png" alt="home icon" id="icon_home"></a>
      <a href="#toolBarOuterDivider"> <img src="../../respite/css/images/icon_tools.png" alt="tools icon" id="icon_tools"></a>
   </div>

<?php
// ****************************************************************************************************
// * App Panel
// ****************************************************************************************************
?>
   <div id="appPanelOuter">
      <div class="divider" id="appPanelOuterDivider">
      </div>
      <div id="appPanel">
         <h1>Access Denied</h1>
         <p>You are not authorized to view this resource.</p>
      </div>
   </div>

<?php
// ****************************************************************************************************
// * Tool Bar
// ****************************************************************************************************
?>
   <div id="toolBarOuter">
      <div class="divider" id="toolBarOuterDivider">
      </div>
      <div id="toolBar">
         <p>No actions available.</p> 
      </div>
   </div>

</form>

<?php
// ****************************************************************************************************
// * Menu Bar
// ****************************************************************************************************
?>
<div id="menuBar">
   <div class="divider" id="menuBarDivider">
   </div>
   <div id="menu">
      <p class="menuDivider">No actions available</p>
   </div>
</div>

<?php
// ****************************************************************************************************
// * Scripts
// ****************************************************************************************************
   require_once "../../respite/includes_view/scripts.php";
?>

<?php // Scripts unique to this page ?>

<?php
// ****************************************************************************************************
// * Footer
// ****************************************************************************************************
   require_once "../../respite/includes_view/footer.php";
?>
