<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];

$modules = $db
    ->query("SELECT rowid, name FROM mp_modules ORDER BY name")
    ->fetchAll();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "num_matiere" => $_POST["num_matiere"] ?? "",
        "name" => $_POST["name"] ?? "",
        "coefficient" => $_POST["coefficient"] ?? "",
        "fk_module" => $_POST["fk_module"] ?? "",
        "description" => $_POST["description"] ?? "",
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
        "SELECT COUNT(*) FROM mp_matieres WHERE num_matiere = :num_matiere"
    );
    $stmt->execute([":num_matiere" => $data["num_matiere"]]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Ce numéro de matière existe déjà.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO mp_matieres (num_matiere, name, coefficient, fk_module, description) 
                                 VALUES (:num_matiere, :name, :coefficient, :fk_module, :description)");
            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=matieres';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la création de la matière: " . $e->getMessage();
        }
    }
}
?>
