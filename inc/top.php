
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center">
                <div class="relative group">
                    <button class="flex items-center space-x-3 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <img class="h-8 w-8 rounded-full" 
                             src="https://ui-avatars.com/api/?name=<?= urlencode(
                                 $_SESSION["user"]["firstname"] .
                                     " " .
                                     $_SESSION["user"]["lastname"]
                             ) ?>&background=random" 
                             alt="User avatar">
                        <span class="font-medium"><?= $_SESSION[
                            "login"
                        ] ?></span>
                        <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                    </button>
                    <div class="absolute left-0 w-48 pointer-events-none">
                        <div class="rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-auto">
                            <div class="py-1">
                                <a href="index.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-home mr-2"></i>Accueil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user mr-2"></i><?= $_SESSION[
                                        "user"
                                    ]["firstname"] .
                                        " " .
                                        $_SESSION["user"]["lastname"] ?>
                                </a>
                                <hr class="my-1">
                                <a href="delog.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Se déconnecter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="flex items-center space-x-4">
                <?php
                $list_menus = [
                    "etudiants" => [
                        "name" => "Étudiants",
                        "icon" => "fa-users",
                    ],
                    "enseignants" => [
                        "name" => "Enseignants",
                        "icon" => "fa-chalkboard-teacher",
                    ],
                    "cours" => ["name" => "Cours", "icon" => "fa-calendar"],
                    "modules" => ["name" => "Modules", "icon" => "fa-folder"],
                    "matieres" => ["name" => "Matières", "icon" => "fa-book"],
                ];

                foreach ($list_menus as $key => $menu): ?>
                    <div class="relative group">
                        <a href="index.php?element=<?= $key ?>" class="flex items-center space-x-2 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        <div class="flex items-center space-x-2 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                            <i class="fas <?= $menu["icon"] ?>"></i>
                            <span><?= $menu["name"] ?></span>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </div>
                        </a>
                        <div class="absolute left-0 w-48 mt-1 pointer-events-none">
                            <div class="rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 pointer-events-auto">
                                <div class="py-1">
                                    <a href="index.php?element=<?= $key ?>&action=list" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-list w-5"></i>
                                        <span>Liste</span>
                                    </a>
                                    <a href="index.php?element=<?= $key ?>&action=add" 
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-plus w-5"></i>
                                        <span>Nouveau</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
                ?>
            </div>
        </div>
    </div>
</nav>

<div class="sm:hidden">
    <button type="button" class="text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600" aria-label="toggle menu">
        <svg viewBox="0 0 24 24" class="h-6 w-6 fill-current">
            <path fill-rule="evenodd" d="M4 5h16v2H4V5zm0 6h16v2H4v-2zm0 6h16v2H4v-2z"></path>
        </svg>
    </button>
</div>