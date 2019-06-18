<?php
session_start();
session_destroy();
$redirect = "https://" . $_SERVER['HTTP_HOST'] . "/Shibboleth.sso/Logout";
header("Location: $redirect");
?>
