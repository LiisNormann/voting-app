<?php
require_once('conf.php');

/* @var \core\DB\MySQL $DB */
global $DB;

$header = file_get_contents("templates/header.template.html");
$index = file_get_contents("templates/index.template.html");
$index = str_replace('{{$header}}', $header, $index);

echo $index;
