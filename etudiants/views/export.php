<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exporter les Étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Exporter les Étudiants</h1>
                <p class="text-gray-500 mt-1">Personnalisez et téléchargez vos données</p>
            </div>
            <a href="?action=list&element=etudiants" 
               class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        <div class="mt-8 bg-blue-50 rounded-xl p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-2">
                <i class="fas fa-info-circle mr-2"></i>
                Informations sur l'export
            </h3>
            <ul class="list-disc list-inside text-blue-800 space-y-1">
                <li>Les fichiers exportés sont encodés en UTF-8</li>
                <li>Les dates sont formatées selon le format choisi</li>
                <li>Les données sensibles sont automatiquement anonymisées</li>
                <li>L'export peut prendre quelques minutes pour les grands volumes de données</li>
            </ul>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm">
            
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px" aria-label="Tabs">
                    <button class="border-b-2 border-blue-500 py-4 px-6 text-blue-600 font-medium text-sm">
                        Export CSV
                    </button>
                </nav>
            </div>

            
            <form action="?action=export&element=etudiants" method="POST" class="p-6">
                
                <div class="space-y-6">
                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Colonnes à exporter</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="numetu" checked
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Numéro étudiant</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="firstname" checked
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Prénom</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="lastname" checked
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Nom</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="birthday"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Date de naissance</span>
                                </label>
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="diploma" checked
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Diplôme</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="year" checked
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Année</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="td"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Groupe TD</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="tp"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Groupe TP</span>
                                </label>
                            </div>
                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="address"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Adresse</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="zipcode"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Code postal</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="columns[]" value="town"
                                           class="rounded text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-gray-700">Ville</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Options supplémentaires</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Format de date
                                    </label>
                                    <select name="date_format" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                        <option value="Y-m-d">YYYY-MM-DD</option>
                                        <option value="d/m/Y">DD/MM/YYYY</option>
                                        <option value="d-m-Y">DD-MM-YYYY</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Séparateur CSV
                                    </label>
                                    <select name="delimiter" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                        <option value=",">Virgule (,)</option>
                                        <option value=";">Point-virgule (;)</option>
                                        <option value="\t">Tabulation</option>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Filtrer par diplôme
                                    </label>
                                    <select name="filter_diploma" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                        <option value="">Tous les diplômes</option>
                                        <?php foreach (
                                            Etudiant::$diplomas
                                            as $diploma
                                        ): ?>
                                            <option value="<?= htmlspecialchars(
                                                $diploma
                                            ) ?>">
                                                <?= htmlspecialchars(
                                                    $diploma
                                                ) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Année d'étude
                                    </label>
                                    <select name="filter_year" 
                                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md">
                                        <option value="">Toutes les années</option>
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?= $i ?>">Année <?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Données additionnelles</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="include_presence" value="1"
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">
                                    Inclure les statistiques de présence
                                </span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="include_grades" value="1"
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-gray-700">
                                    Inclure les moyennes par matière
                                </span>
                            </label>
                        </div>
                    </div>
                </div>

                
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="?action=list&element=etudiants" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </a>
                <input type="hidden" name="export_submit" value="1">

                
                <button type="submit" name="export_submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i>
                    Exporter
                </button>
                </div>
            </form>
        </div>

        



    </div>

    <script>
    function toggleAllColumns(checked) {
        document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
            checkbox.checked = checked;
        });
    }

    document.querySelector('form').addEventListener('submit', function(e) {
        const checkedColumns = document.querySelectorAll('input[name="columns[]"]:checked');
        if (checkedColumns.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins une colonne à exporter.');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
            checkbox.checked = true;
        });
    });

    document.querySelector('form').addEventListener('submit', function(e) {
        const checkedColumns = document.querySelectorAll('input[name="columns[]"]:checked');
        if (checkedColumns.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins une colonne à exporter.');
            return false;
        }
        
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Export en cours...';
        
        return true;
    });

    function toggleAllColumns(checked) {
        document.querySelectorAll('input[name="columns[]"]').forEach(checkbox => {
            checkbox.checked = checked;
        });
    }
    </script>
</body>
</html>