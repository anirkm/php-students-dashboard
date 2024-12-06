<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = [];

$coursId = $_GET["id"] ?? null;

if (!$coursId) {
    echo "<script>window.location.href = '?action=list&element=cours';</script>";
    exit();
}

$stmt = $db->prepare("
    SELECT c.*, 
           m.name as matiere_name,
           CONCAT(e.firstname, ' ', e.lastname) as enseignant_name
    FROM mp_cours c
    LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE c.rowid = :id
");
$stmt->execute([":id" => $coursId]);
$cours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cours) {
    echo "<script>window.location.href = '?action=list&element=cours';</script>";
    exit();
}

$query = "SELECT e.* FROM mp_etudiants e WHERE 1";
$params = [];

if ($cours["type_cours"] == "TD" && !empty($cours["groupe_td"])) {
    $query .= " AND e.td = :groupe";
    $params[":groupe"] = $cours["groupe_td"];
} elseif ($cours["type_cours"] == "TP" && !empty($cours["groupe_tp"])) {
    $query .= " AND e.tp = :groupe";
    $params[":groupe"] = $cours["groupe_tp"];
}

$query .= " ORDER BY e.lastname, e.firstname";
$stmt = $db->prepare($query);
$stmt->execute($params);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
    SELECT p.*, 
           CONCAT(e.firstname, ' ', e.lastname) as etudiant_name
    FROM mp_presences p
    JOIN mp_etudiants e ON p.fk_etudiant = e.rowid
    WHERE p.fk_cours = :cours_id
");
$stmt->execute([":cours_id" => $coursId]);
$presences = $stmt->fetchAll(PDO::FETCH_ASSOC);
$presences_by_student = array_column($presences, null, "fk_etudiant");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $db->beginTransaction();

        $stmt = $db->prepare(
            "DELETE FROM mp_presences WHERE fk_cours = :cours_id"
        );
        $stmt->execute([":cours_id" => $coursId]);

        $stmt = $db->prepare("
            INSERT INTO mp_presences (fk_cours, fk_etudiant, status, commentaire) 
            VALUES (:fk_cours, :fk_etudiant, :status, :commentaire)
        ");

        foreach ($_POST["presence"] as $etudiantId => $data) {
            $status = $data["status"] ?? "absent";
            $commentaire = $data["commentaire"] ?? "";

            $stmt->execute([
                ":fk_cours" => $coursId,
                ":fk_etudiant" => $etudiantId,
                ":status" => $status,
                ":commentaire" => $commentaire,
            ]);
        }

        $db->commit();
        $success[] = "Les présences ont été enregistrées avec succès.";

        $stmt = $db->prepare("
            SELECT p.*, 
                   CONCAT(e.firstname, ' ', e.lastname) as etudiant_name
            FROM mp_presences p
            JOIN mp_etudiants e ON p.fk_etudiant = e.rowid
            WHERE p.fk_cours = :cours_id
        ");
        $stmt->execute([":cours_id" => $coursId]);
        $presences = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $presences_by_student = array_column($presences, null, "fk_etudiant");
    } catch (Exception $e) {
        $db->rollBack();
        $errors[] =
            "Erreur lors de l'enregistrement des présences: " .
            $e->getMessage();
    }
}
?>
