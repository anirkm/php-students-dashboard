<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(
        $matiere["name"]
    ); ?> - Détails de la matière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <div class="flex items-center gap-4">
                        <a href="?action=index&element=matieres" 
                           class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <h1 class="text-3xl font-bold text-gray-900">
                            <?php echo htmlspecialchars($matiere["name"]); ?>
                        </h1>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Code: <?php echo htmlspecialchars(
                            $matiere["num_matiere"]
                        ); ?> | 
                        Module: <?php echo htmlspecialchars(
                            $matiere["module_name"]
                        ); ?>
                    </p>
                </div>
                <div class="flex gap-4">
                    <a href="?action=edit&element=matieres&id=<?php echo $matiere[
                        "rowid"
                    ]; ?>" 
                       class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 shadow-sm">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                    <button onclick="confirmDelete(<?php echo $matiere[
                        "rowid"
                    ]; ?>)"
                            class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 transition-all duration-200 shadow-sm">
                        <i class="fas fa-trash mr-2"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Coefficient</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $matiere["coefficient"],
                                2
                            ); ?>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            sur <?php echo number_format(
                                $matiere["module_coefficient"],
                                2
                            ); ?> (module)
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
                        <p class="text-sm font-medium text-gray-500">Cours</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo $stats_cours["total_cours"]; ?>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            dont <?php echo $stats_cours[
                                "cours_a_venir"
                            ]; ?> à venir
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                        <i class="fas fa-chalkboard text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Taux de présence</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo $taux_presence; ?>%
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="h-1.5 rounded-full bg-green-600"
                                 style="width: <?php echo $taux_presence; ?>%"></div>
                        </div>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-user-check text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Enseignants</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo $stats_cours["nb_enseignants"]; ?>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            intervenants différents
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <i class="fas fa-chalkboard-teacher text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Derniers cours</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($derniers_cours as $cours): ?>
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo date(
                                        "d/m/Y H:i",
                                        strtotime($cours["date_cours"])
                                    ); ?>
                                    - <?php echo htmlspecialchars(
                                        $cours["type_cours"]
                                    ); ?>
                                </div>
                                <div class="text-sm text-gray-500">
                                    <?php echo htmlspecialchars(
                                        $cours["enseignant_firstname"] .
                                            " " .
                                            $cours["enseignant_lastname"]
                                    ); ?>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    <?php echo $cours[
                                        "nb_presents"
                                    ]; ?> présents
                                </span>
                                <a href="?action=card&element=cours&id=<?php echo $cours[
                                    "rowid"
                                ]; ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">Enseignants</h2>
                    </div>
                    <div class="divide-y divide-gray-100">
                        <?php foreach ($enseignants as $enseignant): ?>
                        <div class="px-6 py-4 flex items-center justify-between">
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
                                        <?php echo $enseignant[
                                            "nb_cours"
                                        ]; ?> cours
                                    </div>
                                </div>
                            </div>
                            <a href="?action=card&element=enseignants&id=<?php echo $enseignant[
                                "rowid"
                            ]; ?>" 
                               class="text-indigo-600 hover:text-indigo-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette matière ?')) {
            window.location.href = `?action=delete&element=matieres&id=${id}`;
        }
    }
    </script>
</body>
</html>