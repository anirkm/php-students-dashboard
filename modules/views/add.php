<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Module</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-b from-gray-50 to-white min-h-screen">
    <div class="max-w-2xl mx-auto px-4 py-8">
        <a href="?action=list&element=modules" 
           class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6 transition-colors duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h1 class="text-xl font-semibold text-gray-900">
                    <i class="fas fa-plus-circle mr-2 text-blue-500"></i>
                    Ajouter un Module
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
                <?php endif; ?>

                <form method="POST" action="" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-1 text-gray-400"></i>
                                Numéro de Module
                            </label>
                            <input type="text" name="num_module" 
                                   value="<?= htmlspecialchars(
                                       $_POST["num_module"] ?? ""
                                   ) ?>" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-folder mr-1 text-gray-400"></i>
                                Nom
                            </label>
                            <input type="text" name="name" 
                                   value="<?= htmlspecialchars(
                                       $_POST["name"] ?? ""
                                   ) ?>" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-balance-scale mr-1 text-gray-400"></i>
                                Coefficient
                            </label>
                            <input type="number" step="0.01" name="coefficient" 
                                   value="<?= htmlspecialchars(
                                       $_POST["coefficient"] ?? ""
                                   ) ?>" 
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                   required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1 text-gray-400"></i>
                            Description
                        </label>
                        <textarea name="description" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                  rows="4"><?= htmlspecialchars(
                                      $_POST["description"] ?? ""
                                  ) ?></textarea>
                    </div>

                    <div class="flex justify-end space-x-4 pt-4">
                        <button type="submit" 
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>