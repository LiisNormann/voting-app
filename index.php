<?php
require_once('conf.php');

/* @var \core\DB\MySQL $DB */
global $DB;

$header = file_get_contents("templates/header.template.html");
$index = file_get_contents("templates/index.template.html");
$index = str_replace('{{$header}}', $header, $index);

$res = $DB->query("
    SELECT id, eesnimi, perenimi
    FROM haaletajad
");

$people = '';
foreach ($res as $v) {
    $people .= sprintf("<option value='%s'>%s %s</option>", $v['id'], $v['eesnimi'], $v['perenimi']);
}
$index = str_replace('{{$people}}', $people, $index);

echo $index;
