<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des présences</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-900">Gestion des présences</h1>
            <a href="?action=card&element=cours&id=<?php echo $coursId; ?>" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-full hover:bg-gray-200 transition-colors duration-200">
                <i class="fas fa-chevron-left mr-2"></i>
                Retour au cours
            </a>
        </div>

        
        <div class="bg-white rounded-2xl shadow-sm mb-8 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-900">Informations du cours</h2>
            </div>
            <div class="px-6 py-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500">Matière</span>
                            <span class="font-medium"><?php echo htmlspecialchars(
                                $cours["matiere_name"]
                            ); ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500">Date</span>
                            <span class="font-medium"><?php echo date(
                                "d/m/Y",
                                strtotime($cours["date_cours"])
                            ); ?></span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500">Type</span>
                            <span class="font-medium"><?php echo htmlspecialchars(
                                $cours["type_cours"]
                            ); ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500">Salle</span>
                            <span class="font-medium"><?php echo htmlspecialchars(
                                $cours["salle"]
                            ); ?></span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500">Enseignant</span>
                            <span class="font-medium"><?php echo htmlspecialchars(
                                $cours["enseignant_name"]
                            ); ?></span>
                        </div>
                        <?php if ($cours["type_cours"] == "TD"): ?>
                            <div class="flex items-center">
                                <span class="w-24 text-gray-500">Groupe TD</span>
                                <span class="font-medium"><?php echo htmlspecialchars(
                                    $cours["groupe_td"]
                                ); ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($cours["type_cours"] == "TP"): ?>
                            <div class="flex items-center">
                                <span class="w-24 text-gray-500">Groupe TP</span>
                                <span class="font-medium"><?php echo htmlspecialchars(
                                    $cours["groupe_tp"]
                                ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if (!empty($success)): ?>
            <div class="mb-6 rounded-lg bg-green-50 px-4 py-3 border border-green-100">
                <?php foreach ($success as $message): ?>
                    <p class="text-green-700"><?php echo $message; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="mb-6 rounded-lg bg-red-50 px-4 py-3 border border-red-100">
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-700"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        
        <form method="POST">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-900">Liste des étudiants</h2>
                    <div class="flex space-x-3">
                        <button type="button" 
                                onclick="markAll('présent')"
                                class="px-4 py-2 bg-green-50 text-green-700 rounded-full hover:bg-green-100 transition-colors duration-200">
                            Tous présents
                        </button>
                        <button type="button" 
                                onclick="markAll('absent')"
                                class="px-4 py-2 bg-red-50 text-red-700 rounded-full hover:bg-red-100 transition-colors duration-200">
                            Tous absents
                        </button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Étudiant</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Statut</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Commentaire</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php foreach ($etudiants as $etudiant): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            <?php echo htmlspecialchars(
                                                $etudiant["lastname"] .
                                                    " " .
                                                    $etudiant["firstname"]
                                            ); ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?php echo htmlspecialchars(
                                                $etudiant["numetu"]
                                            ); ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php $current_status =
                                            $presences_by_student[
                                                $etudiant["rowid"]
                                            ]["status"] ?? "absent"; ?>
                                        <div class="flex space-x-4">
                                            <label class="inline-flex items-center">
                                                <input type="radio" 
                                                       name="presence[<?php echo $etudiant[
                                                           "rowid"
                                                       ]; ?>][status]" 
                                                       value="présent"
                                                       <?php echo $current_status ===
                                                       "présent"
                                                           ? "checked"
                                                           : ""; ?>
                                                       class="form-radio text-green-600">
                                                <span class="ml-2 text-sm text-green-700">Présent</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" 
                                                       name="presence[<?php echo $etudiant[
                                                           "rowid"
                                                       ]; ?>][status]" 
                                                       value="absent"
                                                       <?php echo $current_status ===
                                                       "absent"
                                                           ? "checked"
                                                           : ""; ?>
                                                       class="form-radio text-red-600">
                                                <span class="ml-2 text-sm text-red-700">Absent</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" 
                                                       name="presence[<?php echo $etudiant[
                                                           "rowid"
                                                       ]; ?>][status]" 
                                                       value="retard"
                                                       <?php echo $current_status ===
                                                       "retard"
                                                           ? "checked"
                                                           : ""; ?>
                                                       class="form-radio text-yellow-600">
                                                <span class="ml-2 text-sm text-yellow-700">Retard</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <input type="text" 
                                               name="presence[<?php echo $etudiant[
                                                   "rowid"
                                               ]; ?>][commentaire]" 
                                               class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                               value="<?php echo htmlspecialchars(
                                                   $presences_by_student[
                                                       $etudiant["rowid"]
                                                   ]["commentaire"] ?? ""
                                               ); ?>" 
                                               placeholder="Ajouter un commentaire...">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex justify-end">
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les présences
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function markAll(status) {
            document.querySelectorAll(`input[value="${status}"]`).forEach(input => {
                input.checked = true;
            });
        }
    </script>
</body>
</html>