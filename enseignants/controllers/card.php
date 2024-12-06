<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/enseignant.class.php";
require_once dirname(__FILE__, 3) . "/class/cours.class.php";
require_once dirname(__FILE__, 3) . "/class/matiere.class.php";
require_once dirname(__FILE__, 3) . "/class/module.class.php";

$errors = [];
$success = false;

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $enseignant = new Enseignant($db);

    if ($enseignant->fetch($id)) {
        $stmt = $db->prepare("
            SELECT DISTINCT 
                c.rowid as cours_id,
                c.date_cours,
                c.type_cours,
                c.groupe_td,
                c.groupe_tp,
                c.salle,
                m.rowid as matiere_id,
                m.name as matiere_name,
                m.coefficient as matiere_coef,
                modules.rowid as module_id,
                modules.name as module_name,
                modules.coefficient as module_coef
            FROM mp_cours c
            JOIN mp_matieres m ON c.fk_matiere = m.rowid
            JOIN mp_modules modules ON m.fk_module = modules.rowid
            WHERE c.fk_enseignant = :enseignant_id
            ORDER BY modules.name, m.name, c.date_cours DESC
        ");
        $stmt->execute([":enseignant_id" => $id]);
        $teaching_info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include "views/card.php";
    } else {
        $errors[] = "Enseignant non trouvé.";
    }
} else {
    $errors[] = "ID de l'enseignant non spécifié.";
}
?>
