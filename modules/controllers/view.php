<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: ?action=index&element=modules");
    exit();
}

$query = "
    SELECT m.*,
           COUNT(DISTINCT mat.rowid) as nb_matieres,
           SUM(mat.coefficient) as sum_coefficients
    FROM mp_modules m
    LEFT JOIN mp_matieres mat ON mat.fk_module = m.rowid
    WHERE m.rowid = :id
    GROUP BY m.rowid
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$module) {
    header("Location: ?action=index&element=modules");
    exit();
}

$query = "
    SELECT 
        m.*,
        COUNT(DISTINCT c.rowid) as nb_cours,
        COUNT(DISTINCT c.fk_enseignant) as nb_enseignants,
        (
            SELECT COUNT(*)
            FROM mp_presences p
            JOIN mp_cours c2 ON p.fk_cours = c2.rowid
            WHERE c2.fk_matiere = m.rowid
            AND p.status = 'présent'
        ) as total_presences,
        (
            SELECT COUNT(*)
            FROM mp_presences p
            JOIN mp_cours c2 ON p.fk_cours = c2.rowid
            WHERE c2.fk_matiere = m.rowid
        ) as total_participations
    FROM mp_matieres m
    LEFT JOIN mp_cours c ON m.rowid = c.fk_matiere
    WHERE m.fk_module = :id
    GROUP BY m.rowid
    ORDER BY m.name
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$matieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "
    SELECT 
        COUNT(DISTINCT c.rowid) as total_cours,
        COUNT(DISTINCT c.fk_enseignant) as nb_enseignants,
        COUNT(CASE WHEN c.date_cours >= CURRENT_DATE THEN 1 END) as cours_a_venir,
        COUNT(CASE WHEN c.date_cours < CURRENT_DATE THEN 1 END) as cours_passes,
        SUM(CASE WHEN c.type_cours = 'CM' THEN 1 ELSE 0 END) as nb_cm,
        SUM(CASE WHEN c.type_cours = 'TD' THEN 1 ELSE 0 END) as nb_td,
        SUM(CASE WHEN c.type_cours = 'TP' THEN 1 ELSE 0 END) as nb_tp
    FROM mp_cours c
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    WHERE m.fk_module = :id
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
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    WHERE m.fk_module = :id
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
        m.name as matiere_name,
        e.firstname as enseignant_firstname,
        e.lastname as enseignant_lastname,
        COUNT(p.rowid) as nb_presents
    FROM mp_cours c
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    LEFT JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    LEFT JOIN mp_presences p ON c.rowid = p.fk_cours AND p.status = 'présent'
    WHERE m.fk_module = :id
    GROUP BY c.rowid
    ORDER BY c.date_cours DESC
    LIMIT 5
";
$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$derniers_cours = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
