<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Matières</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-8">
            <div class="flex items-center space-x-4">
                <h1 class="text-3xl font-semibold text-gray-900">Liste des Matières</h1>
                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-medium">
                    <?= count($matieres) ?> matières
                </span>
            </div>
            <a href="?action=add&element=matieres" 
               class="group flex items-center px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md">
                <i class="fas fa-plus mr-2 group-hover:scale-110 transition-transform duration-200"></i>
                Ajouter une Matière
            </a>
        </div>

        
        <div class="backdrop-blur-xl bg-white/50 rounded-2xl shadow-sm p-6 mb-8">
            <form method="GET" class="flex flex-row sm:flex-row items-stretch gap-4">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="element" value="matieres">
                
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                           name="search" 
                           value="<?= htmlspecialchars($search) ?>"
                           placeholder="Rechercher une matière..."
                           class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                </div>
                
                <select name="module_id" 
                        class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    <option value="">Tous les modules</option>
                    <?php foreach ($modules as $module): ?>
                        <option value="<?= $module["rowid"] ?>" 
                                <?= $module_id == $module["rowid"]
                                    ? "selected"
                                    : "" ?>>
                            <?= htmlspecialchars($module["name"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <button type="submit" 
                        class="px-6 py-3 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow-md w-1/6">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrer
                </button>
            </form>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-hashtag mr-2"></i>
                                    N° Matière
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-book mr-2"></i>
                                    Nom
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-folder mr-2"></i>
                                    Module
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <i class="fas fa-balance-scale mr-2"></i>
                                    Coefficient
                                </div>
                            </th>
                            <th scope="col" class="relative px-6 py-4">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($matieres as $matiere): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars(
                                        $matiere["num_matiere"]
                                    ) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars(
                                            $matiere["name"]
                                        ) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 text-sm text-blue-600 bg-blue-50 rounded-full">
                                        <?= htmlspecialchars(
                                            $matiere["module_name"]
                                        ) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= htmlspecialchars(
                                        $matiere["coefficient"]
                                    ) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="?action=view&element=matieres&id=<?= $matiere[
                                            "rowid"
                                        ] ?>"
                                           class="text-yellow-500 hover:text-yellow-600 transition-colors duration-200">
                                           <i class="fas fa-info"></i>
                                        </a>
                                        <a href="?action=edit&element=matieres&id=<?= $matiere[
                                            "rowid"
                                        ] ?>"
                                           class="text-yellow-500 hover:text-yellow-600 transition-colors duration-200">
                                           <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?= $matiere[
                                            "rowid"
                                        ] ?>)"
                                                class="text-red-500 hover:text-red-600 transition-colors duration-200">
                                           <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
            window.location.href = `?action=delete&element=matieres&id=${id}`;
        
    }
    </script>
</body>
</html>