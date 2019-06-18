<?php

function getURL($respiteURL) {
// Determines current page URL and navigation anchors
   $respiteURL['protocol'] = (isset($_SERVER['HTTPS']) ? 'https': 'http');
   $respiteURL['host']     = $_SERVER['HTTP_HOST'];
   $respiteURL['script']   = $_SERVER['SCRIPT_NAME'];
   $respiteURL['params']   = $_SERVER['QUERY_STRING'];
   $respiteURL['currentURL'] = $respiteURL['protocol'] . '://' . $respiteURL['host'] . $respiteURL['script'];
   $respiteURL['currentURLParams'] = $respiteURL['protocol'] . '://' . $respiteURL['host'] . $respiteURL['script'] . '?' . $respiteURL['params'];
   $respiteURL['menuBarAnchor'] = $respiteURL['currentURL'] . '#menuBarDivider';
   $respiteURL['appPanelAnchor'] = $respiteURL['currentURL'] . '#appPanelOuterDivider';
   $respiteURL['toolBarAnchor'] = $respiteURL['currentURL'] . '#toolBarOuterDivider';

   return $respiteURL;
}
?>
