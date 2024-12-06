<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

require_once dirname(__FILE__, 3) . "/class/etudiant.class.php";

$search = trim($_GET["search"] ?? "");

$etudiants = [];

if ($search !== "") {
    $etudiantsData = Etudiant::search($db, $search);
} else {
    $etudiantsData = Etudiant::fetchAll($db);
}

if ($etudiantsData) {
    foreach ($etudiantsData as $etudiantData) {
        $etudiant = new Etudiant($db);
        $etudiant->setData($etudiantData);
        $etudiants[] = $etudiant;
    }
}

?>
