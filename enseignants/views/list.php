<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Enseignants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="flex flex-col sm:flex-row justify-between items-center gap-6 mb-12">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <h1 class="text-3xl font-bold text-gray-900">Liste des Enseignants</h1>
                    <div class="absolute -bottom-2 left-0 w-1/3 h-1 bg-blue-500 rounded-full"></div>
                </div>
                <span class="px-4 py-1.5 bg-blue-50 text-blue-600 rounded-full text-sm font-medium border border-blue-100">
                    <?= count($enseignants) ?> enseignants
                </span>
            </div>
            <a href="?action=add&element=enseignants" 
               class="group flex items-center px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all duration-200 shadow-sm hover:shadow-md transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2 group-hover:rotate-90 transition-transform duration-300"></i>
                Ajouter un Enseignant
            </a>
        </div>

        
        <div class="backdrop-blur-xl bg-white/70 rounded-2xl shadow-sm p-6 mb-12 border border-gray-100">
            <form method="GET" action="" class="flex flex-col sm:flex-row items-stretch gap-4">
                <input type="hidden" name="element" value="enseignants">
                <input type="hidden" name="action" value="list">
                
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                           name="search" 
                           value="<?= htmlspecialchars(
                               $search ?? "",
                               ENT_QUOTES,
                               "UTF-8"
                           ) ?>"
                           placeholder="Rechercher par nom, ville ou ID..."
                           class="w-full pl-12 pr-4 py-3.5 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 shadow-sm">
                </div>
                
                <div class="flex items-center gap-4">
                    <button type="submit" 
                            class="px-6 py-3.5 bg-gray-900 text-white rounded-xl hover:bg-gray-800 transition-all duration-200 shadow-sm hover:shadow-md min-w-[120px] flex items-center justify-center transform hover:-translate-y-0.5">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                    
                    <?php if (!empty($search)): ?>
                        <a href="?action=list&element=enseignants" 
                           class="px-4 py-3.5 text-gray-600 hover:text-gray-900 transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Réinitialiser
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        
        <?php if (!empty($enseignants)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($enseignants as $enseignant): ?>
                    <?php if ($enseignant instanceof Enseignant): ?>
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 border border-gray-100 overflow-hidden group">
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <img class="h-12 w-12 rounded-full object-cover ring-2 ring-gray-100" 
                                         src="https://ui-avatars.com/api/?name=<?= urlencode(
                                             $enseignant->firstname .
                                                 " " .
                                                 $enseignant->lastname
                                         ) ?>&background=random" 
                                         alt="Avatar">
                                    <div class="flex-1 min-w-0">
                                        <a href="?action=view&element=enseignants&id=<?= htmlspecialchars(
                                            $enseignant->rowid ?? "",
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>" 
                                           class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition-colors duration-200 block truncate">
                                            <?= htmlspecialchars(
                                                ($enseignant->firstname ?? "") .
                                                    " " .
                                                    ($enseignant->lastname ??
                                                        ""),
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </a>
                                        <p class="text-sm text-gray-500 truncate">
                                            ID: #<?= htmlspecialchars(
                                                $enseignant->numens ?? "",
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                                        <span class="truncate"><?= htmlspecialchars(
                                            $enseignant->town ?? "",
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-500">
                                        <i class="fas fa-calendar w-5 text-gray-400"></i>
                                        <span class="truncate"><?= htmlspecialchars(
                                            $enseignant->birthday ?? "",
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                                <div class="flex justify-end space-x-3">
                                    <a href="?action=card&element=enseignants&id=<?= htmlspecialchars(
                                        $enseignant->rowid ?? "",
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                       class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200">
                                       <i class="fas fa-info-circle"></i>
                                    </a>
                                    <a href="?action=edit&element=enseignants&id=<?= htmlspecialchars(
                                        $enseignant->rowid ?? "",
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>"
                                       class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors duration-200">
                                       <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="confirmDelete(<?= htmlspecialchars(
                                        $enseignant->rowid ?? "",
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>)"
                                       class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200">
                                       <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            
            <div class="bg-white rounded-2xl shadow-sm p-12 text-center border border-gray-100">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-user-slash text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900">Aucun enseignant trouvé</h3>
                    <p class="text-gray-500 max-w-sm">
                        <?= !empty($search)
                            ? "Aucun enseignant ne correspond à vos critères de recherche."
                            : "Il n'y a actuellement aucun enseignant dans la base de données." ?>
                    </p>
                    <?php if (!empty($search)): ?>
                        <a href="?action=list&element=enseignants" 
                           class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-list mr-2"></i>
                            Voir tous les enseignants
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function confirmDelete(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet enseignant ?")) {
            window.location.href = `?action=delete&element=enseignants&id=${id}`;
        }
    }
    </script>
</body>
</html>