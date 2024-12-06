<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full flex flex-col">
        
        <header class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <h1 class="text-3xl font-light text-gray-900">Détails du Cours</h1>
            </div>
        </header>

        <main class="flex-1 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="flex-1 space-y-8">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 space-y-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h2 class="text-2xl font-medium text-gray-900"><?php echo htmlspecialchars(
                                            $cours["matiere_name"]
                                        ); ?></h2>
                                        <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars(
                                            $cours["type_cours"]
                                        ); ?></p>
                                    </div>
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                        <?php echo $cours["status"] ===
                                        "planifié"
                                            ? "bg-blue-50 text-blue-700"
                                            : ($cours["status"] === "en cours"
                                                ? "bg-yellow-50 text-yellow-700"
                                                : ($cours["status"] ===
                                                "terminé"
                                                    ? "bg-green-50 text-green-700"
                                                    : "bg-red-50 text-red-700")); ?>">
                                        <?php echo htmlspecialchars(
                                            $cours["status"]
                                        ); ?>
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-gray-600"><?php echo date(
                                                "d/m/Y",
                                                strtotime($cours["date_cours"])
                                            ); ?></span>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-gray-600"><?php echo date(
                                                "H:i",
                                                strtotime($cours["date_cours"])
                                            ); ?> (<?php echo htmlspecialchars(
     $cours["duration"]
 ); ?> min)</span>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="text-gray-600"><?php echo htmlspecialchars(
                                                $cours["salle"]
                                            ); ?></span>
                                        </div>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <span class="text-gray-600"><?php echo htmlspecialchars(
                                                $cours["enseignant_name"]
                                            ); ?></span>
                                        </div>
                                        <?php if ($cours["groupe_td"]): ?>
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-gray-600">TD: <?php echo htmlspecialchars(
                                                $cours["groupe_td"]
                                            ); ?></span>
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($cours["groupe_tp"]): ?>
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span class="text-gray-600">TP: <?php echo htmlspecialchars(
                                                $cours["groupe_tp"]
                                            ); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if ($cours["matiere_description"]): ?>
                                <div class="pt-6 border-t border-gray-100">
                                    <h3 class="text-lg font-medium text-gray-900 mb-3">Description de la matière</h3>
                                    <p class="text-gray-600 leading-relaxed"><?php echo nl2br(
                                        htmlspecialchars(
                                            $cours["matiere_description"]
                                        )
                                    ); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($presences)): ?>
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100">
                                <h3 class="text-lg font-medium text-gray-900">Liste des présences</h3>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php foreach (
                                            $presences
                                            as $presence
                                        ): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo htmlspecialchars(
                                                $presence["etudiant_name"]
                                            ); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    <?php echo $presence[
                                                        "status"
                                                    ] === "présent"
                                                        ? "bg-green-100 text-green-800"
                                                        : ($presence[
                                                            "status"
                                                        ] === "absent"
                                                            ? "bg-red-100 text-red-800"
                                                            : "bg-yellow-100 text-yellow-800"); ?>">
                                                    <?php echo htmlspecialchars(
                                                        $presence["status"]
                                                    ); ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo htmlspecialchars(
                                                $presence["commentaire"]
                                            ); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="w-full lg:w-72 flex-shrink-0">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-8">
                            <div class="p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-6">Actions</h3>
                                <div class="space-y-4">
                                    <a href="?action=edit&element=cours&id=<?php echo $coursId; ?>" 
                                       class="flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                        Modifier le cours
                                    </a>
                                    <a href="?action=presence&element=cours&id=<?php echo $coursId; ?>" 
                                       class="flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-yellow-300 hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
                                        Présences
                                    </a>
                                    <a href="?action=delete&element=cours&id=<?php echo $coursId; ?>" 
                                       class="flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                        Supprimer le cours
                                    </a>
                                    <a href="?action=list&element=cours" 
                                       class="flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                                        Retour à la liste
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>