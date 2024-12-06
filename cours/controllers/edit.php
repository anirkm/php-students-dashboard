<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];

$coursId = $_GET["id"] ?? null;

if (!$coursId) {
    header("Location: ?action=list&element=cours");
    exit();
}

$stmt = $db->prepare("SELECT * FROM mp_cours WHERE rowid = :id");
$stmt->execute([":id" => $coursId]);
$cours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cours) {
    header("Location: ?action=list&element=cours");
    exit();
}

$matieres = $db
    ->query("SELECT rowid, name FROM mp_matieres ORDER BY name")
    ->fetchAll();
$enseignants = $db
    ->query(
        "SELECT rowid, firstname, lastname FROM mp_enseignants ORDER BY lastname"
    )
    ->fetchAll();

if (isset($_POST["delete"])) {
    $stmt = $db->prepare("DELETE FROM mp_cours WHERE rowid = :id");
    if ($stmt->execute([":id" => $coursId])) {
        header("Location: ?action=list&element=cours");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST["delete"])) {
    $data = [
        "date_cours" => $_POST["date"] . " " . $_POST["heure"],
        "duration" => $_POST["duration"] ?? "",
        "fk_matiere" => $_POST["fk_matiere"] ?? "",
        "fk_enseignant" => $_POST["fk_enseignant"] ?? "",
        "type_cours" => $_POST["type_cours"] ?? "",
        "groupe_td" => $_POST["groupe_td"] ?? "",
        "groupe_tp" => $_POST["groupe_tp"] ?? "",
        "salle" => $_POST["salle"] ?? "",
        "status" => $_POST["status"] ?? "planifié",
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

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("
                UPDATE mp_cours SET 
                    date_cours = :date_cours,
                    duration = :duration,
                    fk_matiere = :fk_matiere,
                    fk_enseignant = :fk_enseignant,
                    type_cours = :type_cours,
                    groupe_td = :groupe_td,
                    groupe_tp = :groupe_tp,
                    salle = :salle,
                    status = :status
                WHERE rowid = :id
            ");

            $data[":id"] = $coursId;

            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=cours';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la modification du cours: " . $e->getMessage();
        }
    }
}
?>
