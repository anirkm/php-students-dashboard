<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = false;

$matiere_id = $_GET["id"] ?? null;
if (!$matiere_id) {
    header("Location: ?action=list&element=matieres");
    exit();
}

$stmt = $db->prepare("SELECT m.*, mo.name as module_name 
                      FROM mp_matieres m 
                      LEFT JOIN mp_modules mo ON m.fk_module = mo.rowid 
                      WHERE m.rowid = :id");
$stmt->execute([":id" => $matiere_id]);
$matiere = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matiere) {
    echo "<script>window.location.href = '?action=list&element=matieres';</script>";
    exit();
}

$stmt = $db->prepare(
    "SELECT COUNT(*) FROM mp_cours WHERE fk_matiere = :matiere_id"
);
$stmt->execute([":matiere_id" => $matiere_id]);
if ($stmt->fetchColumn() > 0) {
    $errors[] =
        "Impossible de supprimer cette matière car elle a des cours associés.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errors)) {
    try {
        $stmt = $db->prepare("DELETE FROM mp_matieres WHERE rowid = :id");
        if ($stmt->execute([":id" => $matiere_id])) {
            $success = true;
            echo "<script>window.location.href = '?action=list&element=matieres';</script>";
            exit();
        }
    } catch (PDOException $e) {
        $errors[] =
            "Erreur lors de la suppression de la matière: " . $e->getMessage();
    }
}
?>
