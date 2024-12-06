<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import/Export Étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Import/Export Étudiants</h1>
                <p class="text-gray-500 mt-1">Gérez vos données étudiants en masse</p>
            </div>
            <a href="?action=list&element=etudiants" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center mb-2">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <h3 class="text-red-800 font-medium">Des erreurs sont survenues</h3>
                </div>
                <ul class="text-red-700 ml-6 list-disc">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <?php foreach ($success as $message): ?>
                        <p class="text-green-800"><?= htmlspecialchars(
                            $message
                        ) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-file-import text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold ml-4">Importer des étudiants</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Format requis :</h3>
                        <ul class="list-disc ml-5 text-sm text-gray-600">
                            <li>Fichier CSV avec séparateur virgule (,)</li>
                            <li>Encodage UTF-8</li>
                            <li>Colonnes requises : numetu, firstname, lastname, diploma, year</li>
                            <li>Colonnes optionnelles : birthday, td, tp, address, zipcode, town</li>
                        </ul>
                    </div>

                    <form action="?action=import&element=etudiants" method="POST" enctype="multipart/form-data"
                          class="space-y-4">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                            <input type="file" name="csv_file" id="csv_file" accept=".csv" 
                                   class="hidden" onchange="updateFileName(this)">
                            <label for="csv_file" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                <p class="text-gray-600" id="fileName">
                                    Cliquez ou glissez un fichier CSV ici
                                </p>
                            </label>
                        </div>

                        <button type="submit" 
                                class="w-full py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                            <i class="fas fa-upload mr-2"></i>
                            Importer
                        </button>
                    </form>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-file-export text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold ml-4">Exporter les étudiants</h2>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-medium text-gray-900 mb-2">Options d'export :</h3>
                        <form action="?action=export&element=etudiants" method="GET">
                            <input type="hidden" name="action" value="export">
                            <input type="hidden" name="element" value="etudiants">
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="include_presence" value="1" 
                                               class="rounded text-blue-600">
                                        <span class="ml-2 text-sm text-gray-600">
                                            Inclure les statistiques de présence
                                        </span>
                                    </label>
                                </div>
                                
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="active_only" value="1" 
                                               class="rounded text-blue-600">
                                        <span class="ml-2 text-sm text-gray-600">
                                            Uniquement les étudiants actifs
                                        </span>
                                    </label>
                                </div>

                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Format de date</label>
                                    <select name="date_format" class="w-full rounded-lg border-gray-300">
                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" 
                                    class="w-full mt-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-download mr-2"></i>
                                Exporter en CSV
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>>
        </div>
    </div>

    <script>
    function updateFileName(input) {
        const fileName = input.files[0]?.name ?? 'Cliquez ou glissez un fichier CSV ici';
        document.getElementById('fileName').textContent = fileName;
    }

    const dropZone = document.querySelector('.border-dashed');
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    }

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        document.getElementById('csv_file').files = files;
        updateFileName(document.getElementById('csv_file'));
    }
    </script>
</body>
</html>