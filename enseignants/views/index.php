<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Enseignants - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Enseignants</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Gérez et suivez vos <?php echo $stats[
                        "total_enseignants"
                    ]; ?> enseignants
                </p>
            </div>
            <div class="flex gap-4">
                <a href="?action=add&element=enseignants" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvel enseignant
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 gap-6 mb-8">
            
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total enseignants</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["total_enseignants"],
                                0,
                                ",",
                                " "
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <form method="GET" class="flex gap-4">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="element" value="enseignants">
                
                <div class="flex-1">
                    <input type="text" 
                           name="search"
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Rechercher un enseignant..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
                <button type="submit" 
                        class="px-4 py-2 rounded-lg w-1/6 text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Rechercher
                </button>
            </form>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Enseignant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php foreach ($enseignants as $enseignant): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="https://ui-avatars.com/api/?name=<?php echo urlencode(
                                                     $enseignant["firstname"] .
                                                         " " .
                                                         $enseignant["lastname"]
                                                 ); ?>&background=random" 
                                                 alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars(
                                                    $enseignant["firstname"] .
                                                        " " .
                                                        $enseignant["lastname"]
                                                ); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars(
                                                    $enseignant["numens"]
                                                ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="?action=card&element=enseignants&id=<?php echo $enseignant[
                                            "rowid"
                                        ]; ?>" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?action=edit&element=enseignants&id=<?php echo $enseignant[
                                            "rowid"
                                        ]; ?>" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?php echo $enseignant[
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
            </div>

            
            <?php include "views/common/pagination.php"; ?>
        </div>
    </div>
</body>
</html>