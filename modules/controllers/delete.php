<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = false;

$module_id = $_GET["id"] ?? null;
if (!$module_id) {
    echo "<script>window.location.href = '?action=list&element=modules';</script>";
    exit();
}

$stmt = $db->prepare("SELECT * FROM mp_modules WHERE rowid = :id");
$stmt->execute([":id" => $module_id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    echo "<script>window.location.href = '?action=list&element=modules';</script>";
    exit();
}

$stmt = $db->prepare(
    "SELECT COUNT(*) FROM mp_matieres WHERE fk_module = :module_id"
);
$stmt->execute([":module_id" => $module_id]);
if ($stmt->fetchColumn() > 0) {
    $errors[] =
        "Impossible de supprimer ce module car il contient des matières.";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && empty($errors)) {
    try {
        $stmt = $db->prepare("DELETE FROM mp_modules WHERE rowid = :id");
        if ($stmt->execute([":id" => $module_id])) {
            $success = true;
            echo "<script>window.location.href = '?action=list&element=modules';</script>";
            exit();
        }
    } catch (PDOException $e) {
        $errors[] =
            "Erreur lors de la suppression du module: " . $e->getMessage();
    }
}
?>
