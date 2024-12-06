</div>

<?php
if ($db) {
    $db = null;
}
if (is_array($_SESSION["mesgs"]) && is_array($_SESSION["mesgs"]["confirm"])) {
    foreach ($_SESSION["mesgs"]["confirm"] as $mesg) { ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="closebtn absolute top-0 right-0 px-4 py-3 cursor-pointer">&times;</span>
            <?= $mesg ?>
        </div>
    <?php }
    unset($_SESSION["mesgs"]["confirm"]);
}

if (is_array($_SESSION["mesgs"]) && is_array($_SESSION["mesgs"]["errors"])) {
    foreach ($_SESSION["mesgs"]["errors"] as $err) { ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="closebtn absolute top-0 right-0 px-4 py-3 cursor-pointer">&times;</span>
            <?= $err ?>
        </div>
<?php }
    unset($_SESSION["mesgs"]["errors"]);
}
?>

<script>
    var close = document.getElementsByClassName("closebtn");
    var i;

    for (i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
                div.style.display = "none";
            }, 600);
        }
    }
</script>

<footer class="bg-white text-gray-700 py-8 border-t border-gray-300 w-full mt-auto">
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

</body>
</html>