<div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden">
    <div class="p-6">
        <div class="flex items-center mb-4">
            <img class="h-12 w-12 rounded-full object-cover" 
                 src="https://ui-avatars.com/api/?name=<?= urlencode(
                     $etudiant->firstname . " " . $etudiant->lastname
                 ) ?>&background=random" 
                 alt="Avatar">
            <div class="ml-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars(
                        $etudiant->firstname . " " . $etudiant->lastname
                    ) ?>
                </h3>
                <p class="text-sm text-gray-500">
                    <?= htmlspecialchars($etudiant->numetu) ?>
                </p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex items-center">
                <i class="fas fa-graduation-cap w-5 text-gray-400"></i>
                <span class="ml-2 text-sm text-gray-600">
                    <?= htmlspecialchars(
                        $etudiant->diploma
                    ) ?> - Année <?= htmlspecialchars($etudiant->year) ?>
                </span>
            </div>

            <div class="flex items-center">
                <i class="fas fa-users w-5 text-gray-400"></i>
                <span class="ml-2 text-sm text-gray-600">
                    TD: <?= htmlspecialchars(
                        $etudiant->td
                    ) ?> | TP: <?= htmlspecialchars($etudiant->tp) ?>
                </span>
            </div>

            <div class="flex items-center">
                <i class="fas fa-map-marker-alt w-5 text-gray-400"></i>
                <span class="ml-2 text-sm text-gray-600">
                    <?= htmlspecialchars($etudiant->town) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
        <div class="flex justify-end space-x-3">
            <a href="?action=view&element=etudiants&id=<?= $etudiant->rowid ?>" 
               class="inline-flex items-center px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-eye mr-2"></i>
                Voir
            </a>
            <a href="?action=edit&element=etudiants&id=<?= $etudiant->rowid ?>" 
               class="inline-flex items-center px-3 py-1.5 text-sm bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-edit mr-2"></i>
                Éditer
            </a>
            <button type="button" 
                    onclick="confirmDelete(<?= $etudiant->rowid ?>)"
                    class="inline-flex items-center px-3 py-1.5 text-sm bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors duration-200">
                <i class="fas fa-trash mr-2"></i>
                Supprimer
            </button>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
        window.location.href = `?action=delete&element=etudiants&id=${id}`;
    
}
</script>