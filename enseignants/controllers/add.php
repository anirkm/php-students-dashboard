<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/enseignant.class.php";

$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "numens" => $_POST["numens"] ?? "",
        "firstname" => $_POST["firstname"] ?? "",
        "lastname" => $_POST["lastname"] ?? "",
        "birthday" => $_POST["birthday"] ?? "",
        "address" => $_POST["address"] ?? "",
        "zipcode" => $_POST["zipcode"] ?? "",
        "town" => $_POST["town"] ?? "",
    ];

    $userData = [
        "username" => $_POST["username"] ?? "",
        "password" => $_POST["password"] ?? "",
    ];

    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[] = "Le champ " . ucfirst($key) . " est requis.";
        }
    }

    if (empty($userData["username"])) {
        $errors[] = "Le champ Username est requis.";
    }
    if (empty($userData["password"])) {
        $errors[] = "Le champ Password est requis.";
    }

    if (!preg_match('/^\d{5}$/', $data["zipcode"])) {
        $errors[] = "Le code postal doit contenir 5 chiffres.";
    }

    if (empty($errors)) {
        $enseignant = new Enseignant($db, $data);

        if ($enseignant->create($userData)) {
            $success = true;
            echo "<script>window.location.href = '?action=list&element=enseignants';</script>";
            exit();
        } else {
            $errors[] = "Erreur lors de la création de l'enseignant.";
        }
    }
}
?>
