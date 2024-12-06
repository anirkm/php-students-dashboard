<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Suppression</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto mt-8 max-w-4xl p-4">
        <div class="flex justify-center">
            <div class="w-full">

                <?php if ($success): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg">
                        <div class="flex items-start">
                            <div>
                                <h4 class="text-lg font-bold">Cours supprimé avec succès!</h4>
                                <p class="mt-2">Le cours a été supprimé de la base de données.</p>
                                <hr class="my-2">
                                <p class="mt-1">
                                    <a href="?action=list&element=cours" class="text-green-800 underline">
                                        Retourner à la liste des cours
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (!empty($errors)): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6">
                            <ul class="list-disc ml-5">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo htmlspecialchars(
                                        $error
                                    ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="bg-white shadow-md rounded-lg p-6">
                        <div class="bg-red-500 text-white rounded-t-lg px-4 py-2">
                            <h4 class="text-lg font-bold">Confirmation de suppression</h4>
                        </div>
                        <div class="p-4">
                            <h5 class="text-lg font-semibold text-gray-800">Êtes-vous sûr de vouloir supprimer ce cours ?</h5>
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mt-3">
                                <p><i class="fas fa-exclamation-triangle"></i> Cette action est irréversible et supprimera également toutes les présences associées.</p>
                            </div>

                            <div class="bg-gray-50 border rounded-lg p-4 mt-4">
                                <h6 class="text-sm font-semibold text-gray-600 mb-2">Détails du cours</h6>
                                <ul class="text-gray-700 space-y-2">
                                    <li><strong>Matière :</strong> <?php echo htmlspecialchars(
                                        $cours["matiere_name"]
                                    ); ?></li>
                                    <li><strong>Enseignant :</strong> <?php echo htmlspecialchars(
                                        $cours["enseignant_name"]
                                    ); ?></li>
                                    <li><strong>Date :</strong> <?php echo date(
                                        "d/m/Y",
                                        strtotime($cours["date_cours"])
                                    ); ?></li>
                                    <li><strong>Heure :</strong> <?php echo date(
                                        "H:i",
                                        strtotime($cours["date_cours"])
                                    ); ?></li>
                                    <li><strong>Type :</strong> <?php echo htmlspecialchars(
                                        $cours["type_cours"]
                                    ); ?></li>
                                    <li><strong>Salle :</strong> <?php echo htmlspecialchars(
                                        $cours["salle"]
                                    ); ?></li>
                                    <li><strong>Statut :</strong> <?php echo htmlspecialchars(
                                        $cours["status"]
                                    ); ?></li>
                                </ul>
                            </div>

                            <form method="POST" class="mt-6">
                                <div class="flex flex-row space-x-2 items-center">
                                    <div class="grow">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600 focus:outline-none">
                                            <i class="fas fa-trash"></i> Confirmer la suppression
                                        </button>
                                    </div>
                                    <div class="space-x-2">
                                        <a href="?action=card&element=cours&id=<?php echo $coursId; ?>" 
                                           class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg shadow hover:bg-gray-300 focus:outline-none">
                                            Retour aux détails
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</body>
</html>
