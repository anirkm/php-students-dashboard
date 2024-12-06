<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/enseignant.class.php";

$search = trim($_GET["search"] ?? "");

$enseignants = [];

if ($search !== "") {
    $enseignantsData = Enseignant::search($db, $search);
} else {
    $enseignantsData = Enseignant::fetchAll($db);
}

if ($enseignantsData) {
    foreach ($enseignantsData as $enseignantData) {
        $enseignant = new Enseignant($db);
        $enseignant->setData($enseignantData);
        $enseignants[] = $enseignant;
    }
}

?>
