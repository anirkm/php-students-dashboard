<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
$db = require dirname(__FILE__) . "/lib/mypdo.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD3 - Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <div class="flex-grow flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Bienvenue sur le portail
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Connectez-vous pour accéder à votre espace
                    (user: anir / password: anir) pour accéder à l'administration
                </p>
            </div>

            
            <form class="mt-8 space-y-6" action="check_login.php" method="post">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="uname" class="block text-sm font-medium text-gray-700">
                            Nom d'utilisateur
                        </label>
                        <input type="text" name="uname" id="uname" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                                      placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none 
                                      focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Votre identifiant">
                    </div>
                    <div>
                        <label for="psw" class="block text-sm font-medium text-gray-700">
                            Mot de passe
                        </label>
                        <input type="password" name="psw" id="psw" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 
                                      placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none 
                                      focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                               placeholder="Votre mot de passe">
                    </div>
                </div>

                <div>
                    <?php if (is_null($db)): ?>
                        <button type="submit" disabled 
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                       text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed">
                            Impossible de se connecter
                        </button>
                    <?php else: ?>
                        <button type="submit" name="connect"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent 
                                       text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 
                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <i class="fas fa-sign-in-alt"></i>
                            </span>
                            Se connecter
                        </button>
                    <?php endif; ?>
                </div>
            </form>

            
            <?php if (
                is_array($_SESSION["mesgs"]) &&
                is_array($_SESSION["mesgs"]["confirm"])
            ): ?>
                <?php foreach ($_SESSION["mesgs"]["confirm"] as $mesg): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700"><?= $mesg ?></p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="closebtn inline-flex text-green-400 rounded-md p-1.5 hover:bg-green-100">
                                        <span class="sr-only">Dismiss</span>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION["mesgs"]["confirm"]); ?>
            <?php endif; ?>

            <?php if (
                is_array($_SESSION["mesgs"]) &&
                is_array($_SESSION["mesgs"]["errors"])
            ): ?>
                <?php foreach ($_SESSION["mesgs"]["errors"] as $err): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700"><?= $err ?></p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="closebtn inline-flex text-red-400 rounded-md p-1.5 hover:bg-red-100">
                                        <span class="sr-only">Dismiss</span>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION["mesgs"]["errors"]); ?>
            <?php endif; ?>
        </div>
    </div>

    
    <footer class="bg-white text-gray-700 py-8 border-t border-gray-300 w-full">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-4">
                <h2 class="text-xl font-semibold mb-2 text-gray-800">
                    BUT Informatique
                </h2>
                <p class="text-gray-500 mb-4">
                    Logiciel de Gestion Départementale
                </p>

                <div class="flex justify-center space-x-6 mb-4">
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-snapchat text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-pinterest-p text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="hover:text-gray-800 transition-colors duration-200">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                </div>

                <p class="text-sm text-gray-500">
                    Développé par le Département Informatique
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Made by Karami Anir
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.querySelectorAll('.closebtn').forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('[class*="border-l-4"]');
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 600);
            });
        });
    </script>
</body>
</html>