<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ajouter un Étudiant</h1>
                <p class="text-gray-500 mt-1">Créez un nouvel étudiant en remplissant le formulaire ci-dessous</p>
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

        <form method="POST" class="bg-white rounded-xl shadow-sm p-6 space-y-6">
            
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    Informations Principales
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="firstname" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" id="firstname" name="firstname" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>

                <div>
                    <label for="numetu" class="block text-sm font-medium text-gray-700 mb-1">Numéro Étudiant</label>
                    <input type="text" id="numetu" name="numetu" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>
                <div class="mt-4">
                    <label for="birthday" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
                    <input type="date" id="birthday" name="birthday" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        required>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    Scolarité
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="diploma" class="block text-sm font-medium text-gray-700 mb-1">Diplôme</label>
                        <select id="diploma" name="diploma" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                required>
                            <option value="">Sélectionnez...</option>
                            <?php foreach (Etudiant::$diplomas as $diploma): ?>
                                <option value="<?= htmlspecialchars(
                                    $diploma
                                ) ?>"><?= htmlspecialchars($diploma) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                        <input type="number" id="year" name="year" min="1" max="5"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="td" class="block text-sm font-medium text-gray-700 mb-1">Groupe TD</label>
                        <input type="text" id="td" name="td" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="tp" class="block text-sm font-medium text-gray-700 mb-1">Groupe TP</label>
                        <input type="text" id="tp" name="tp" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    Contact
                </h2>
                
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <input type="text" id="address" name="address" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="zipcode" class="block text-sm font-medium text-gray-700 mb-1">Code Postal</label>
                        <input type="text" id="zipcode" name="zipcode" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                    <div>
                        <label for="town" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                        <input type="text" id="town" name="town" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               required>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900 pb-2 border-b">
                    Identifiants de connexion
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur</label>
                        <input type="text" id="username" name="username" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input type="password" id="password" name="password" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6">
                <a href="?action=list&element=etudiants" 
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</body>
</html>