<?php

$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/enseignant.class.php";

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_GET["id"] ?? null;

    if ($id) {
        $enseignant = new Enseignant($db);
        if ($enseignant->fetch($id)) {
            if ($enseignant->delete()) {
                echo "<script>window.location.href = '?action=list&element=enseignants';</script>";
                exit();
            } else {
                $errors[] = "Erreur lors de la suppression de l'enseignant.";
            }
        } else {
            $errors[] = "Enseignant non trouvé.";
        }
    } else {
        $errors[] = "ID de l'enseignant non fourni.";
    }
} else {
    $id = $_GET["id"] ?? null;

    if ($id) {
        $enseignant = new Enseignant($db);
        if (!$enseignant->fetch($id)) {
            echo "<script>window.location.href = '?action=list&element=enseignants';</script>";
            exit();
        }
    } else {
        echo "<script>window.location.href = '?action=list&element=enseignants';</script>";
        exit();
    }
}
