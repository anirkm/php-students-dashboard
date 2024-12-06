<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/etudiant.class.php";

$errors = [];
$success = false;

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: ?action=list&element=etudiants");
    exit();
}

$etudiant = new Etudiant($db);

if (!$etudiant->fetch($id)) {
    header("Location: ?action=list&element=etudiants");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($etudiant->delete()) {
        echo "<script>window.location.href = '?action=list&element=etudiants';</script>";
        exit();
    } else {
        $errors[] = "Erreur lors de la suppression de l'étudiant.";
    }
}
