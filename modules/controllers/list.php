<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$orderBy = $_GET["orderby"] ?? "name";
$order = $_GET["order"] ?? "ASC";

$query = "SELECT * FROM mp_modules WHERE 1";
$params = [];

if (!empty($search)) {
    $query .= " AND (name LIKE :search OR num_module LIKE :search)";
    $params[":search"] = "%$search%";
}

$query .= " ORDER BY $orderBy $order";

$stmt = $db->prepare($query);
$stmt->execute($params);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
