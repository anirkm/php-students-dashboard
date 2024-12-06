<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$filters = [
    "date_debut" => $_GET["date_debut"] ?? date("Y-m-d"),
    "date_fin" => $_GET["date_fin"] ?? date("Y-m-d", strtotime("+30 days")),
    "matiere_id" => $_GET["matiere_id"] ?? "",
    "enseignant_id" => $_GET["enseignant_id"] ?? "",
    "type_cours" => $_GET["type_cours"] ?? "",
];

$query = "SELECT c.*, m.name as matiere_name, 
          CONCAT(e.firstname, ' ', e.lastname) as enseignant_name
          FROM mp_cours c
          LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
          LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
          WHERE date_cours BETWEEN :date_debut AND :date_fin";
$params = [
    ":date_debut" => $filters["date_debut"] . " 00:00:00",
    ":date_fin" => $filters["date_fin"] . " 23:59:59",
];

if (!empty($filters["matiere_id"])) {
    $query .= " AND c.fk_matiere = :matiere_id";
    $params[":matiere_id"] = $filters["matiere_id"];
}

if (!empty($filters["enseignant_id"])) {
    $query .= " AND c.fk_enseignant = :enseignant_id";
    $params[":enseignant_id"] = $filters["enseignant_id"];
}

if (!empty($filters["type_cours"])) {
    $query .= " AND c.type_cours = :type_cours";
    $params[":type_cours"] = $filters["type_cours"];
}

$query .= " ORDER BY date_cours ASC";

$matieres = $db
    ->query("SELECT rowid, name FROM mp_matieres ORDER BY name")
    ->fetchAll();
$enseignants = $db
    ->query(
        "SELECT rowid, firstname, lastname FROM mp_enseignants ORDER BY lastname"
    )
    ->fetchAll();

$stmt = $db->prepare($query);
$stmt->execute($params);
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
