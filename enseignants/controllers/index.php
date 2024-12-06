<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$page = max(1, $_GET["page"] ?? 1);
$perPage = 10;

$stats = [];

$stmt = $db->query("SELECT COUNT(*) FROM mp_enseignants");
$stats["total_enseignants"] = $stmt->fetchColumn();

$stmt = $db->query("
    SELECT 
        e.rowid,
        COUNT(c.rowid) as nb_cours
    FROM mp_enseignants e
    LEFT JOIN mp_cours c ON c.fk_enseignant = e.rowid
    GROUP BY e.rowid
");
$coursParEnseignant = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$query = "
    SELECT 
        e.*,
        COUNT(DISTINCT c.rowid) as total_cours,
        GROUP_CONCAT(DISTINCT m.name) as matieres,
        (
            SELECT COUNT(DISTINCT c2.rowid) 
            FROM mp_cours c2 
            WHERE c2.fk_enseignant = e.rowid 
            AND c2.date_cours >= CURRENT_DATE
        ) as cours_a_venir
    FROM mp_enseignants e
    LEFT JOIN mp_cours c ON e.rowid = c.fk_enseignant
    LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
    WHERE 1=1
";

$params = [];

if (!empty($search)) {
    $query .= " AND (
        e.firstname LIKE :search 
        OR e.lastname LIKE :search 
        OR e.numens LIKE :search
        OR CONCAT(e.firstname, ' ', e.lastname) LIKE :search
    )";
    $params[":search"] = "%$search%";
}

$query .= " GROUP BY e.rowid ORDER BY e.lastname, e.firstname";

$countQuery = "SELECT COUNT(*) FROM ($query) as total";
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$totalEnseignants = $stmt->fetchColumn();
$totalPages = ceil($totalEnseignants / $perPage);

$offset = ($page - 1) * $perPage;
$query .= " LIMIT " . (int) $perPage . " OFFSET " . (int) $offset;

$stmt = $db->prepare($query);
$stmt->execute($params);
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pagination = [
    "current" => $page,
    "total" => $totalPages,
    "perPage" => $perPage,
    "totalEnseignants" => $totalEnseignants,
    "start" => $offset + 1,
    "end" => min($offset + $perPage, $totalEnseignants),
];
?>
