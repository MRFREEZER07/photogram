<?php

require_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/User.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/Database.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/Session.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/UserSession.class.php");
require_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/WebAPI.class.php");



$wapi = new WebAPI();
$wapi->inititateSession();


