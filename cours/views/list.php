<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planning des Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        
        <div class="mb-8">
            <div class="flex flex-row sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-purple-600">
                        Planning des Cours
                    </h1>
                    <p class="text-gray-500 mt-1">Gérez votre emploi du temps efficacement</p>
                </div>
                <div>
                    <a href="?action=add&element=cours" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                    <button class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-plus"></i>
                        <p class="text-white">Ajouter une seance</p>
                    </button>
                    </a>
                </div>
            </div>
        </div>

        
        <div class="bg-white backdrop-blur-lg bg-opacity-70 rounded-3xl shadow-xl p-6 mb-8">
            <form method="GET" class="space-y-6">
                <input type="hidden" name="action" value="list">
                <input type="hidden" name="element" value="cours">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="space-y-4">
                        <div class="relative">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Date début</label>
                            <input type="date" name="date_debut" 
                                   value="<?php echo $filters[
                                       "date_debut"
                                   ]; ?>" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        </div>
                        <div class="relative">
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Date fin</label>
                            <input type="date" name="date_fin" 
                                   value="<?php echo $filters["date_fin"]; ?>" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        </div>
                    </div>

                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Matière</label>
                            <select name="matiere_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Toutes les matières</option>
                                <?php foreach ($matieres as $matiere): ?>
                                    <option value="<?php echo $matiere[
                                        "rowid"
                                    ]; ?>" 
                                            <?php echo $filters["matiere_id"] ==
                                            $matiere["rowid"]
                                                ? "selected"
                                                : ""; ?>>
                                        <?php echo htmlspecialchars(
                                            $matiere["name"]
                                        ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Enseignant</label>
                            <select name="enseignant_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Tous les enseignants</option>
                                <?php foreach ($enseignants as $enseignant): ?>
                                    <option value="<?php echo $enseignant[
                                        "rowid"
                                    ]; ?>" 
                                            <?php echo $filters[
                                                "enseignant_id"
                                            ] == $enseignant["rowid"]
                                                ? "selected"
                                                : ""; ?>>
                                        <?php echo htmlspecialchars(
                                            $enseignant["firstname"] .
                                                " " .
                                                $enseignant["lastname"]
                                        ); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-700 mb-2 block">Type de cours</label>
                            <select name="type_cours" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                                <option value="">Tous les types</option>
                                <option value="CM" <?php echo $filters[
                                    "type_cours"
                                ] == "CM"
                                    ? "selected"
                                    : ""; ?>>CM</option>
                                <option value="TD" <?php echo $filters[
                                    "type_cours"
                                ] == "TD"
                                    ? "selected"
                                    : ""; ?>>TD</option>
                                <option value="TP" <?php echo $filters[
                                    "type_cours"
                                ] == "TP"
                                    ? "selected"
                                    : ""; ?>>TP</option>
                            </select>
                        </div>
                        <div class="flex flex-col justify-end space-y-1/2">
                            <p>Filtrer Resultats</p>
                            <button type="submit" class="bg-gray-900 text-white px-6 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-filter"></i>
                                <span>Filtrer</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        
        <div class="bg-white backdrop-blur-lg bg-opacity-70 rounded-3xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Horaire</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Matière</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Enseignant</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Type</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Salle</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-gray-500">Status</th>
                            <th class="px-6 py-4 text-right text-sm font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($cours as $c): ?>
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo date(
                                    "d/m/Y",
                                    strtotime($c["date_cours"])
                                ); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo date(
                                    "H:i",
                                    strtotime($c["date_cours"])
                                ); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo htmlspecialchars(
                                    $c["matiere_name"]
                                ); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo htmlspecialchars(
                                    $c["enseignant_name"]
                                ); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    <?php echo match ($c["type_cours"]) {
                                        "CM" => "bg-blue-100 text-blue-800",
                                        "TD" => "bg-green-100 text-green-800",
                                        "TP" => "bg-purple-100 text-purple-800",
                                        default => "bg-gray-100 text-gray-800",
                                    }; ?>">
                                    <?php echo htmlspecialchars(
                                        $c["type_cours"]
                                    ); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo htmlspecialchars($c["salle"]); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    <?php echo match ($c["status"]) {
                                        "planifié"
                                            => "bg-yellow-100 text-yellow-800",
                                        "en cours"
                                            => "bg-green-100 text-green-800",
                                        "terminé"
                                            => "bg-gray-100 text-gray-800",
                                        "annulé" => "bg-red-100 text-red-800",
                                        default => "bg-gray-100 text-gray-800",
                                    }; ?>">
                                    <?php echo htmlspecialchars(
                                        $c["status"]
                                    ); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-2">
                                <a href="?action=card&element=cours&id=<?php echo $c[
                                    "rowid"
                                ]; ?>" 
                                   class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="?action=edit&element=cours&id=<?php echo $c[
                                    "rowid"
                                ]; ?>" 
                                   class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-50 text-green-600 hover:bg-green-100 transition-colors duration-200">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="?action=presence&element=cours&id=<?php echo $c[
                                    "rowid"
                                ]; ?>" 
                                   class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-purple-50 text-purple-600 hover:bg-purple-100 transition-colors duration-200">
                                    <i class="fas fa-users"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>