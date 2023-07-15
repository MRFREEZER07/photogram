<?php

include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/User.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/Database.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/Session.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/UserSession.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/WebAPI.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/API.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/includes/WebAPI.class.php");
include_once($_SERVER['DOCUMENT_ROOT']."/libs/app/Post.class.php");

require 'vendor/autoload.php';


$wapi = new WebAPI();
$wapi->inititateSession();


function get_config($key,$default=null)
{
    $config_json = file_get_contents('/var/www/html/demo/project/env.json');
    $config = json_decode($config_json, true);
    return $config[$key];
}