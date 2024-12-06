<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Étudiants - Administration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Gestion des Étudiants</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Gérez et suivez vos <?php echo $stats[
                        "total_etudiants"
                    ]; ?> étudiants
                </p>
            </div>
            <div class="flex gap-4">
                <a href="?action=add&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Nouvel étudiant
                </a>
                <a href="?action=import&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-file-import mr-2"></i>
                    Importer
                </a>
                <a href="?action=export&element=etudiants" 
                   class="inline-flex items-center px-4 py-2 rounded-lg text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 transition-all duration-200 shadow-sm">
                    <i class="fas fa-file-export mr-2"></i>
                    Exporter
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total étudiants</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["total_etudiants"],
                                0,
                                ",",
                                " "
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Taux de présence</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo number_format(
                                $stats["taux_presence"],
                                1
                            ); ?>%
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-green-50 text-green-600">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Groupes TD/TP</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo $stats["groupes"][
                                "nb_td"
                            ]; ?>/<?php echo $stats["groupes"]["nb_tp"]; ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-orange-50 text-orange-600">
                        <i class="fas fa-layer-group text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Diplômes différents</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            <?php echo count(
                                $stats["etudiants_par_diplome"]
                            ); ?>
                        </p>
                    </div>
                    <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-gray-100">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="hidden" name="action" value="index">
                <input type="hidden" name="element" value="etudiants">
                
                <div class="flex-1 min-w-[200px]">
                    <input type="text" 
                           name="search"
                           value="<?php echo htmlspecialchars($search); ?>"
                           placeholder="Rechercher un étudiant..." 
                           class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>

                <select name="diploma" 
                        class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les diplômes</option>
                    <?php foreach (
                        $stats["etudiants_par_diplome"]
                        as $diplome
                    ): ?>
                        <option value="<?php echo htmlspecialchars(
                            $diplome["diploma"]
                        ); ?>"
                                <?php echo $filterDiploma ===
                                $diplome["diploma"]
                                    ? "selected"
                                    : ""; ?>>
                            <?php echo htmlspecialchars(
                                $diplome["diploma"]
                            ); ?> 
                            (<?php echo $diplome[
                                "count"
                            ]; ?> - <?php echo $diplome["percentage"]; ?>%)
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="td" 
                        class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les TD</option>
                    <?php foreach ($groupes_td as $td): ?>
                        <option value="<?php echo htmlspecialchars($td); ?>"
                                <?php echo $filterTD === $td
                                    ? "selected"
                                    : ""; ?>>
                            TD <?php echo htmlspecialchars($td); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="tp" 
                        class="px-4 py-2 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tous les TP</option>
                    <?php foreach ($groupes_tp as $tp): ?>
                        <option value="<?php echo htmlspecialchars($tp); ?>"
                                <?php echo $filterTP === $tp
                                    ? "selected"
                                    : ""; ?>>
                            TP <?php echo htmlspecialchars($tp); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" 
                        class="px-4 py-2 rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition-all duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Filtrer
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Étudiant
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Informations
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Groupes
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
                        <?php foreach ($etudiants as $etudiant): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="https://ui-avatars.com/api/?name=<?php echo urlencode(
                                                     $etudiant["firstname"] .
                                                         " " .
                                                         $etudiant["lastname"]
                                                 ); ?>&background=random" 
                                                 alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars(
                                                    $etudiant["firstname"] .
                                                        " " .
                                                        $etudiant["lastname"]
                                                ); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars(
                                                    $etudiant["numetu"]
                                                ); ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            <?php echo htmlspecialchars(
                                                $etudiant["diploma"]
                                            ); ?>
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        <?php if ($etudiant["birthday"]): ?>
                                            <i class="fas fa-birthday-cake mr-1"></i>
                                            <?php echo date(
                                                "d/m/Y",
                                                strtotime($etudiant["birthday"])
                                            ); ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($etudiant["td"]): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-orange-100 text-orange-800">
                                            TD <?php echo htmlspecialchars(
                                                $etudiant["td"]
                                            ); ?>
                                        </span>
                                    <?php endif; ?>
                                    <?php if ($etudiant["tp"]): ?>
                                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 ml-2">
                                            TP <?php echo htmlspecialchars(
                                                $etudiant["tp"]
                                            ); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                    $presenceRate =
                                        $etudiant["total_presences"] > 0
                                            ? round(
                                                ($etudiant["presents"] * 100) /
                                                    $etudiant[
                                                        "total_presences"
                                                    ],
                                                1
                                            )
                                            : 0;
                                    $colorClass =
                                        $presenceRate >= 90
                                            ? "bg-green-100 text-green-800"
                                            : ($presenceRate >= 75
                                                ? "bg-yellow-100 text-yellow-800"
                                                : "bg-red-100 text-red-800");
                                    ?>
                                    <div class="flex flex-col gap-2">
                                        <span class="px-2 py-1 text-xs rounded-full <?php echo $colorClass; ?> w-fit">
                                            <?php echo $presenceRate; ?>% présent
                                        </span>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full <?php echo str_replace(
                                                "text",
                                                "bg",
                                                $colorClass
                                            ); ?>"
                                                 style="width: <?php echo $presenceRate; ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-3">
                                        <a href="?action=view&element=etudiants&id=<?php echo $etudiant[
                                            "rowid"
                                        ]; ?>" 
                                           class="text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="?action=edit&element=etudiants&id=<?php echo $etudiant[
                                            "rowid"
                                        ]; ?>" 
                                           class="text-indigo-600 hover:text-indigo-900 transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete(<?php echo $etudiant[
                                            "rowid"
                                        ]; ?>)" 
                                                class="text-red-600 hover:text-red-900 transition-colors duration-200">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-white px-6 py-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-700">
                        Affichage de <span class="font-medium"><?php echo $pagination[
                            "start"
                        ]; ?></span> à 
                        <span class="font-medium"><?php echo $pagination[
                            "end"
                        ]; ?></span> sur 
                        <span class="font-medium"><?php echo $pagination[
                            "totalEtudiants"
                        ]; ?></span> étudiants
                    </p>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <?php if ($pagination["current"] > 1): ?>
                            <a href="?action=index&element=etudiants&page=<?php echo $pagination[
                                "current"
                            ] - 1; ?>&search=<?php echo urlencode(
    $search
); ?>&diploma=<?php echo urlencode($filterDiploma); ?>&td=<?php echo urlencode(
    $filterTD
); ?>&tp=<?php echo urlencode($filterTP); ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $pagination["current"] - 2);
                        $end = min(
                            $pagination["total"],
                            $pagination["current"] + 2
                        );

                        if ($start > 1) {
                            echo '<span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>';
                        }

                        for ($i = $start; $i <= $end; $i++): ?>
                            <a href="?action=index&element=etudiants&page=<?php echo $i; ?>&search=<?php echo urlencode(
    $search
); ?>&diploma=<?php echo urlencode($filterDiploma); ?>&td=<?php echo urlencode(
    $filterTD
); ?>&tp=<?php echo urlencode($filterTP); ?>" 
                               class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i ===
                               $pagination["current"]
                                   ? "text-blue-600 bg-blue-50 border-blue-500 z-10"
                                   : "text-gray-700 hover:bg-gray-50"; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor;
                        ?>

                        <?php if ($end < $pagination["total"]): ?>
                            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">...</span>
                        <?php endif; ?>

                        <?php if (
                            $pagination["current"] < $pagination["total"]
                        ): ?>
                            <a href="?action=index&element=etudiants&page=<?php echo $pagination[
                                "current"
                            ] + 1; ?>&search=<?php echo urlencode(
    $search
); ?>&diploma=<?php echo urlencode($filterDiploma); ?>&td=<?php echo urlencode(
    $filterTD
); ?>&tp=<?php echo urlencode($filterTP); ?>" 
                               class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
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