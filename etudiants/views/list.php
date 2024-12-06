<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Liste des Étudiants</h1>
                <p class="text-gray-500 mt-1">Gérez vos étudiants et leurs informations</p>
            </div>
            <div class="flex space-x-4">
                <a href="?action=add&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvel étudiant
                </a>
                <a href="?action=import&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-all duration-200 shadow-sm hover:shadow-md">
                    <i class="fas fa-file-import mr-2"></i>
                    Importer
                </a>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" class="space-y-4 md:space-y-0 md:flex md:items-center md:space-x-4">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="element" value="etudiants">
                
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" 
                               name="search" 
                               value="<?= htmlspecialchars($search ?? "") ?>" 
                               placeholder="Rechercher un étudiant..." 
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div class="flex space-x-4">
                    <select name="diploma" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les diplômes</option>
                        <?php foreach ($diplomas as $diploma): ?>
                            <option value="<?= htmlspecialchars($diploma) ?>" 
                                    <?= isset($filterDiploma) &&
                                    $filterDiploma === $diploma
                                        ? "selected"
                                        : "" ?>>
                                <?= htmlspecialchars($diploma) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                        <i class="fas fa-filter mr-2"></i>
                        Filtrer
                    </button>

                    <?php if (!empty($search) || !empty($filterDiploma)): ?>
                        <a href="?action=list&element=etudiants" 
                           class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($etudiants)): ?>
                <?php foreach ($etudiants as $etudiant): ?>
                    <?php include "card.php"; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-users text-6xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Aucun étudiant trouvé</h3>
                    <p class="text-gray-500">Modifiez vos critères de recherche ou ajoutez un nouvel étudiant.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>