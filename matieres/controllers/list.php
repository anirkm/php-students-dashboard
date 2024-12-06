<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$module_id = $_GET["module_id"] ?? "";
$orderBy = $_GET["orderby"] ?? "name";
$order = $_GET["order"] ?? "ASC";

$query = "SELECT m.*, mo.name as module_name 
          FROM mp_matieres m 
          LEFT JOIN mp_modules mo ON m.fk_module = mo.rowid 
          WHERE 1";
$params = [];

if (!empty($search)) {
    $query .= " AND (m.name LIKE :search OR m.num_matiere LIKE :search)";
    $params[":search"] = "%$search%";
}

if (!empty($module_id)) {
    $query .= " AND m.fk_module = :module_id";
    $params[":module_id"] = $module_id;
}

$query .= " ORDER BY m.$orderBy $order";

$modules = $db
    ->query("SELECT rowid, name FROM mp_modules ORDER BY name")
    ->fetchAll();

$stmt = $db->prepare($query);
$stmt->execute($params);
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
