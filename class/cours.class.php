<?php
class Cours
{
    private $db; // Instance de la base de données
    public $rowid = null; // Identifiant de la ligne dans la base de données
    public $date_cours; // Date du cours
    public $duration; // Durée du cours
    public $fk_matiere; // Identifiant de la matière
    public $fk_enseignant; // Identifiant de l'enseignant
    public $type_cours; // Type de cours (ex: TD, TP)
    public $groupe_td; // Groupe TD
    public $groupe_tp; // Groupe TP
    public $salle; // Salle où se déroule le cours
    public $status; // Statut du cours (ex: actif, annulé)

    public function __construct(PDO $db, array $data = [])
    {
        $this->db = $db; // Initialisation de la base de données
        if (!empty($data)) {
            $this->setData($data); // Initialisation des données si fournies
        }
    }

    // Fonction pour définir les données de l'objet
    public function setData(array $data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value; // Assigne la valeur à la propriété correspondante
            }
        }
    }

    // Fonction pour créer un nouveau cours dans la base de données
    public function create(): bool
    {
        try {
            $this->db->beginTransaction(); // Démarre une transaction
            $stmt = $this->db
                ->prepare("INSERT INTO mp_cours (date_cours, duration, fk_matiere, fk_enseignant, 
                                       type_cours, groupe_td, groupe_tp, salle, status) 
                                       VALUES (:date_cours, :duration, :fk_matiere, :fk_enseignant, 
                                       :type_cours, :groupe_td, :groupe_tp, :salle, :status)");
            $stmt->execute([
                // Exécute la requête d'insertion
                ":date_cours" => $this->date_cours,
                ":duration" => $this->duration,
                ":fk_matiere" => $this->fk_matiere,
                ":fk_enseignant" => $this->fk_enseignant,
                ":type_cours" => $this->type_cours,
                ":groupe_td" => $this->groupe_td,
                ":groupe_tp" => $this->groupe_tp,
                ":salle" => $this->salle,
                ":status" => $this->status,
            ]);
            $this->rowid = $this->db->lastInsertId(); // Récupère l'ID du dernier cours inséré
            $this->db->commit(); // Confirme la transaction
            return true;
        } catch (Exception $e) {
            $this->db->rollBack(); // Annule la transaction en cas d'erreur
            error_log($e->getMessage()); // Log de l'erreur
            return false;
        }
    }

    // Fonction pour mettre à jour un cours existant
    public function update(): bool
    {
        $stmt = $this->db
            ->prepare("UPDATE mp_cours SET date_cours = :date_cours, duration = :duration, 
                                   fk_matiere = :fk_matiere, fk_enseignant = :fk_enseignant, 
                                   type_cours = :type_cours, groupe_td = :groupe_td, groupe_tp = :groupe_tp, 
                                   salle = :salle, status = :status WHERE rowid = :rowid");
        return $stmt->execute([
            // Exécute la requête de mise à jour
            ":rowid" => $this->rowid,
            ":date_cours" => $this->date_cours,
            ":duration" => $this->duration,
            ":fk_matiere" => $this->fk_matiere,
            ":fk_enseignant" => $this->fk_enseignant,
            ":type_cours" => $this->type_cours,
            ":groupe_td" => $this->groupe_td,
            ":groupe_tp" => $this->groupe_tp,
            ":salle" => $this->salle,
            ":status" => $this->status,
        ]);
    }

    // Fonction pour supprimer un cours de la base de données
    public function delete(): bool
    {
        $stmt = $this->db->prepare("DELETE FROM mp_cours WHERE rowid = :rowid");
        return $stmt->execute([":rowid" => $this->rowid]); // Exécute la requête de suppression
    }

    // Fonction pour enregistrer la présence d'un étudiant à un cours
    public function markPresence(
        int $studentId,
        string $status,
        string $commentaire = ""
    ): bool {
        $stmt = $this->db
            ->prepare("INSERT INTO mp_presences (fk_cours, fk_etudiant, status, commentaire) 
                                   VALUES (:fk_cours, :fk_etudiant, :status, :commentaire)");
        return $stmt->execute([
            // Exécute la requête d'insertion de présence
            ":fk_cours" => $this->rowid,
            ":fk_etudiant" => $studentId,
            ":status" => $status,
            ":commentaire" => $commentaire,
        ]);
    }

    // Fonction pour récupérer les présences d'un cours
    public function getPresences(): array
    {
        $stmt = $this->db->prepare("
            SELECT p.*, e.firstname, e.lastname 
            FROM mp_presences p
            JOIN mp_etudiants e ON p.fk_etudiant = e.rowid
            WHERE p.fk_cours = :coursId
        ");
        $stmt->execute([":coursId" => $this->rowid]); // Exécute la requête de récupération des présences
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les résultats sous forme de tableau associatif
    }

    // Fonction statique pour récupérer un cours par son ID
    public static function getById(PDO $db, int $id): ?self
    {
        $stmt = $db->prepare("SELECT * FROM mp_cours WHERE rowid = :id");
        $stmt->execute([":id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC); // Récupère les données du cours
        return $data ? new self($db, $data) : null; // Retourne un objet Cours ou null si non trouvé
    }

    // Fonction statique pour récupérer tous les cours d'une matière
    public static function getByMatiere(PDO $db, int $matiereId): array
    {
        $stmt = $db->prepare(
            "SELECT * FROM mp_cours WHERE fk_matiere = :matiereId ORDER BY date_cours DESC"
        );
        $stmt->execute([":matiereId" => $matiereId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne la liste des cours
    }
}
