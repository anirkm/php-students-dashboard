<?php
class Module
{
    private $db;
    public $rowid = null;
    public $num_module = "";
    public $name = "";
    public $coefficient = 0.0;
    public $description = "";

    // Constructeur de la classe, initialise la base de données et les données du module si fournies
    public function __construct(PDO $db, array $data = [])
    {
        $this->db = $db;
        if (!empty($data)) {
            $this->setData($data);
        }
    }

    // Méthode pour définir les propriétés de l'objet à partir d'un tableau
    public function setData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Méthode pour créer un nouveau module dans la base de données
    public function create(): bool
    {
        $stmt = $this->db
            ->prepare("INSERT INTO mp_modules (num_module, name, coefficient, description) 
                                   VALUES (:num_module, :name, :coefficient, :description)");
        return $stmt->execute([
            ":num_module" => $this->num_module,
            ":name" => $this->name,
            ":coefficient" => $this->coefficient,
            ":description" => $this->description,
        ]);
    }

    // Méthode pour mettre à jour un module existant dans la base de données
    public function update(): bool
    {
        $stmt = $this->db
            ->prepare("UPDATE mp_modules SET num_module = :num_module, name = :name, 
                                   coefficient = :coefficient, description = :description WHERE rowid = :rowid");
        return $stmt->execute([
            ":rowid" => $this->rowid,
            ":num_module" => $this->num_module,
            ":name" => $this->name,
            ":coefficient" => $this->coefficient,
            ":description" => $this->description,
        ]);
    }

    // Méthode pour supprimer un module de la base de données
    public function delete(): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM mp_modules WHERE rowid = :rowid"
        );
        return $stmt->execute([":rowid" => $this->rowid]);
    }

    // Méthode pour récupérer toutes les matières associées à ce module
    public function getMatieres(): array
    {
        return self::getMatieresByModuleId($this->db, $this->rowid);
    }

    // Méthode statique pour récupérer les matières par l'ID du module
    public static function getMatieresByModuleId(PDO $db, int $moduleId): array
    {
        $stmt = $db->prepare(
            "SELECT * FROM mp_matieres WHERE fk_module = :moduleId"
        );
        $stmt->execute([":moduleId" => $moduleId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode statique pour récupérer un module par son ID
    public static function getById(PDO $db, int $id): ?self
    {
        $stmt = $db->prepare("SELECT * FROM mp_modules WHERE rowid = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($db, $data) : null;
    }
}
