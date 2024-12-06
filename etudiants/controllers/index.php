<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$search = $_GET["search"] ?? "";
$filterDiploma = $_GET["diploma"] ?? "";
$filterTD = $_GET["td"] ?? "";
$filterTP = $_GET["tp"] ?? "";
$page = max(1, $_GET["page"] ?? 1);
$perPage = 10;

$stats = [];

$stmt = $db->query("SELECT COUNT(*) FROM mp_etudiants");
$stats["total_etudiants"] = $stmt->fetchColumn();

$stmt = $db->query("
    SELECT 
        diploma, 
        COUNT(*) as count,
        ROUND((COUNT(*) * 100.0 / (SELECT COUNT(*) FROM mp_etudiants)), 1) as percentage
    FROM mp_etudiants 
    GROUP BY diploma
    ORDER BY count DESC
");
$stats["etudiants_par_diplome"] = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->query(
    "SELECT DISTINCT td FROM mp_etudiants WHERE td != '' ORDER BY td"
);
$groupes_td = $stmt->fetchAll(PDO::FETCH_COLUMN);

$stmt = $db->query(
    "SELECT DISTINCT tp FROM mp_etudiants WHERE tp != '' ORDER BY tp"
);
$groupes_tp = $stmt->fetchAll(PDO::FETCH_COLUMN);

$query = "
    SELECT 
        e.*,
        COUNT(DISTINCT p.rowid) as total_presences,
        SUM(CASE WHEN p.status = 'présent' THEN 1 ELSE 0 END) as presents,
        SUM(CASE WHEN p.status = 'absent' THEN 1 ELSE 0 END) as absents,
        SUM(CASE WHEN p.status = 'retard' THEN 1 ELSE 0 END) as retards,
        GROUP_CONCAT(DISTINCT m.name) as matieres,
        (
            SELECT COUNT(DISTINCT c2.rowid) 
            FROM mp_cours c2 
            WHERE c2.date_cours >= CURRENT_DATE 
            AND (
                CASE 
                    WHEN c2.type_cours = 'TD' THEN c2.groupe_td = e.td
                    WHEN c2.type_cours = 'TP' THEN c2.groupe_tp = e.tp
                    ELSE 1
                END
            )
        ) as cours_a_venir
    FROM mp_etudiants e
    LEFT JOIN mp_presences p ON e.rowid = p.fk_etudiant
    LEFT JOIN mp_cours c ON p.fk_cours = c.rowid
    LEFT JOIN mp_matieres m ON c.fk_matiere = m.rowid
    WHERE 1=1
";

$params = [];

if (!empty($search)) {
    $query .= " AND (
        e.firstname LIKE :search 
        OR e.lastname LIKE :search 
        OR e.numetu LIKE :search
        OR CONCAT(e.firstname, ' ', e.lastname) LIKE :search
    )";
    $params[":search"] = "%$search%";
}

if (!empty($filterDiploma)) {
    $query .= " AND e.diploma = :diploma";
    $params[":diploma"] = $filterDiploma;
}

if (!empty($filterTD)) {
    $query .= " AND e.td = :td";
    $params[":td"] = $filterTD;
}

if (!empty($filterTP)) {
    $query .= " AND e.tp = :tp";
    $params[":tp"] = $filterTP;
}

$query .= " GROUP BY e.rowid ORDER BY e.lastname, e.firstname";

$countQuery = "SELECT COUNT(*) FROM ($query) as total";
$stmt = $db->prepare($countQuery);
$stmt->execute($params);
$totalEtudiants = $stmt->fetchColumn();
$totalPages = ceil($totalEtudiants / $perPage);

$offset = ($page - 1) * $perPage;

$query .= " LIMIT " . (int) $perPage . " OFFSET " . (int) $offset;

$stmt = $db->prepare($query);
$stmt->execute($params);
$etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stats["groupes"] = [
    "nb_td" => count($groupes_td),
    "nb_tp" => count($groupes_tp),
];

$query = "
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'présent' THEN 1 ELSE 0 END) as presents,
        SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absents,
        SUM(CASE WHEN status = 'retard' THEN 1 ELSE 0 END) as retards
    FROM mp_presences
";
$stmt = $db->query($query);
$stats["presences"] = $stmt->fetch(PDO::FETCH_ASSOC);

$stats["taux_presence"] =
    $stats["presences"]["total"] > 0
        ? round(
            ($stats["presences"]["presents"] * 100) /
                $stats["presences"]["total"],
            1
        )
        : 0;

$pagination = [
    "current" => $page,
    "total" => $totalPages,
    "perPage" => $perPage,
    "totalEtudiants" => $totalEtudiants,
    "start" => $offset + 1,
    "end" => min($offset + $perPage, $totalEtudiants),
];
?>
