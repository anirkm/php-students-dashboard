<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];

$matiere_id = $_GET["id"] ?? null;
if (!$matiere_id) {
    header("Location: ?action=list&element=matieres");
    exit();
}

$modules = $db
    ->query("SELECT rowid, name FROM mp_modules ORDER BY name")
    ->fetchAll();

$stmt = $db->prepare("SELECT * FROM mp_matieres WHERE rowid = :id");
$stmt->execute([":id" => $matiere_id]);
$matiere = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matiere) {
    header("Location: ?action=list&element=matieres");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "num_matiere" => $_POST["num_matiere"] ?? "",
        "name" => $_POST["name"] ?? "",
        "coefficient" => $_POST["coefficient"] ?? "",
        "fk_module" => $_POST["fk_module"] ?? "",
        "description" => $_POST["description"] ?? "",
        "rowid" => $matiere_id,
    ];

    if (empty($data["num_matiere"])) {
        $errors[] = "Le numéro de matière est requis.";
    }
    if (empty($data["name"])) {
        $errors[] = "Le nom est requis.";
    }
    if (!is_numeric($data["coefficient"])) {
        $errors[] = "Le coefficient doit être un nombre.";
    }
    if (empty($data["fk_module"])) {
        $errors[] = "Le module est requis.";
    }

    $stmt = $db->prepare(
        "SELECT COUNT(*) FROM mp_matieres WHERE num_matiere = :num_matiere AND rowid != :rowid"
    );
    $stmt->execute([
        ":num_matiere" => $data["num_matiere"],
        ":rowid" => $matiere_id,
    ]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Ce numéro de matière existe déjà.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("UPDATE mp_matieres SET 
                num_matiere = :num_matiere, 
                name = :name, 
                coefficient = :coefficient, 
                fk_module = :fk_module, 
                description = :description 
                WHERE rowid = :rowid");
            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=matieres';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la modification de la matière: " .
                $e->getMessage();
        }
    }
} else {
    $_POST = $matiere;
}
?>
