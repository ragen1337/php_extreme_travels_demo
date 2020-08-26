<?php
require_once "constants.inc.php";
require_once "functions.inc.php";

echo content_drawing(DB_INFO, DB_LOGIN, DB_PWD, 'content', 'html_id', 'headerInfo', 'content');
