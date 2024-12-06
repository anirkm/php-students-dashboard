<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <a href="?action=list&element=enseignants" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-8 group transition-all duration-200">
            <i class="fas fa-arrow-left mr-2 transform group-hover:-translate-x-1 transition-transform duration-200"></i>
            <span class="text-sm font-medium">Retour à la liste</span>
        </a>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            
            <div class="p-8 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center mb-6">
                    <img class="h-16 w-16 rounded-full object-cover ring-4 ring-white shadow-md" 
                         src="https://ui-avatars.com/api/?name=<?= urlencode(
                             $enseignant->firstname .
                                 " " .
                                 $enseignant->lastname
                         ) ?>&background=random" 
                         alt="Avatar">
                    <div class="ml-6">
                        <h3 class="text-2xl font-bold text-gray-900">
                            <?= htmlspecialchars(
                                $enseignant->firstname .
                                    " " .
                                    $enseignant->lastname
                            ) ?>
                        </h3>
                        <p class="text-md text-gray-500 mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ID: <?= htmlspecialchars($enseignant->numens) ?>
                            </span>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500 font-medium">Adresse</p>
                                <p class="text-sm text-gray-800">
                                    <?= htmlspecialchars(
                                        $enseignant->address
                                    ) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                <i class="fas fa-home text-indigo-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500 font-medium">Ville</p>
                                <p class="text-sm text-gray-800">
                                    <?= htmlspecialchars(
                                        $enseignant->zipcode
                                    ) ?> <?= htmlspecialchars(
     $enseignant->town
 ) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                                <i class="fas fa-calendar text-purple-600"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-xs text-gray-500 font-medium">Date de naissance</p>
                                <p class="text-sm text-gray-800">
                                    <?= htmlspecialchars(
                                        $enseignant->birthday
                                    ) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="px-8 py-6">
                <h4 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                        <i class="fas fa-chalkboard-teacher text-green-600"></i>
                    </div>
                    Enseignements
                </h4>
                
                <?php if (empty($teaching_info)): ?>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-gray-400 text-xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Aucun cours assigné</p>
                    </div>
                <?php else: ?>
                    <div class="space-y-6">
                    <?php
                    $current_module = null;
                    $current_matiere = null;
                    foreach ($teaching_info as $info): ?>
                        <?php if ($current_module !== $info["module_id"]): ?>
                            <?php if ($current_module !== null): ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="bg-gray-50 rounded-xl p-4 mb-4">
                                <h5 class="text-md font-bold text-blue-600 mb-3 flex items-center">
                                    <i class="fas fa-folder-open mr-2"></i>
                                    <?= htmlspecialchars(
                                        $info["module_name"]
                                    ) ?>
                                    <span class="ml-2 text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded-full">
                                        Coefficient: <?= $info["module_coef"] ?>
                                    </span>
                                </h5>
                            <?php $current_module = $info["module_id"]; ?>
                        <?php endif; ?>

                        <?php if ($current_matiere !== $info["matiere_id"]): ?>
                            <?php if ($current_matiere !== null): ?>
                                </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h6 class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-book mr-2"></i>
                                    <?= htmlspecialchars(
                                        $info["matiere_name"]
                                    ) ?>
                                    <span class="ml-2 text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded-full">
                                        Coefficient: <?= $info[
                                            "matiere_coef"
                                        ] ?>
                                    </span>
                                </h6>
                            <?php $current_matiere = $info["matiere_id"]; ?>
                        <?php endif; ?>

                        <div class="ml-8 mb-3 p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?= $info["type_cours"] === "CM"
                                            ? "bg-purple-100 text-purple-800"
                                            : ($info["type_cours"] === "TD"
                                                ? "bg-green-100 text-green-800"
                                                : "bg-blue-100 text-blue-800") ?>">
                                        <?= htmlspecialchars(
                                            $info["type_cours"]
                                        ) ?>
                                    </span>
                                    <span class="text-gray-600 text-sm">
                                        <?= date(
                                            "d/m/Y H:i",
                                            strtotime($info["date_cours"])
                                        ) ?>
                                    </span>
                                </div>
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <?php if ($info["groupe_td"]): ?>
                                        <span class="flex items-center">
                                            <i class="fas fa-users mr-1"></i>
                                            TD: <?= htmlspecialchars(
                                                $info["groupe_td"]
                                            ) ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($info["groupe_tp"]): ?>
                                        <span class="flex items-center">
                                            <i class="fas fa-laptop-code mr-1"></i>
                                            TP: <?= htmlspecialchars(
                                                $info["groupe_tp"]
                                            ) ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="flex items-center">
                                        <i class="fas fa-door-open mr-1"></i>
                                        <?= htmlspecialchars($info["salle"]) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    ?>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex justify-end space-x-4">
                    <a href="?action=edit&element=enseignants&id=<?= $enseignant->rowid ?>" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        <i class="fas fa-edit mr-2"></i>
                        Éditer
                    </a>
                    <button type="button" 
                            onclick="confirmDelete(<?= $enseignant->rowid ?>)"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                        <i class="fas fa-trash mr-2"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
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