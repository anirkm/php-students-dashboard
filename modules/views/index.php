<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Modules - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Modules</h1>
                <p class="mt-1 text-sm text-gray-500">
                    <?php echo $stats[
                        "total_modules"
                    ]; ?> modules et <?php echo $stats[
     "total_matieres"
 ]; ?> matières
                </p>
            </div>
            <div class="flex gap-4">
                <a href="?action=add&element=modules" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau module
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total modules</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["total_modules"],
                                0,
                                ",",
                                " "
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <i class="fas fa-cube text-2xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total matières</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["total_matieres"],
                                0,
                                ",",
                                " "
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Coefficient moyen</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["coefficient_moyen"],
                                2,
                                ",",
                                " "
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-calculator text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <form method="GET" class="flex gap-4">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="element" value="modules">
                
                <div class="flex-1">
                    <input type="text" 
                           name="search"
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Rechercher un module..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200">
                </div>
                <button type="submit" 
                        class="px-4 py-2 w-1/6 rounded-lg text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher
                </button>
            </form>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Module
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Coefficient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Matières
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($modules as $module): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-purple-100 text-purple-600">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars(
                                            $module["name"]
                                        ); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars(
                                            $module["num_module"]
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-sm rounded-full bg-green-100 text-green-800">
                                <?php echo number_format(
                                    $module["coefficient"],
                                    2
                                ); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo $module["nb_matieres"]; ?> matière(s)
                            </div>
                            <div class="text-sm text-gray-500">
                                Coef. total: <?php echo number_format(
                                    $module["sum_coefficients"],
                                    2
                                ); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <a href="?action=view&element=modules&id=<?php echo $module[
                                    "rowid"
                                ]; ?>" 
                                   class="text-purple-600 hover:text-purple-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?action=edit&element=modules&id=<?php echo $module[
                                    "rowid"
                                ]; ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete(<?php echo $module[
                                    "rowid"
                                ]; ?>)" 
                                        class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            
            <?php include "views/common/pagination.php"; ?>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce module ?')) {
            window.location.href = `?action=delete&element=modules&id=${id}`;
        }
    }
    </script>
</body>
</html>