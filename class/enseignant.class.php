<?php
class Enseignant
{
    private $db;
    public $rowid = null; // Identifiant unique de l'enseignant
    public $numens = ""; // Numéro de l'enseignant
    public $firstname = ""; // Prénom de l'enseignant
    public $lastname = ""; // Nom de l'enseignant
    public $birthday = ""; // Date de naissance de l'enseignant
    public $address = ""; // Adresse de l'enseignant
    public $zipcode = ""; // Code postal de l'enseignant
    public $town = ""; // Ville de l'enseignant
    public $fk_user = null; // Identifiant de l'utilisateur lié (clé étrangère)

    // Constructeur qui initialise l'objet avec les données
    public function __construct(PDO $db, array $data = [])
    {
        $this->db = $db;
        if (!empty($data)) {
            $this->setData($data); // Appel à la fonction setData pour initialiser les propriétés
        }
    }

    // Fonction pour définir les valeurs des propriétés à partir d'un tableau
    public function setData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                $this->$key = $value; // Affecte la valeur à la propriété correspondante
            }
        }
    }

    // Récupère un enseignant par son identifiant ou son numéro
    public function fetch($identifier): bool
    {
        if (is_numeric($identifier)) {
            $stmt = $this->db->prepare(
                "SELECT * FROM mp_enseignants WHERE rowid = :id"
            );
            $stmt->bindParam(":id", $identifier, PDO::PARAM_INT);
        } else {
            $stmt = $this->db->prepare(
                "SELECT * FROM mp_enseignants WHERE numens = :numens"
            );
            $stmt->bindParam(":numens", $identifier, PDO::PARAM_STR);
        }
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $this->setData($data); // Charge les données dans l'objet
            return true;
        }
        return false;
    }

    // Récupère tous les enseignants
    public static function fetchAll(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM mp_enseignants");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche les enseignants selon des critères donnés
    public static function find(PDO $db, array $criteria = []): array
    {
        $query = "SELECT * FROM mp_enseignants WHERE 1";
        $params = [];
        foreach ($criteria as $field => $value) {
            if (
                in_array($field, [
                    "rowid",
                    "numens",
                    "firstname",
                    "lastname",
                    "zipcode",
                    "town",
                ])
            ) {
                $query .= " AND $field LIKE :$field";
                $params[":$field"] = "%$value%"; // Ajoute la condition de recherche
            }
        }
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Recherche des enseignants en fonction d'un mot-clé
    public static function search(PDO $db, string $keyword): array
    {
        $fields = [
            "numens",
            "firstname",
            "lastname",
            "zipcode",
            "town",
            "address",
        ];

        $query = "SELECT * FROM mp_enseignants WHERE ";
        $conditions = [];
        $params = [];

        foreach ($fields as $index => $field) {
            $param = ":keyword$index";
            $conditions[] = "$field LIKE $param"; // Création de conditions de recherche par mot-clé
            $params[$param] = "%" . $keyword . "%"; // Paramètre de recherche
        }

        $query .= implode(" OR ", $conditions);

        $stmt = $db->prepare($query);
        foreach ($params as $param => $value) {
            $stmt->bindValue($param, $value, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crée un nouvel enseignant et l'utilisateur associé dans la base de données
    public function create(array $userData): bool
    {
        try {
            $this->db->beginTransaction();

            // Insertion dans la table des utilisateurs
            $stmt = $this->db->prepare(
                "INSERT INTO mp_users (username, password, firstname, lastname) VALUES (:username, :password, :firstname, :lastname)"
            );
            $stmt->bindParam(":username", $userData["username"]);
            $hashedPassword = md5($userData["password"]); // Hashage du mot de passe
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->execute();
            $this->fk_user = $this->db->lastInsertId(); // Récupère l'ID de l'utilisateur créé

            // Insertion dans la table des enseignants
            $stmt = $this->db
                ->prepare("INSERT INTO mp_enseignants (numens, firstname, lastname, birthday, address, zipcode, town, fk_user) 
                                         VALUES (:numens, :firstname, :lastname, :birthday, :address, :zipcode, :town, :fk_user)");
            $stmt->bindParam(":numens", $this->numens);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":birthday", $this->birthday);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":zipcode", $this->zipcode);
            $stmt->bindParam(":town", $this->town);
            $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
            $stmt->execute();
            $this->rowid = $this->db->lastInsertId(); // Récupère l'ID de l'enseignant créé

            $this->db->commit(); // Valide la transaction
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Annule la transaction en cas d'erreur

            if (isset($this->fk_user)) {
                // Supprime l'utilisateur associé si l'insertion échoue
                $stmt = $this->db->prepare(
                    "DELETE FROM mp_users WHERE rowid = :fk_user"
                );
                $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
                $stmt->execute();
            }

            error_log($e->getMessage()); // Enregistre l'erreur
            return false;
        }
    }

    // Met à jour les informations d'un enseignant
    public function update(): bool
    {
        $stmt = $this->db
            ->prepare("UPDATE mp_enseignants SET numens = :numens, firstname = :firstname, lastname = :lastname, 
                                    birthday = :birthday, address = :address, zipcode = :zipcode, town = :town 
                                    WHERE rowid = :rowid");
        $stmt->bindParam(":numens", $this->numens);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":birthday", $this->birthday);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":zipcode", $this->zipcode);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":rowid", $this->rowid, PDO::PARAM_INT);
        return $stmt->execute(); // Exécute la requête de mise à jour
    }

    // Supprime un enseignant et son utilisateur associé
    public function delete(): bool
    {
        try {
            $this->db->beginTransaction();

            // Suppression de l'enseignant
            $stmt = $this->db->prepare(
                "DELETE FROM mp_enseignants WHERE rowid = :rowid"
            );
            $stmt->bindParam(":rowid", $this->rowid, PDO::PARAM_INT);
            $stmt->execute();

            // Suppression de l'utilisateur associé
            if ($this->fk_user) {
                $stmt = $this->db->prepare(
                    "DELETE FROM mp_users WHERE rowid = :fk_user"
                );
                $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->db->commit(); // Valide la transaction
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Annule la transaction en cas d'erreur
            error_log($e->getMessage()); // Enregistre l'erreur
            return false;
        }
    }
}
?>
