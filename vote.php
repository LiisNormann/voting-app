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

        $form = str_replace('{{$person}}', $DATA["data"]["id"], $form);

        $response["success"] = true;
        $response["data"]["form"] = $form;
        $response["data"]["name"] = $res["eesnimi"] . " " . $res["perenimi"];
        break;
    case "vote":
        $item = ["otsus"=>"'{$DATA["data"]["vote"]}'"];
        if($DB->query("SELECT 1 FROM haaletajad WHERE id = {$DATA["data"]["id"]} AND algusaeg IS NULL"))
            $item["algusaeg"] = date("'Y-m-d H:i'");

        $DB->update("haaletajad", $item, "id = {$DATA["data"]["id"]}");

        $response["success"] = true;
        //$response["data"]["message"] = "ma ei tea mis juhtus, ainult jumal teab";
        $DB->commit();
        break;
    case "results":
        $form = file_get_contents("templates/results.template.html");
        $data = $DB->query("
            SELECT poolt_haaled AS Poolt, vastu_haaled as Vastu FROM tulemused WHERE id = 1
        ")[0];




        $response["success"] = true;
        $response["data"]["form"] = $form;
        $response["data"]["data"] = $data;
        break;
    default:
        $response["success"] = false;
        $response["data"]["message"] = "ma ei tea mis juhtus, ainult jumal teab";
        break;
}

echo json_encode($response);
