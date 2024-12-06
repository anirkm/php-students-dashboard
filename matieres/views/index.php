<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Matières - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Matières</h1>
                <p class="mt-1 text-sm text-gray-500">
                    <?php echo $stats[
                        "total_matieres"
                    ]; ?> matières réparties sur <?php echo count(
     $modules
 ); ?> modules
                </p>
            </div>
            <div class="flex gap-4">
                <a href="?action=add&element=matieres" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvelle matière
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
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
                                $stats["coefficients"]["coef_moyen"],
                                2
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-calculator text-2xl"></i>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Coefficient total</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["coefficients"]["coef_total"],
                                2
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-sum text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="element" value="matieres">
                
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search"
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Rechercher une matière..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                </div>

                <select name="module" 
                        class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les modules</option>
                    <?php foreach ($modules as $id => $name): ?>
                        <option value="<?php echo $id; ?>" <?php echo $filterModule ==
$id
    ? "selected"
    : ""; ?>>
                            <?php echo htmlspecialchars($name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" 
                        class="px-4 py-2 rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Filtrer
                </button>
            </form>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Matière
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Module
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Coefficient
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statistiques
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($matieres as $matiere): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars(
                                            $matiere["name"]
                                        ); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo htmlspecialchars(
                                            $matiere["num_matiere"]
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">
                                <?php echo htmlspecialchars(
                                    $matiere["module_name"]
                                ); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                <?php echo number_format(
                                    $matiere["coefficient"],
                                    2
                                ); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo $matiere["nb_cours"]; ?> cours
                            </div>
                            <div class="text-sm text-gray-500">
                                <?php echo $matiere[
                                    "nb_enseignants"
                                ]; ?> enseignant(s)
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <a href="?action=view&element=matieres&id=<?php echo $matiere[
                                    "rowid"
                                ]; ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?action=edit&element=matieres&id=<?php echo $matiere[
                                    "rowid"
                                ]; ?>" 
                                   class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete(<?php echo $matiere[
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
            window.location.href = `?action=delete&element=matieres&id=${id}`;
    }
    </script>
</body>
</html>