<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$coursId = $_GET["id"] ?? null;

if (!$coursId) {
    header("Location: ?action=list&element=cours");
    exit();
}

$stmt = $db->prepare("
    SELECT c.*, 
           m.name as matiere_name,
           CONCAT(COALESCE(e.firstname, ''), ' ', COALESCE(e.lastname, '')) as enseignant_name,
           m.description as matiere_description
    FROM mp_cours c
    LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE c.rowid = :id
");
$stmt->execute([":id" => $coursId]);
$cours = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cours) {
    header("Location: ?action=list&element=cours");
    exit();
}

$stmt = $db->prepare("
    SELECT 
        p.*, 
        CASE 
            WHEN et.rowid IS NULL THEN '[Étudiant supprimé]'
            ELSE CONCAT(et.firstname, ' ', et.lastname)
        END as etudiant_name
    FROM mp_presences p
    LEFT JOIN mp_etudiants et ON p.fk_etudiant = et.rowid
    WHERE p.fk_cours = :cours_id
");
$stmt->execute([":cours_id" => $coursId]);
$presences = $stmt->fetchAll(PDO::FETCH_ASSOC);

$cours = array_map(function ($value) {
    return $value ?? "";
}, $cours);

$presences = array_map(function ($presence) {
    return array_map(function ($value) {
        return $value ?? "";
    }, $presence);
}, $presences);
?>
