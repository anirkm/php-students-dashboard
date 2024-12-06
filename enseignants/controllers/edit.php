<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/enseignant.class.php";

$errors = [];
$success = false;

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: ?action=list&element=enseignants");
    exit();
}

$enseignant = new Enseignant($db);

if (!$enseignant->fetch($id)) {
    header("Location: ?action=list&element=enseignants");
    exit();
}

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

    foreach ($data as $key => $value) {
        if (empty($value)) {
            $errors[] = "Le champ " . ucfirst($key) . " est requis.";
        }
    }

    if (!preg_match('/^\d{5}$/', $data["zipcode"])) {
        $errors[] = "Le code postal doit contenir 5 chiffres.";
    }

    if (empty($errors)) {
        $enseignant->setData($data);

        if ($enseignant->update()) {
            echo "<script>window.location.href = '?action=list&element=enseignants';</script>";
            $success = true;
            exit();
        } else {
            $errors[] = "Erreur lors de la mise à jour de l'enseignant.";
        }
    }
}
?>
