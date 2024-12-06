<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un Enseignant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full">
    <div class="min-h-full">
        
        <nav class="border-b border-gray-200 bg-white">
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex items-center">
                        <h1 class="text-lg font-medium text-gray-900">Supprimer un Enseignant</h1>
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
            <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8 py-10">
                
                <?php if (!empty($errors)): ?>
                    <div class="mb-6">
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

                
                <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
                    
                    <div class="px-6 py-8">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                        </div>
                        <div class="mt-6 text-center">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Confirmation de suppression</h3>
                            <p class="mt-2 text-sm text-gray-500">
                                Vous êtes sur le point de supprimer définitivement l'enseignant
                                <span class="font-medium text-gray-900">
                                    <?= htmlspecialchars(
                                        ($enseignant->firstname ?? "") .
                                            " " .
                                            ($enseignant->lastname ?? ""),
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </span>
                            </p>
                            <p class="mt-1 text-sm text-gray-500">
                                Cette action est irréversible.
                            </p>
                        </div>
                    </div>

                    
                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-x-4">
                        <a href="?action=list&element=enseignants" 
                           class="inline-flex justify-center rounded-md bg-white px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors duration-200">
                            Annuler
                        </a>
                        <form action="?action=delete&element=enseignants&id=<?= htmlspecialchars(
                            $enseignant->rowid ?? "",
                            ENT_QUOTES,
                            "UTF-8"
                        ) ?>" 
                              method="POST" 
                              class="inline-flex">
                            <button type="submit" 
                                    class="inline-flex justify-center rounded-md bg-red-600 px-6 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors duration-200">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>