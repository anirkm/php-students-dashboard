<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$page = max(1, $_GET["page"] ?? 1);
$perPage = 10;

$stats = [];

$stmt = $db->query("SELECT COUNT(*) FROM mp_modules");
$stats["total_modules"] = $stmt->fetchColumn();

$stmt = $db->query("SELECT COUNT(DISTINCT rowid) FROM mp_matieres");
$stats["total_matieres"] = $stmt->fetchColumn();

$stmt = $db->query("SELECT AVG(coefficient) FROM mp_modules");
$stats["coefficient_moyen"] = round($stmt->fetchColumn(), 2);

$query = "
    SELECT 
        m.*,
        COUNT(DISTINCT mat.rowid) as nb_matieres,
        SUM(mat.coefficient) as sum_coefficients
    FROM mp_modules m
    LEFT JOIN mp_matieres mat ON mat.fk_module = m.rowid
    WHERE 1=1
";

$params = [];

if (!empty($search)) {
    $query .= " AND (
        m.name LIKE :search 
        OR m.num_module LIKE :search
        OR m.description LIKE :search
    )";
    $params[":search"] = "%$search%";
}

$query .= " GROUP BY m.rowid ORDER BY m.name";

$countQuery = "SELECT COUNT(*) FROM ($query) as total";
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$totalModules = $stmt->fetchColumn();
$totalPages = ceil($totalModules / $perPage);

$offset = ($page - 1) * $perPage;
$query .= " LIMIT " . (int) $perPage . " OFFSET " . (int) $offset;

$stmt = $db->prepare($query);
$stmt->execute($params);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pagination = [
    "current" => $page,
    "total" => $totalPages,
    "perPage" => $perPage,
    "totalItems" => $totalModules,
    "start" => $offset + 1,
    "end" => min($offset + $perPage, $totalModules),
];
?>
