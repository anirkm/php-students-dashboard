<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Modifier un Cours</h1>
                <p class="text-gray-500 mt-1">Modifiez les informations du cours en utilisant le formulaire ci-dessous</p>
            </div>
            <a href="?action=list&element=cours" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <h3 class="text-red-800 font-medium">Des erreurs sont survenues</h3>
                </div>
                <ul class="text-red-700 ml-6 list-disc">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <form method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-6">
            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    <i class="fas fa-calendar-alt mr-2"></i>Date et Durée
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                        <input type="date" id="date" name="date" 
                               value="<?= date(
                                   "Y-m-d",
                                   strtotime($cours["date_cours"])
                               ) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="heure" class="block text-sm font-medium text-gray-700 mb-1">Heure</label>
                        <input type="time" id="heure" name="heure" 
                               value="<?= date(
                                   "H:i",
                                   strtotime($cours["date_cours"])
                               ) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Durée (minutes)</label>
                        <input type="number" id="duration" name="duration" 
                               value="<?= htmlspecialchars(
                                   $cours["duration"]
                               ) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    <i class="fas fa-book mr-2"></i>Informations du Cours
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="fk_matiere" class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                        <select id="fk_matiere" name="fk_matiere" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionner une matière</option>
                            <?php foreach ($matieres as $matiere): ?>
                                <option value="<?= $matiere["rowid"] ?>" 
                                        <?= $cours["fk_matiere"] ==
                                        $matiere["rowid"]
                                            ? "selected"
                                            : "" ?>>
                                    <?= htmlspecialchars($matiere["name"]) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="fk_enseignant" class="block text-sm font-medium text-gray-700 mb-1">Enseignant</label>
                        <select id="fk_enseignant" name="fk_enseignant" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionner un enseignant</option>
                            <?php foreach ($enseignants as $enseignant): ?>
                                <option value="<?= $enseignant["rowid"] ?>" 
                                        <?= $cours["fk_enseignant"] ==
                                        $enseignant["rowid"]
                                            ? "selected"
                                            : "" ?>>
                                    <?= htmlspecialchars(
                                        $enseignant["firstname"] .
                                            " " .
                                            $enseignant["lastname"]
                                    ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    <i class="fas fa-map-marker-alt mr-2"></i>Type et Localisation
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="type_cours" class="block text-sm font-medium text-gray-700 mb-1">Type de cours</label>
                        <select id="type_cours" name="type_cours" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionner le type</option>
                            <option value="CM" <?= $cours["type_cours"] == "CM"
                                ? "selected"
                                : "" ?>>CM</option>
                            <option value="TD" <?= $cours["type_cours"] == "TD"
                                ? "selected"
                                : "" ?>>TD</option>
                            <option value="TP" <?= $cours["type_cours"] == "TP"
                                ? "selected"
                                : "" ?>>TP</option>
                        </select>
                    </div>
                    <div>
                        <label for="salle" class="block text-sm font-medium text-gray-700 mb-1">Salle</label>
                        <input type="text" id="salle" name="salle" 
                               value="<?= htmlspecialchars($cours["salle"]) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="groupe_td" class="block text-sm font-medium text-gray-700 mb-1">Groupe TD</label>
                        <input type="text" id="groupe_td" name="groupe_td" 
                               value="<?= htmlspecialchars(
                                   $cours["groupe_td"]
                               ) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="groupe_tp" class="block text-sm font-medium text-gray-700 mb-1">Groupe TP</label>
                        <input type="text" id="groupe_tp" name="groupe_tp" 
                               value="<?= htmlspecialchars(
                                   $cours["groupe_tp"]
                               ) ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status" name="status" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="planifié" <?= $cours["status"] ==
                            "planifié"
                                ? "selected"
                                : "" ?>>Planifié</option>
                            <option value="en cours" <?= $cours["status"] ==
                            "en cours"
                                ? "selected"
                                : "" ?>>En cours</option>
                            <option value="terminé" <?= $cours["status"] ==
                            "terminé"
                                ? "selected"
                                : "" ?>>Terminé</option>
                            <option value="annulé" <?= $cours["status"] ==
                            "annulé"
                                ? "selected"
                                : "" ?>>Annulé</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="?action=list&element=cours" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" name="delete"
                        class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                        onclick="return confirmDelete(<?= $cours["rowid"] ?>)">
                    <i class="fas fa-trash-alt mr-2"></i>Supprimer
                </button>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
            </div>
        </form>
    </div>
    <script>
        function confirmDelete(id) {
        window.location.href = `?action=delete&element=cours&id=${id}`;
    
}
    </script>
</body>
</html>