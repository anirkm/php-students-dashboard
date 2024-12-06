<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer une Matière</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-2xl mx-auto px-4 py-8">
        
        <a href="?action=list&element=matieres" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h1 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-trash mr-2 text-red-500"></i>
                    Supprimer une Matière
                </h1>
            </div>

            
            <div class="p-6">
                <?php if (!empty($errors)): ?>
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r-md">
                        <?php foreach ($errors as $error): ?>
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="space-y-6">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <h3 class="font-semibold text-lg mb-4">
                                <?= htmlspecialchars($matiere["name"]) ?>
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">
                                        <i class="fas fa-hashtag mr-2"></i>
                                        <span class="font-medium">Numéro :</span> 
                                        <?= htmlspecialchars(
                                            $matiere["num_matiere"]
                                        ) ?>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600">
                                        <i class="fas fa-folder mr-2"></i>
                                        <span class="font-medium">Module :</span> 
                                        <?= htmlspecialchars(
                                            $matiere["module_name"]
                                        ) ?>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-gray-600">
                                        <i class="fas fa-balance-scale mr-2"></i>
                                        <span class="font-medium">Coefficient :</span> 
                                        <?= htmlspecialchars(
                                            $matiere["coefficient"]
                                        ) ?>
                                    </p>
                                </div>
                            </div>
                            <?php if (!empty($matiere["description"])): ?>
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-gray-600">
                                        <i class="fas fa-align-left mr-2"></i>
                                        <span class="font-medium">Description :</span><br>
                                        <span class="block mt-2 pl-6">
                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $matiere["description"]
                                                )
                                            ) ?>
                                        </span>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="p-4 bg-yellow-50 text-yellow-800 rounded-xl">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <p class="text-sm">
                                    Attention : Cette action est irréversible et supprimera définitivement 
                                    la matière du système.
                                </p>
                            </div>
                        </div>

                        <form method="POST" action="" class="flex justify-end space-x-4 pt-4">
                            <a href="?action=list&element=matieres" 
                               class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200"
                                    onclick="return confirm('Êtes-vous vraiment sûr de vouloir supprimer cette matière ?');">
                                <i class="fas fa-trash mr-2"></i>
                                Confirmer la suppression
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>