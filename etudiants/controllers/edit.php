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
    $data = [
        "numetu" => $_POST["numetu"] ?? "",
        "firstname" => $_POST["firstname"] ?? "",
        "lastname" => $_POST["lastname"] ?? "",
        "birthday" => $_POST["birthday"] ?? "",
        "diploma" => $_POST["diploma"] ?? "",
        "year" => $_POST["year"] ?? "",
        "td" => $_POST["td"] ?? "",
        "tp" => $_POST["tp"] ?? "",
        "address" => $_POST["address"] ?? "",
        "zipcode" => $_POST["zipcode"] ?? "",
        "town" => $_POST["town"] ?? "",
    ];

    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[] = "Le champ " . ucfirst($key) . " est requis.";
        }
    }

    if (empty($errors)) {
        $etudiant->setData($data);

        if ($etudiant->update()) {
            echo "<script>window.location.href = '?action=list&element=etudiants';</script>";
            $success = true;
            exit();
        } else {
            $errors[] = "Erreur lors de la mise à jour de l'étudiant.";
        }
    }
}
