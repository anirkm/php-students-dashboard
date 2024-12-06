<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$filterModule = $_GET["module"] ?? "";
$page = max(1, $_GET["page"] ?? 1);
$perPage = 10;

$stats = [];

$stmt = $db->query("SELECT COUNT(*) FROM mp_matieres");
$stats["total_matieres"] = $stmt->fetchColumn();

$stmt = $db->query("
    SELECT 
        COUNT(*) as total,
        AVG(coefficient) as coef_moyen,
        SUM(coefficient) as coef_total
    FROM mp_matieres
");
$stats["coefficients"] = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->query("
    SELECT m.rowid, COUNT(c.rowid) as nb_cours
    FROM mp_matieres m
    LEFT JOIN mp_cours c ON c.fk_matiere = m.rowid
    GROUP BY m.rowid
");
$coursParMatiere = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$stmt = $db->query("
    SELECT m.rowid, m.name 
    FROM mp_modules m 
    ORDER BY m.name
");
$modules = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$query = "
    SELECT 
        m.*,
        module.name as module_name,
        COUNT(DISTINCT c.rowid) as nb_cours,
        COUNT(DISTINCT e.rowid) as nb_enseignants
    FROM mp_matieres m
    LEFT JOIN mp_modules module ON m.fk_module = module.rowid
    LEFT JOIN mp_cours c ON m.rowid = c.fk_matiere
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE 1=1
";

$params = [];

if (!empty($search)) {
    $query .= " AND (
        m.name LIKE :search 
        OR m.num_matiere LIKE :search
        OR m.description LIKE :search
    )";
    $params[":search"] = "%$search%";
}

if (!empty($filterModule)) {
    $query .= " AND m.fk_module = :module";
    $params[":module"] = $filterModule;
}

$query .= " GROUP BY m.rowid ORDER BY m.name";

$countQuery = "SELECT COUNT(*) FROM ($query) as total";
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$totalMatieres = $stmt->fetchColumn();
$totalPages = ceil($totalMatieres / $perPage);

$offset = ($page - 1) * $perPage;
$query .= " LIMIT " . (int) $perPage . " OFFSET " . (int) $offset;

$stmt = $db->prepare($query);
$stmt->execute($params);
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pagination = [
    "current" => $page,
    "total" => $totalPages,
    "perPage" => $perPage,
    "totalItems" => $totalMatieres,
    "start" => $offset + 1,
    "end" => min($offset + $perPage, $totalMatieres),
];
?>
