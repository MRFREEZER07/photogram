<?php

include "libs/load.php";


$user =User::getDetails('naruto');
$sess =Session::getAllUserDetails();
$post =Post::getAllPosts();
print_r($sess['email']);