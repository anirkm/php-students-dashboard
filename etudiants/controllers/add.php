<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/etudiant.class.php";

$errors = [];
$success = false;

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

    if (empty($_POST["username"])) {
        $errors[] = "Le nom d'utilisateur est requis.";
    }
    if (empty($_POST["password"])) {
        $errors[] = "Le mot de passe est requis.";
    }

    if (empty($errors)) {
        $etudiant = new Etudiant($db);
        $etudiant->setData($data);

        $userData = [
            "username" => $_POST["username"],
            "password" => $_POST["password"],
            "firstname" => $data["firstname"],
            "lastname" => $data["lastname"],
        ];

        if ($etudiant->create($userData)) {
            echo "<script>window.location.href = '?action=list&element=etudiants';</script>";
            $success = true;
            exit();
        } else {
            $errors[] = "Erreur lors de la création de l'étudiant.";
        }
    }
}
