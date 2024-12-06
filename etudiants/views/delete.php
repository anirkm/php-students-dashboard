<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Étudiant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Supprimer un Étudiant</h1>
                <p class="text-gray-500 mt-1">Cette action est irréversible</p>
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

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center mb-6">
                <img class="h-16 w-16 rounded-full" 
                     src="https://ui-avatars.com/api/?name=<?= urlencode(
                         $etudiant->firstname . " " . $etudiant->lastname
                     ) ?>&background=random" 
                     alt="Avatar">
                <div class="ml-4">
                    <h2 class="text-xl font-semibold text-gray-900">
                        <?= htmlspecialchars(
                            $etudiant->firstname . " " . $etudiant->lastname
                        ) ?>
                    </h2>
                    <p class="text-gray-500">
                        <?= htmlspecialchars(
                            $etudiant->numetu
                        ) ?> - <?= htmlspecialchars($etudiant->diploma) ?>
                    </p>
                </div>
            </div>

            <div class="bg-red-50 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                    <div>
                        <h3 class="text-red-800 font-medium">Attention</h3>
                        <p class="text-red-700 mt-1">
                            Vous êtes sur le point de supprimer définitivement cet étudiant. 
                            Cette action supprimera également toutes les données associées 
                            (présences, notes, etc.).
                        </p>
                    </div>
                </div>
            </div>

            <form action="?action=delete&element=etudiants&id=<?= $etudiant->rowid ?>" 
                  method="POST" 
                  class="flex justify-end space-x-4">
                <a href="?action=list&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-trash mr-2"></i>
                    Confirmer la suppression
                </button>
            </form>
        </div>
    </div>
</body>
</html>