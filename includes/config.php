<?php

$config = array(
  'title' => 'Just a Journal',
  'facebook_url' => 'https://www.facebook.com/katherine.zhdanova.75/',
  'instagram_url' => 'https://www.instagram.com/margery_fox/',
  'youtube_url' => 'https://www.youtube.com/channel/UCJXaZwZvQ7mykz0T_Pvizmw',
  'db' => array(
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'name' => 'blog_db'
  )
);
error_reporting(E_ALL);

ini_set("display_errors", 1);

require "db.php";