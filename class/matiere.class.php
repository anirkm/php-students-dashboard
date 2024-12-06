<?php
class Matiere
{
    private $db;
    public $rowid = null;
    public $num_matiere = "";
    public $name = "";
    public $coefficient = 0.0;
    public $fk_module = null;
    public $description = "";

    // Constructeur de la classe, initialise la base de données et les données de la matière si fournies
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

    // Méthode pour créer une nouvelle matière dans la base de données
    public function create(): bool
    {
        $stmt = $this->db
            ->prepare("INSERT INTO mp_matieres (num_matiere, name, coefficient, fk_module, description) 
                                   VALUES (:num_matiere, :name, :coefficient, :fk_module, :description)");
        return $stmt->execute([
            ":num_matiere" => $this->num_matiere,
            ":name" => $this->name,
            ":coefficient" => $this->coefficient,
            ":fk_module" => $this->fk_module,
            ":description" => $this->description,
        ]);
    }

    // Méthode pour mettre à jour une matière existante dans la base de données
    public function update(): bool
    {
        $stmt = $this->db
            ->prepare("UPDATE mp_matieres SET num_matiere = :num_matiere, name = :name, 
                                   coefficient = :coefficient, fk_module = :fk_module, description = :description 
                                   WHERE rowid = :rowid");
        return $stmt->execute([
            ":rowid" => $this->rowid,
            ":num_matiere" => $this->num_matiere,
            ":name" => $this->name,
            ":coefficient" => $this->coefficient,
            ":fk_module" => $this->fk_module,
            ":description" => $this->description,
        ]);
    }

    // Méthode pour supprimer une matière de la base de données
    public function delete(): bool
    {
        $stmt = $this->db->prepare(
            "DELETE FROM mp_matieres WHERE rowid = :rowid"
        );
        return $stmt->execute([":rowid" => $this->rowid]);
    }

    // Méthode pour récupérer tous les cours associés à cette matière
    public function getCours(): array
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM mp_cours WHERE fk_matiere = :matiereId ORDER BY date_cours DESC"
        );
        $stmt->execute([":matiereId" => $this->rowid]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode statique pour récupérer une matière par son ID
    public static function getById(PDO $db, int $id): ?self
    {
        $stmt = $db->prepare("SELECT * FROM mp_matieres WHERE rowid = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new self($db, $data) : null;
    }
}
