<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: ?action=index&element=matieres");
    exit();
}

$query = "
    SELECT 
        m.*,
        module.name as module_name,
        module.coefficient as module_coefficient
    FROM mp_matieres m
    LEFT JOIN mp_modules module ON m.fk_module = module.rowid
    WHERE m.rowid = :id
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$matiere = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$matiere) {
    header("Location: ?action=index&element=matieres");
    exit();
}

$query = "
    SELECT 
        COUNT(*) as total_cours,
        COUNT(DISTINCT fk_enseignant) as nb_enseignants,
        COUNT(CASE WHEN date_cours >= CURRENT_DATE THEN 1 END) as cours_a_venir,
        COUNT(CASE WHEN date_cours < CURRENT_DATE THEN 1 END) as cours_passes,
        SUM(CASE WHEN type_cours = 'CM' THEN 1 ELSE 0 END) as nb_cm,
        SUM(CASE WHEN type_cours = 'TD' THEN 1 ELSE 0 END) as nb_td,
        SUM(CASE WHEN type_cours = 'TP' THEN 1 ELSE 0 END) as nb_tp
    FROM mp_cours
    WHERE fk_matiere = :id
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$stats_cours = $stmt->fetch(PDO::FETCH_ASSOC);

$query = "
    SELECT 
        COUNT(*) as total_presences,
        SUM(CASE WHEN p.status = 'présent' THEN 1 ELSE 0 END) as presents,
        SUM(CASE WHEN p.status = 'absent' THEN 1 ELSE 0 END) as absents,
        SUM(CASE WHEN p.status = 'retard' THEN 1 ELSE 0 END) as retards
    FROM mp_presences p
    JOIN mp_cours c ON p.fk_cours = c.rowid
    WHERE c.fk_matiere = :id
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$stats_presences = $stmt->fetch(PDO::FETCH_ASSOC);

$taux_presence =
    $stats_presences["total_presences"] > 0
        ? round(
            ($stats_presences["presents"] * 100) /
                $stats_presences["total_presences"],
            1
        )
        : 0;

$query = "
    SELECT 
        c.*,
        e.firstname as enseignant_firstname,
        e.lastname as enseignant_lastname,
        COUNT(p.rowid) as nb_presents
    FROM mp_cours c
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    LEFT JOIN mp_presences p ON c.rowid = p.fk_cours AND p.status = 'présent'
    WHERE c.fk_matiere = :id
    GROUP BY c.rowid
    ORDER BY c.date_cours DESC
    LIMIT 5
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$derniers_cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "
    SELECT DISTINCT
        e.*,
        COUNT(c.rowid) as nb_cours
    FROM mp_enseignants e
    JOIN mp_cours c ON e.rowid = c.fk_enseignant
    WHERE c.fk_matiere = :id
    GROUP BY e.rowid
    ORDER BY nb_cours DESC
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$enseignants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
