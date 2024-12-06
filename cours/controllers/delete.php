<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = false;

$coursId = $_GET["id"] ?? null;

if (!$coursId) {
    header("Location: ?action=list&element=cours");
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $db->beginTransaction();

        $stmt = $db->prepare(
            "DELETE FROM mp_presences WHERE fk_cours = :cours_id"
        );
        $stmt->execute([":cours_id" => $coursId]);

        $stmt = $db->prepare("DELETE FROM mp_cours WHERE rowid = :id");
        $stmt->execute([":id" => $coursId]);

        $db->commit();
        $success = true;
    } catch (PDOException $e) {
        $db->rollBack();
        $errors[] =
            "Erreur lors de la suppression du cours : " . $e->getMessage();
    }
}
?>
