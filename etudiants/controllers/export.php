<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
require_once dirname(__FILE__, 3) . "/class/etudiant.class.php";

if (isset($_POST["export_submit"])) {
    try {
        if (empty($_POST["columns"])) {
            throw new Exception(
                "Veuillez sélectionner au moins une colonne à exporter."
            );
        }

        $include_presence = isset($_POST["include_presence"]);
        $filter_diploma = $_POST["filter_diploma"] ?? "";
        $filter_year = $_POST["filter_year"] ?? "";
        $date_format = $_POST["date_format"] ?? "Y-m-d";
        $delimiter = $_POST["delimiter"] ?? ",";
        $selected_columns = $_POST["columns"];

        $query = "SELECT e.*";

        if ($include_presence) {
            $query .= ", COUNT(DISTINCT p.rowid) as total_presences,
                       SUM(CASE WHEN p.status = 'présent' THEN 1 ELSE 0 END) as presents";
        }

        $query .= " FROM mp_etudiants e";

        if ($include_presence) {
            $query .= " LEFT JOIN mp_presences p ON e.rowid = p.fk_etudiant";
        }

        $query .= " WHERE 1=1";
        $params = [];

        if ($filter_diploma) {
            $query .= " AND e.diploma = :diploma";
            $params[":diploma"] = $filter_diploma;
        }

        if ($filter_year) {
            $query .= " AND e.year = :year";
            $params[":year"] = $filter_year;
        }

        if ($include_presence) {
            $query .= " GROUP BY e.rowid";
        }

        if (defined("TEMPLATE_INCLUDED")) {
            die("Template already included");
        }
        define("TEMPLATE_INCLUDED", true);

        while (ob_get_level()) {
            ob_end_clean();
        }

        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $filename = "export_etudiants_" . date("Y-m-d_His") . ".csv";

        header("Content-Type: text/csv; charset=utf-8");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-Control: must-revalidate");

        $output = fopen("php://output", "w");
        fprintf($output, chr(0xef) . chr(0xbb) . chr(0xbf)); // BOM UTF-8

        if ($include_presence) {
            $selected_columns[] = "total_presences";
            $selected_columns[] = "taux_presence";
        }

        $headers = array_map(function ($column) {
            $labels = [
                "numetu" => "Numéro étudiant",
                "firstname" => "Prénom",
                "lastname" => "Nom",
                "birthday" => "Date de naissance",
                "diploma" => "Diplôme",
                "year" => "Année",
                "td" => "Groupe TD",
                "tp" => "Groupe TP",
                "address" => "Adresse",
                "zipcode" => "Code postal",
                "town" => "Ville",
                "total_presences" => "Total présences",
                "taux_presence" => "Taux de présence (%)",
            ];
            return $labels[$column] ?? $column;
        }, $selected_columns);

        fputcsv($output, $headers, $delimiter);

        foreach ($etudiants as $etudiant) {
            $row = [];
            foreach ($selected_columns as $column) {
                if ($column === "birthday" && !empty($etudiant[$column])) {
                    $row[] = date($date_format, strtotime($etudiant[$column]));
                } elseif ($column === "taux_presence") {
                    $row[] =
                        $etudiant["total_presences"] > 0
                            ? round(
                                ($etudiant["presents"] * 100) /
                                    $etudiant["total_presences"],
                                1
                            )
                            : 0;
                } else {
                    $row[] = $etudiant[$column] ?? "";
                }
            }
            fputcsv($output, $row, $delimiter);
        }

        fclose($output);
        exit();
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }
}

$diplomas = Etudiant::$diplomas;
$years = range(1, 5);

try {
    $stats = [
        "total" => $db
            ->query("SELECT COUNT(*) FROM mp_etudiants")
            ->fetchColumn(),
        "by_diploma" => $db
            ->query(
                "SELECT diploma, COUNT(*) as count FROM mp_etudiants GROUP BY diploma"
            )
            ->fetchAll(),
        "by_year" => $db
            ->query(
                "SELECT year, COUNT(*) as count FROM mp_etudiants GROUP BY year"
            )
            ->fetchAll(),
    ];
} catch (PDOException $e) {
    $errors[] =
        "Erreur lors de la récupération des statistiques : " . $e->getMessage();
    $stats = ["total" => 0, "by_diploma" => [], "by_year" => []];
}
