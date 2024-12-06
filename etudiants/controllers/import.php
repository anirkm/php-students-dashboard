<?php
$db = require dirname(__FILE__) . "/../../lib/mypdo.php";
$errors = [];
$success = [];

$required_columns = [
    "numetu" => [
        "label" => "Numéro étudiant",
        "aliases" => [
            "numetu",
            "numero_etudiant",
            "numéro étudiant",
            "numero etudiant",
            "id",
            "Numéro étudiant",
        ],
        "validate" => function ($value) {
            return !empty($value) && preg_match('/^[A-Z0-9]+$/', $value);
        },
    ],
    "firstname" => [
        "label" => "Prénom",
        "aliases" => ["firstname", "prenom", "prénom"],
        "validate" => function ($value) {
            return !empty($value) && strlen($value) <= 50;
        },
    ],
    "lastname" => [
        "label" => "Nom",
        "aliases" => ["lastname", "nom"],
        "validate" => function ($value) {
            return !empty($value) && strlen($value) <= 50;
        },
    ],
    "birthday" => [
        "label" => "Date de naissance",
        "aliases" => [
            "birthday",
            "date_naissance",
            "date de naissance",
            "naissance",
        ],
        "validate" => function ($value) {
            if (empty($value)) {
                return true;
            }
            $date = DateTime::createFromFormat("Y-m-d", $value);
            return $date && $date->format("Y-m-d") === $value;
        },
    ],
    "diploma" => [
        "label" => "Diplôme",
        "aliases" => ["diploma", "diplome", "diplôme"],
        "validate" => function ($value) use ($db) {
            return in_array($value, Etudiant::$diplomas);
        },
    ],
    "year" => [
        "label" => "Année",
        "aliases" => ["year", "annee", "année"],
        "validate" => function ($value) {
            return is_numeric($value) && $value >= 1 && $value <= 5;
        },
    ],
    "td" => [
        "label" => "Groupe TD",
        "aliases" => ["td", "groupe_td", "groupe td"],
        "validate" => function ($value) {
            return strlen($value) <= 10;
        },
    ],
    "tp" => [
        "label" => "Groupe TP",
        "aliases" => ["tp", "groupe_tp", "groupe tp"],
        "validate" => function ($value) {
            return strlen($value) <= 10;
        },
    ],
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_FILES["csv_file"]) &&
        $_FILES["csv_file"]["error"] === UPLOAD_ERR_OK
    ) {
        $file = $_FILES["csv_file"]["tmp_name"];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file);
        finfo_close($finfo);

        if (
            !in_array($mime_type, [
                "text/csv",
                "text/plain",
                "application/vnd.ms-excel",
                "application/octet-stream",
            ])
        ) {
            $errors[] = "Le fichier doit être au format CSV.";
        } else {
            $handle = fopen($file, "r");
            if ($handle !== false) {
                try {
                    $db->beginTransaction();

                    $sample = fgets($handle);
                    rewind($handle);
                    $delimiter =
                        substr_count($sample, ",") > substr_count($sample, ";")
                            ? ","
                            : ";";

                    $headers = fgetcsv($handle, 1000, $delimiter);
                    $headers = array_map("trim", $headers);
                    $headers = array_map("strtolower", $headers);

                    $column_mapping = [];
                    foreach ($headers as $index => $header) {
                        foreach (
                            $required_columns
                            as $required_key => $column_info
                        ) {
                            if (in_array($header, $column_info["aliases"])) {
                                $column_mapping[$required_key] = $index;
                                break;
                            }
                        }
                    }

                    $missing_columns = array_diff(
                        array_keys($required_columns),
                        array_keys($column_mapping)
                    );
                    if (!empty($missing_columns)) {
                        $missing_labels = array_map(function ($col) use (
                            $required_columns
                        ) {
                            return $required_columns[$col]["label"];
                        }, $missing_columns);
                        throw new Exception(
                            "Colonnes manquantes : " .
                                implode(", ", $missing_labels)
                        );
                    }

                    $line = 2; // Commence à 2 car ligne 1 = en-têtes
                    $imported = 0;

                    while (
                        ($data = fgetcsv($handle, 1000, $delimiter)) !== false
                    ) {
                        $row_data = [];
                        foreach ($column_mapping as $key => $index) {
                            $row_data[$key] = isset($data[$index])
                                ? trim($data[$index])
                                : "";
                        }

                        $validation_errors = [];

                        foreach ($required_columns as $column => $rules) {
                            $value = $row_data[$column] ?? "";
                            if (!$rules["validate"]($value)) {
                                $validation_errors[] = "'{$rules["label"]}' invalide";
                            }
                        }

                        if (!empty($validation_errors)) {
                            throw new Exception(
                                "Ligne $line : " .
                                    implode(", ", $validation_errors)
                            );
                        }

                        $stmt = $db->prepare(
                            "SELECT COUNT(*) FROM mp_etudiants WHERE numetu = :numetu"
                        );
                        $stmt->execute([":numetu" => $row_data["numetu"]]);
                        if ($stmt->fetchColumn() > 0) {
                            throw new Exception(
                                "Ligne $line : L'étudiant avec le numéro {$row_data["numetu"]} existe déjà"
                            );
                        }

                        $etudiant = new Etudiant($db);
                        foreach ($row_data as $key => $value) {
                            $etudiant->$key = $value;
                        }

                        if (
                            !$etudiant->create([
                                "username" => $row_data["numetu"],
                                "password" => "password123",
                            ])
                        ) {
                            throw new Exception(
                                "Ligne $line : Erreur lors de la création de l'étudiant"
                            );
                        }

                        $imported++;
                        $line++;
                    }

                    $db->commit();
                    $success[] = "$imported étudiants importés avec succès.";
                } catch (Exception $e) {
                    $db->rollBack();
                    $errors[] = $e->getMessage();
                }

                fclose($handle);
            } else {
                $errors[] = "Impossible d'ouvrir le fichier CSV.";
            }
        }
    } else {
        $errors[] = "Veuillez sélectionner un fichier CSV valide.";
    }
}
?>
