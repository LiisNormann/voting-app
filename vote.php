<?php
require_once('conf.php');

/* @var \core\DB\MySQL $DB */
global $DB;

$DATA = json_decode(file_get_contents("php://input"), true);
if(!$DATA)
    echo '{}';

$response = [];
switch ($DATA["action"]) {
    case "select-person":
        $form = file_get_contents("templates/poll.template.html");
        $res = $DB->query("SELECT eesnimi, perenimi FROM haaletajad WHERE id = {$DATA["data"]["id"]}")[0];

        $response["success"] = true;
        $response["data"]["form"] = $form;
        $response["data"]["name"] = $res["eesnimi"] . " " . $res["perenimi"];
        break;
    default:
        $response["success"] = false;
        $response["data"]["message"] = "ma ei tea mis juhtus, ainult jumal teab";
        break;
}

echo json_encode($response);
