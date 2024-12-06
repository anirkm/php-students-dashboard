<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];

$matieres = $db
    ->query("SELECT rowid, name FROM mp_matieres ORDER BY name")
    ->fetchAll();
$enseignants = $db
    ->query(
        "SELECT rowid, firstname, lastname FROM mp_enseignants ORDER BY lastname"
    )
    ->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "date_cours" => $_POST["date"] . " " . $_POST["heure"],
        "duration" => $_POST["duration"] ?? "",
        "fk_matiere" => $_POST["fk_matiere"] ?? "",
        "fk_enseignant" => $_POST["fk_enseignant"] ?? "",
        "type_cours" => $_POST["type_cours"] ?? "",
        "groupe_td" => $_POST["groupe_td"] ?? "",
        "groupe_tp" => $_POST["groupe_tp"] ?? "",
        "salle" => $_POST["salle"] ?? "",
        "status" => "planifié",
    ];

    if (empty($data["date_cours"])) {
        $errors[] = "La date et l'heure sont requises.";
    }
    if (!is_numeric($data["duration"]) || $data["duration"] <= 0) {
        $errors[] = "La durée doit être un nombre positif.";
    }
    if (empty($data["fk_matiere"])) {
        $errors[] = "La matière est requise.";
    }
    if (empty($data["fk_enseignant"])) {
        $errors[] = "L'enseignant est requis.";
    }
    if (empty($data["type_cours"])) {
        $errors[] = "Le type de cours est requis.";
    }
    if (empty($data["salle"])) {
        $errors[] = "La salle est requise.";
    }

    $stmt = $db->prepare("
        SELECT COUNT(*) FROM mp_cours 
        WHERE salle = :salle 
        AND date_cours < DATE_ADD(:date_cours, INTERVAL :duration MINUTE)
        AND DATE_ADD(date_cours, INTERVAL duration MINUTE) > :date_cours
        AND status != 'annulé'
    ");
    $stmt->execute([
        ":salle" => $data["salle"],
        ":date_cours" => $data["date_cours"],
        ":duration" => $data["duration"],
    ]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "La salle est déjà occupée sur ce créneau.";
    }

    $stmt = $db->prepare("
        SELECT COUNT(*) FROM mp_cours 
        WHERE fk_enseignant = :fk_enseignant 
        AND date_cours < DATE_ADD(:date_cours, INTERVAL :duration MINUTE)
        AND DATE_ADD(date_cours, INTERVAL duration MINUTE) > :date_cours
        AND status != 'annulé'
    ");
    $stmt->execute([
        ":fk_enseignant" => $data["fk_enseignant"],
        ":date_cours" => $data["date_cours"],
        ":duration" => $data["duration"],
    ]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "L'enseignant est déjà occupé sur ce créneau.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("
                INSERT INTO mp_cours (date_cours, duration, fk_matiere, fk_enseignant, 
                                    type_cours, groupe_td, groupe_tp, salle, status) 
                VALUES (:date_cours, :duration, :fk_matiere, :fk_enseignant, 
                        :type_cours, :groupe_td, :groupe_tp, :salle, :status)
            ");
            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=cours';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la création du cours: " . $e->getMessage();
        }
    }
}
