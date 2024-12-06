<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Modifier un Étudiant</h1>
                <p class="text-gray-500 mt-1">
                    <?= htmlspecialchars(
                        $etudiant->firstname . " " . $etudiant->lastname
                    ) ?>
                </p>
            </div>
            <a href="?action=list&element=etudiants" 
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

        <?php if ($success): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <p class="text-green-800">Les modifications ont été enregistrées avec succès.</p>
            </div>
        <?php endif; ?>

        <form action="?action=edit&element=etudiants&id=<?= $etudiant->rowid ?>" method="POST" 
              class="bg-white rounded-xl shadow-sm p-6 space-y-6">
            
            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b flex items-center">
                    <i class="fas fa-user mr-2 text-blue-500"></i>
                    Informations Personnelles
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="firstname" id="firstname" 
                               value="<?= htmlspecialchars(
                                   $etudiant->firstname
                               ) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="lastname" id="lastname" 
                               value="<?= htmlspecialchars(
                                   $etudiant->lastname
                               ) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="numetu" class="block text-sm font-medium text-gray-700 mb-1">Numéro Étudiant</label>
                        <input type="text" name="numetu" id="numetu" 
                               value="<?= htmlspecialchars(
                                   $etudiant->numetu
                               ) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="birthday" class="block text-sm font-medium text-gray-700 mb-1">Date de Naissance</label>
                        <input type="date" name="birthday" id="birthday" 
                               value="<?= htmlspecialchars(
                                   $etudiant->birthday
                               ) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b flex items-center">
                    <i class="fas fa-graduation-cap mr-2 text-blue-500"></i>
                    Scolarité
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="diploma" class="block text-sm font-medium text-gray-700 mb-1">Diplôme</label>
                        <select name="diploma" id="diploma" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionner un diplôme</option>
                            <?php foreach (Etudiant::$diplomas as $diploma): ?>
                                <option value="<?= $diploma ?>" 
                                        <?= $etudiant->diploma === $diploma
                                            ? "selected"
                                            : "" ?>>
                                    <?= $diploma ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                        <input type="number" name="year" id="year" 
                               value="<?= htmlspecialchars($etudiant->year) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required min="1" max="10">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="td" class="block text-sm font-medium text-gray-700 mb-1">Groupe TD</label>
                        <input type="text" name="td" id="td" 
                               value="<?= htmlspecialchars($etudiant->td) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="tp" class="block text-sm font-medium text-gray-700 mb-1">Groupe TP</label>
                        <input type="text" name="tp" id="tp" 
                               value="<?= htmlspecialchars($etudiant->tp) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                    Adresse
                </h2>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" name="address" id="address" 
                           value="<?= htmlspecialchars($etudiant->address) ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="zipcode" class="block text-sm font-medium text-gray-700 mb-1">Code Postal</label>
                        <input type="text" name="zipcode" id="zipcode" 
                               value="<?= htmlspecialchars(
                                   $etudiant->zipcode
                               ) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="town" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <input type="text" name="town" id="town" 
                               value="<?= htmlspecialchars($etudiant->town) ?>" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            
            <div class="flex justify-end space-x-4 pt-6">
                <a href="?action=list&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</body>
</html>