
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion des Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-gray-50 via-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                Tableau de Bord
                <div class="h-1 w-24 bg-blue-500 mt-2 rounded-full"></div>
            </h1>
            <p class="text-gray-600">
                Bienvenue dans votre espace de gestion. Retrouvez ici tous les éléments essentiels pour gérer vos étudiants, enseignants et cours.
            </p>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Étudiants</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2"><?= $studentCount ?></h3>
                    </div>
                    <div class="w-14 h-14 bg-blue-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-users text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="?element=etudiants&action=list" 
                       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium">
                        Voir tous les étudiants
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>

            
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Enseignants</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2"><?= $teacherCount ?></h3>
                    </div>
                    <div class="w-14 h-14 bg-purple-50 rounded-full flex items-center justify-center">
                        <i class="fas fa-chalkboard-teacher text-purple-500 text-xl"></i>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="?element=enseignants&action=list" 
                       class="inline-flex items-center text-sm text-purple-600 hover:text-purple-700 font-medium">
                        Voir tous les enseignants
                        <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Prochains Cours</h2>
                <p class="text-sm text-gray-500 mt-1">Les 5 prochains cours à venir</p>
            </div>
            
            <?php if (empty($upcomingCourses)): ?>
                <div class="p-8 text-center">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-gray-500">Aucun cours à venir</h3>
                </div>
            <?php else: ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($upcomingCourses as $cours): ?>
                        <div class="px-8 py-4 hover:bg-gray-50 transition-colors duration-150">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars(
                                            $cours["matiere_name"]
                                        ) ?>
                                        <span class="text-xs text-gray-500 ml-2">
                                            (Coef. <?= htmlspecialchars(
                                                $cours["matiere_coef"]
                                            ) ?>)
                                        </span>
                                    </h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <?= htmlspecialchars(
                                            $cours["prof_firstname"] .
                                                " " .
                                                $cours["prof_lastname"]
                                        ) ?>
                                    </p>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <div class="text-right">
                                        <div class="text-sm text-gray-900">
                                            <?= date(
                                                "d/m/Y",
                                                strtotime($cours["date_cours"])
                                            ) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= date(
                                                "H:i",
                                                strtotime($cours["date_cours"])
                                            ) ?>
                                        </div>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?= $cours["type_cours"] === "CM"
                                            ? "bg-blue-100 text-blue-800"
                                            : ($cours["type_cours"] === "TD"
                                                ? "bg-green-100 text-green-800"
                                                : "bg-purple-100 text-purple-800") ?>">
                                        <?= htmlspecialchars(
                                            $cours["type_cours"]
                                        ) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>