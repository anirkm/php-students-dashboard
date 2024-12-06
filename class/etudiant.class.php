<?php
class Etudiant
{
    private $db;
    public $rowid = null;
    public $numetu = "";
    public $firstname = "";
    public $lastname = "";
    public $birthday = "";
    public $diploma = "";
    public $year = "";
    public $td = "";
    public $tp = "";
    public $address = "";
    public $zipcode = "";
    public $town = "";
    public $fk_user = null;

    public static $diplomas = ["BUT", "Licence Pro", "Master", "Doctorat"];

    public function __construct(PDO $db, array $data = [])
    {
        $this->db = $db;

        if (!empty($data)) {
            $this->setData($data);
        }
    }

    public function setData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                $this->$key = $value;
            }
        }
    }

    public function fetch($identifier): bool
    {
        if (is_numeric($identifier)) {
            $stmt = $this->db->prepare(
                "SELECT * FROM mp_etudiants WHERE rowid = :id"
            );
            $stmt->bindParam(":id", $identifier, PDO::PARAM_INT);
        } else {
            $stmt = $this->db->prepare(
                "SELECT * FROM mp_etudiants WHERE numetu = :numetu"
            );
            $stmt->bindParam(":numetu", $identifier, PDO::PARAM_STR);
        }
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            $this->setData($data);
            return true;
        }
        return false;
    }

    public static function fetchAll(PDO $db): array
    {
        $stmt = $db->query("SELECT * FROM mp_etudiants");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(PDO $db, array $criteria = []): array
    {
        $query = "SELECT * FROM mp_etudiants WHERE 1";
        $params = [];
        foreach ($criteria as $field => $value) {
            if (
                in_array($field, [
                    "rowid",
                    "numetu",
                    "firstname",
                    "lastname",
                    "diploma",
                    "year",
                    "td",
                    "tp",
                    "zipcode",
                    "town",
                ])
            ) {
                $query .= " AND $field LIKE :$field";
                $params[":$field"] = "%$value%";
            }
        }
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function search(PDO $db, string $keyword): array
    {
        $fields = [
            "numetu",
            "firstname",
            "lastname",
            "diploma",
            "year",
            "td",
            "tp",
            "zipcode",
            "town",
            "address",
        ];

        $query = "SELECT * FROM mp_etudiants WHERE ";
        $conditions = [];
        $params = [];

        foreach ($fields as $field) {
            $conditions[] = "$field LIKE :keyword";
        }

        $query .= implode(" OR ", $conditions);

        $stmt = $db->prepare($query);
        $searchTerm = "%" . $keyword . "%";
        $stmt->bindValue(":keyword", $searchTerm, PDO::PARAM_STR);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $userData): bool
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                "INSERT INTO mp_users (username, password, firstname, lastname) VALUES (:username, :password, :firstname, :lastname)"
            );
            $stmt->bindParam(":username", $userData["username"]);
            $hashedPassword = md5($userData["password"]);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->execute();
            $this->fk_user = $this->db->lastInsertId();

            $stmt = $this->db
                ->prepare("INSERT INTO mp_etudiants (numetu, firstname, lastname, birthday, diploma, year, td, tp, address, zipcode, town, fk_user) 
                                         VALUES (:numetu, :firstname, :lastname, :birthday, :diploma, :year, :td, :tp, :address, :zipcode, :town, :fk_user)");
            $stmt->bindParam(":numetu", $this->numetu);
            $stmt->bindParam(":firstname", $this->firstname);
            $stmt->bindParam(":lastname", $this->lastname);
            $stmt->bindParam(":birthday", $this->birthday);
            $stmt->bindParam(":diploma", $this->diploma);
            $stmt->bindParam(":year", $this->year, PDO::PARAM_INT);
            $stmt->bindParam(":td", $this->td);
            $stmt->bindParam(":tp", $this->tp);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":zipcode", $this->zipcode);
            $stmt->bindParam(":town", $this->town);
            $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
            $stmt->execute();
            $this->rowid = $this->db->lastInsertId();

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();

            if (isset($this->fk_user)) {
                $stmt = $this->db->prepare(
                    "DELETE FROM mp_users WHERE rowid = :fk_user"
                );
                $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
                $stmt->execute();
            }

            error_log($e->getMessage());
            return false;
        }
    }

    public function update(): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE mp_etudiants SET numetu = :numetu, firstname = :firstname, lastname = :lastname, birthday = :birthday, diploma = :diploma, year = :year, td = :td, tp = :tp, address = :address, zipcode = :zipcode, town = :town WHERE rowid = :rowid"
        );
        $stmt->bindParam(":numetu", $this->numetu);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":birthday", $this->birthday);
        $stmt->bindParam(":diploma", $this->diploma);
        $stmt->bindParam(":year", $this->year, PDO::PARAM_INT);
        $stmt->bindParam(":td", $this->td);
        $stmt->bindParam(":tp", $this->tp);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":zipcode", $this->zipcode);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":rowid", $this->rowid, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(): bool
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare(
                "DELETE FROM mp_etudiants WHERE rowid = :rowid"
            );
            $stmt->bindParam(":rowid", $this->rowid, PDO::PARAM_INT);
            $stmt->execute();

            if ($this->fk_user) {
                $stmt = $this->db->prepare(
                    "DELETE FROM mp_users WHERE rowid = :fk_user"
                );
                $stmt->bindParam(":fk_user", $this->fk_user, PDO::PARAM_INT);
                $stmt->execute();
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
}
?>
