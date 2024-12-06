<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Étudiant - <?php echo htmlspecialchars(
        $etudiant["firstname"] . " " . $etudiant["lastname"]
    ); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen p-6">
        
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <a href="?action=index&element=etudiants" class="text-gray-600 hover:text-gray-900">
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
                </a>
                <div class="flex space-x-3">
                    <a href="?action=edit&element=etudiants&id=<?php echo $etudiant[
                        "rowid"
                    ]; ?>" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    <button onclick="confirmDelete(<?php echo $etudiant[
                        "rowid"
                    ]; ?>)"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            
            <div class="md:col-span-2 bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-6">
                    <img class="h-20 w-20 rounded-full" 
                         src="https://ui-avatars.com/api/?name=<?php echo urlencode(
                             $etudiant["firstname"] .
                                 " " .
                                 $etudiant["lastname"]
                         ); ?>&background=random" 
                         alt="Photo de profil">
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">
                            <?php echo htmlspecialchars(
                                $etudiant["firstname"] .
                                    " " .
                                    $etudiant["lastname"]
                            ); ?>
                        </h1>
                        <p class="text-gray-500">
                            N° Étudiant : <?php echo htmlspecialchars(
                                $etudiant["numetu"]
                            ); ?>
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Informations personnelles</h3>
                        <div class="space-y-2">
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-birthday-cake w-6"></i>
                                <?php echo $etudiant["birthday"]
                                    ? date(
                                        "d/m/Y",
                                        strtotime($etudiant["birthday"])
                                    )
                                    : "Non renseigné"; ?>
                            </p>
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-graduation-cap w-6"></i>
                                <?php echo htmlspecialchars(
                                    $etudiant["diploma"]
                                ); ?>
                            </p>
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-calendar w-6"></i>
                                Année <?php echo htmlspecialchars(
                                    $etudiant["year"]
                                ); ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Coordonnées</h3>
                        <div class="space-y-2">
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-map-marker-alt w-6"></i>
                                <?php echo htmlspecialchars(
                                    $etudiant["address"]
                                ); ?>
                            </p>
                            <p class="flex items-center text-gray-600">
                                <i class="fas fa-city w-6"></i>
                                <?php echo htmlspecialchars(
                                    $etudiant["zipcode"] .
                                        " " .
                                        $etudiant["town"]
                                ); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Statistiques de présence</h3>
                <div class="space-y-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">
                            <?php echo $taux_presence; ?>%
                        </div>
                        <div class="text-sm text-gray-500">Taux de présence</div>
                    </div>
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <div class="text-xl font-semibold text-green-600">
                                <?php echo $etudiant["presents"]; ?>
                            </div>
                            <div class="text-xs text-gray-500">Présent</div>
                        </div>
                        <div>
                            <div class="text-xl font-semibold text-red-600">
                                <?php echo $etudiant["absents"]; ?>
                            </div>
                            <div class="text-xs text-gray-500">Absent</div>
                        </div>
                        <div>
                            <div class="text-xl font-semibold text-yellow-600">
                                <?php echo $etudiant["retards"]; ?>
                            </div>
                            <div class="text-xs text-gray-500">Retard</div>
                        </div>
                    </div>
                    <div class="pt-4 border-t">
                        <div class="flex justify-between items-center text-sm">
                            <span>TD: <?php echo htmlspecialchars(
                                $etudiant["td"]
                            ); ?></span>
                            <span>TP: <?php echo htmlspecialchars(
                                $etudiant["tp"]
                            ); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Prochains cours</h3>
                <div class="space-y-4">
                    <?php if (empty($prochains_cours)): ?>
                        <p class="text-gray-500 text-center py-4">Aucun cours prévu</p>
                    <?php else: ?>
                        <?php foreach ($prochains_cours as $cours): ?>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="font-medium text-gray-900">
                                        <?php echo htmlspecialchars(
                                            $cours["matiere_name"]
                                        ); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo date(
                                            "d/m/Y H:i",
                                            strtotime($cours["date_cours"])
                                        ); ?> - 
                                        Salle <?php echo htmlspecialchars(
                                            $cours["salle"]
                                        ); ?>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        <?php echo $cours["type_cours"] === "TD"
                                            ? "bg-purple-100 text-purple-800"
                                            : ($cours["type_cours"] === "TP"
                                                ? "bg-green-100 text-green-800"
                                                : "bg-blue-100 text-blue-800"); ?>">
                                        <?php echo htmlspecialchars(
                                            $cours["type_cours"]
                                        ); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold mb-4">Dernières présences</h3>
                <div class="space-y-4">
                    <?php if (empty($presences)): ?>
                        <p class="text-gray-500 text-center py-4">Aucun historique disponible</p>
                    <?php else: ?>
                        <?php foreach ($presences as $presence): ?>
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full
                                    <?php echo $presence["status"] === "présent"
                                        ? "bg-green-100 text-green-600"
                                        : ($presence["status"] === "absent"
                                            ? "bg-red-100 text-red-600"
                                            : "bg-yellow-100 text-yellow-600"); ?>">
                                    <i class="fas <?php echo $presence[
                                        "status"
                                    ] === "présent"
                                        ? "fa-check"
                                        : ($presence["status"] === "absent"
                                            ? "fa-times"
                                            : "fa-clock"); ?>"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="font-medium text-gray-900">
                                        <?php echo htmlspecialchars(
                                            $presence["matiere_name"]
                                        ); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo date(
                                            "d/m/Y H:i",
                                            strtotime($presence["date_cours"])
                                        ); ?>
                                    </div>
                                </div>
                                <div class="ml-4 text-right">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        <?php echo $presence["status"] ===
                                        "présent"
                                            ? "bg-green-100 text-green-800"
                                            : ($presence["status"] === "absent"
                                                ? "bg-red-100 text-red-800"
                                                : "bg-yellow-100 text-yellow-800"); ?>">
                                        <?php echo ucfirst(
                                            htmlspecialchars(
                                                $presence["status"]
                                            )
                                        ); ?>
                                    </span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </div>

    <script>
    function confirmDelete(id) {
            window.location.href = `?action=delete&element=etudiants&id=${id}`;
    }
    </script>
</body>
</html>