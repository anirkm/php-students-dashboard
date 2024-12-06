<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        
        <nav class="border-b border-gray-200 bg-white">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center">
                        <h1 class="text-lg font-medium text-gray-900">Ajouter un Enseignant</h1>
                    </div>
                    <div class="flex items-center">
                        <a href="?action=list&element=enseignants" 
                           class="text-sm font-medium text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            ← Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-10">
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                    
                    <?php if (!empty($errors)): ?>
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="rounded-md bg-red-50 p-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Des erreurs ont été détectées</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc space-y-1 pl-5">
                                                <?php foreach (
                                                    $errors
                                                    as $error
                                                ): ?>
                                                    <li><?php echo htmlspecialchars(
                                                        $error
                                                    ); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <form method="POST" action="" class="divide-y divide-gray-200">
                        
                        <div class="px-6 py-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Informations Personnelles</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Veuillez remplir les informations de l'enseignant.</p>
                            
                            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Numéro d'Enseignant
                                    </label>
                                    <input type="text" name="numens" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["numens"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Date de Naissance
                                    </label>
                                    <input type="date" name="birthday" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["birthday"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Prénom
                                    </label>
                                    <input type="text" name="firstname" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["firstname"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Nom
                                    </label>
                                    <input type="text" name="lastname" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["lastname"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Adresse
                                    </label>
                                    <textarea name="address" 
                                              class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                              required rows="3"><?php echo htmlspecialchars(
                                                  $_POST["address"] ?? ""
                                              ); ?></textarea>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Code Postal
                                    </label>
                                    <input type="text" name="zipcode" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["zipcode"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Ville
                                    </label>
                                    <input type="text" name="town" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["town"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>
                            </div>
                        </div>

                        
                        <div class="px-6 py-6">
                            <h2 class="text-base font-semibold leading-7 text-gray-900">Informations de Connexion</h2>
                            <p class="mt-1 text-sm leading-6 text-gray-500">Créez les identifiants de connexion pour l'enseignant.</p>

                            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Nom d'utilisateur
                                    </label>
                                    <input type="text" name="username" 
                                           value="<?php echo htmlspecialchars(
                                               $_POST["username"] ?? ""
                                           ); ?>" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>

                                <div class="col-span-1">
                                    <label class="block text-sm font-medium leading-6 text-gray-900">
                                        Mot de passe
                                    </label>
                                    <input type="password" name="password" 
                                           class="mt-2 block w-full rounded-md border-0 px-3 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-500 sm:text-sm sm:leading-6"
                                           required>
                                </div>
                            </div>
                        </div>

                        
                        <div class="px-6 py-4 flex items-center justify-end gap-x-4 bg-gray-50 rounded-b-xl">
                            <button type="submit" 
                                    class="inline-flex justify-center rounded-md bg-blue-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-colors duration-200">
                                Ajouter l'enseignant
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>