<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = [
        "num_module" => $_POST["num_module"] ?? "",
        "name" => $_POST["name"] ?? "",
        "coefficient" => $_POST["coefficient"] ?? "",
        "description" => $_POST["description"] ?? "",
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
        "SELECT COUNT(*) FROM mp_modules WHERE num_module = :num_module"
    );
    $stmt->execute([":num_module" => $data["num_module"]]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Ce numéro de module existe déjà.";
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare("INSERT INTO mp_modules (num_module, name, coefficient, description) 
                                 VALUES (:num_module, :name, :coefficient, :description)");
            if ($stmt->execute($data)) {
                echo "<script>window.location.href = '?action=list&element=modules';</script>";
                exit();
            }
        } catch (PDOException $e) {
            $errors[] =
                "Erreur lors de la création du module: " . $e->getMessage();
        }
    }
}
?>
