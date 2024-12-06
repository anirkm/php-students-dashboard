<?php
$db = require dirname(__FILE__, 2) . "/lib/mypdo.php";

require_once dirname(__FILE__, 2) . "/class/etudiant.class.php";
require_once dirname(__FILE__, 2) . "/class/enseignant.class.php";
require_once dirname(__FILE__, 2) . "/class/cours.class.php";
require_once dirname(__FILE__, 2) . "/class/matiere.class.php";
require_once dirname(__FILE__, 2) . "/class/module.class.php";

$studentCount = count(Etudiant::fetchAll($db));
$teacherCount = count(Enseignant::fetchAll($db));

$stmt = $db->prepare("
    SELECT c.*, m.name as matiere_name, e.firstname as prof_firstname, e.lastname as prof_lastname,
           m.coefficient as matiere_coef
    FROM mp_cours c
    JOIN mp_matieres m ON c.fk_matiere = m.rowid
    JOIN mp_enseignants e ON c.fk_enseignant = e.rowid
    WHERE c.date_cours >= CURRENT_DATE
    ORDER BY c.date_cours ASC
    LIMIT 5
");
$stmt->execute();
$upcomingCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);

