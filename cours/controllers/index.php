<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$filterType = $_GET["type"] ?? "";
$filterDate = $_GET["date"] ?? "";
$page = max(1, $_GET["page"] ?? 1);
$perPage = 10;

$stats = [];

$stmt = $db->query("SELECT COUNT(*) FROM mp_cours");
$stats["total_cours"] = $stmt->fetchColumn();

$stmt = $db->query("
    SELECT 
        type_cours, 
        COUNT(*) as count,
        ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM mp_cours)), 1) as percentage
    FROM mp_cours 
    GROUP BY type_cours
");
$stats["cours_par_type"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query(
    "SELECT COUNT(*) FROM mp_cours WHERE date_cours >= CURRENT_DATE"
);
$stats["cours_a_venir"] = $stmt->fetchColumn();

$query = "
    SELECT 
        c.*,
        m.name as matiere_name,
        e.firstname as enseignant_firstname,
        e.lastname as enseignant_lastname,
        COUNT(DISTINCT p.rowid) as nb_presences,
        SUM(CASE WHEN p.status = 'présent' THEN 1 ELSE 0 END) as presents
    FROM mp_cours c
    LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    LEFT JOIN mp_presences p ON c.rowid = p.fk_cours
    WHERE 1=1
";

$params = [];

if (!empty($search)) {
    $query .= " AND (
        m.name LIKE :search 
        OR e.firstname LIKE :search
        OR e.lastname LIKE :search
        OR c.salle LIKE :search
    )";
    $params[":search"] = "%$search%";
}

if (!empty($filterType)) {
    $query .= " AND c.type_cours = :type";
    $params[":type"] = $filterType;
}

if (!empty($filterDate)) {
    $query .= " AND DATE(c.date_cours) = :date";
    $params[":date"] = $filterDate;
}

$query .= " GROUP BY c.rowid ORDER BY c.date_cours DESC, c.rowid DESC";

$countQuery = "SELECT COUNT(*) FROM ($query) as total";
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$totalCours = $stmt->fetchColumn();
$totalPages = ceil($totalCours / $perPage);

$offset = ($page - 1) * $perPage;
$query .= " LIMIT " . (int) $perPage . " OFFSET " . (int) $offset;

$stmt = $db->prepare($query);
$stmt->execute($params);
$cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query(
    "SELECT DISTINCT type_cours FROM mp_cours ORDER BY type_cours"
);
$typesCours = $stmt->fetchAll(PDO::FETCH_COLUMN);

$pagination = [
    "current" => $page,
    "total" => $totalPages,
    "perPage" => $perPage,
    "totalItems" => $totalCours,
    "start" => $offset + 1,
    "end" => min($offset + $perPage, $totalCours),
];
?>
