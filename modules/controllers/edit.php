<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];

$module_id = $_GET["id"] ?? null;
if (!$module_id) {
    header("Location: ?action=list&element=modules");
    exit();
}

$stmt = $db->prepare("SELECT * FROM mp_modules WHERE rowid = :id");
$stmt->execute([":id" => $module_id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    header("Location: ?action=list&element=modules");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "num_module" => $_POST["num_module"] ?? "",
        "name" => $_POST["name"] ?? "",
        "coefficient" => $_POST["coefficient"] ?? "",
        "description" => $_POST["description"] ?? "",
        "rowid" => $module_id,
    ];

    if (empty($data["num_module"])) {
        $errors[] = "Le numéro de module est requis.";
    }
    if (empty($data["name"])) {
        $errors[] = "Le nom est requis.";
    }
    if (!is_numeric($data["coefficient"])) {
        $errors[] = "Le coefficient doit être un nombre.";
    }

    $stmt = $db->prepare(
        "SELECT COUNT(*) FROM mp_modules WHERE num_module = :num_module AND rowid != :rowid"
    );
    $stmt->execute([
        ":num_module" => $data["num_module"],
        ":rowid" => $module_id,
    ]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Ce numéro de module existe déjà.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE mp_modules SET num_module = :num_module, name = :name, 
                                 coefficient = :coefficient, description = :description 
                                 WHERE rowid = :rowid");
            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=modules';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la modification du module: " . $e->getMessage();
        }
    }
} else {
    $_POST = $module;
}
?>
