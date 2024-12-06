<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cours - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Cours</h1>
                <p class="mt-1 text-sm text-gray-500">
                    <?php echo $stats[
                        "total_cours"
                    ]; ?> cours dont <?php echo $stats[
     "cours_a_venir"
 ]; ?> à venir
                </p>
            </div>
            <div class="flex gap-4">
                <a href="?action=add&element=cours" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nouveau cours
                </a>
            </div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <?php foreach ($stats["cours_par_type"] as $type): ?>
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Cours <?php echo $type[
                            "type_cours"
                        ]; ?></p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo $type["count"]; ?>
                        </p>
                        <p class="text-sm text-gray-500 mt-1">
                            <?php echo $type["percentage"]; ?>% du total
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-chalkboard text-2xl"></i>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="element" value="cours">
                
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search"
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Rechercher un cours..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                </div>

                <select name="type" 
                        class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Tous les types</option>
                    <?php foreach ($typesCours as $type): ?>
                        <option value="<?php echo $type; ?>" <?php echo $filterType ===
$type
    ? "selected"
    : ""; ?>>
                            <?php echo $type; ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="date" 
                       name="date" 
                       value="<?php echo $filterDate; ?>"
                       class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-green-500 focus:border-green-500">

                <button type="submit" 
                        class="px-4 py-2 rounded-lg text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 transition-all duration-200">
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
                            Date & Matière
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Enseignant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type & Groupe
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Présences
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($cours as $c): ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-lg bg-green-100 text-green-600">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo htmlspecialchars(
                                            $c["matiere_name"]
                                        ); ?>
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        <?php echo date(
                                            "d/m/Y H:i",
                                            strtotime($c["date_cours"])
                                        ); ?>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">
                                <?php echo htmlspecialchars(
                                    $c["enseignant_firstname"] .
                                        " " .
                                        $c["enseignant_lastname"]
                                ); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                <?php echo htmlspecialchars(
                                    $c["type_cours"]
                                ); ?>
                            </span>
                            <?php if ($c["groupe_td"] || $c["groupe_tp"]): ?>
                                <div class="text-sm text-gray-500 mt-1">
                                    Groupe: <?php echo $c["groupe_td"]
                                        ? "TD" . $c["groupe_td"]
                                        : "TP" . $c["groupe_tp"]; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($c["nb_presences"] > 0): ?>
                                <div class="text-sm text-gray-900">
                                    <?php echo $c["presents"]; ?>/<?php echo $c[
    "nb_presences"
]; ?> présents
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                    <div class="bg-green-600 h-2 rounded-full" 
                                         style="width: <?php echo ($c[
                                             "presents"
                                         ] /
                                             $c["nb_presences"]) *
                                             100; ?>%">
                                    </div>
                                </div>
                            <?php else: ?>
                                <span class="text-sm text-gray-500">Pas de présences</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end gap-3">
                                <a href="?action=presence&element=cours&id=<?php echo $c[
                                    "rowid"
                                ]; ?>" 
                                   class="text-green-600 hover:text-green-900" title="Gérer les présences">
                                    <i class="fas fa-user-check"></i>
                                </a>
                                <a href="?action=edit&element=cours&id=<?php echo $c[
                                    "rowid"
                                ]; ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="confirmDelete(<?php echo $c[
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
            window.location.href = `?action=delete&element=cours&id=${id}`;
        
    }
    </script>
</body>
</html>