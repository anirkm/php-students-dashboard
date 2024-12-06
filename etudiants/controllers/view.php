<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    header("Location: ?action=index&element=etudiants");
    exit();
}

$query = "
    SELECT e.*,
           COUNT(DISTINCT p.rowid) as total_presences,
           SUM(CASE WHEN p.status = 'présent' THEN 1 ELSE 0 END) as presents,
           SUM(CASE WHEN p.status = 'absent' THEN 1 ELSE 0 END) as absents,
           SUM(CASE WHEN p.status = 'retard' THEN 1 ELSE 0 END) as retards
    FROM mp_etudiants e
    LEFT JOIN mp_presences p ON e.rowid = p.fk_etudiant
    WHERE e.rowid = :id
    GROUP BY e.rowid
";

$stmt = $db->prepare($query);
$stmt->execute([":id" => $id]);
$etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$etudiant) {
    header("Location: ?action=index&element=etudiants");
    exit();
}

$query = "
    SELECT p.*, 
           c.date_cours, c.duration, c.type_cours, c.salle,
           m.name as matiere_name,
           CONCAT(e.firstname, ' ', e.lastname) as enseignant_name
    FROM mp_presences p
    JOIN mp_cours c ON p.fk_cours = c.rowid
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE p.fk_etudiant = :etudiant_id
    ORDER BY c.date_cours DESC
    LIMIT 10
";

$stmt = $db->prepare($query);
$stmt->execute([":etudiant_id" => $id]);
$presences = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "
    SELECT c.*, 
           m.name as matiere_name,
           CONCAT(e.firstname, ' ', e.lastname) as enseignant_name
    FROM mp_cours c
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE c.date_cours >= CURRENT_DATE
    AND (
        CASE 
            WHEN c.type_cours = 'TD' THEN c.groupe_td = :td
            WHEN c.type_cours = 'TP' THEN c.groupe_tp = :tp
            ELSE 1
        END
    )
    ORDER BY c.date_cours ASC
    LIMIT 5
";

$stmt = $db->prepare($query);
$stmt->execute([
    ":td" => $etudiant["td"],
    ":tp" => $etudiant["tp"],
]);
$prochains_cours = $stmt->fetchAll(PDO::FETCH_ASSOC);

$taux_presence =
    $etudiant["total_presences"] > 0
        ? round(($etudiant["presents"] * 100) / $etudiant["total_presences"], 1)
        : 0;
?>
