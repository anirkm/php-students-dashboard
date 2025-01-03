<?php

namespace Composer\Autoload;

class ComposerStaticInite875ae8441d070d7dda5f4b47a2117aa
{
    public static $files = [
        "320cde22f66dd4f5d3fd621d3e88b98f" =>
            __DIR__ . "/.." . "/symfony/polyfill-ctype/bootstrap.php",
        "0e6d7bf4a5811bfa5cf40c5ccd6fae6a" =>
            __DIR__ . "/.." . "/symfony/polyfill-mbstring/bootstrap.php",
        "a4a119a56e50fbb293281d9a48007e0e" =>
            __DIR__ . "/.." . "/symfony/polyfill-php80/bootstrap.php",
    ];

    public static $prefixLengthsPsr4 = [
        "S" => [
            "Symfony\\Polyfill\\Php80\\" => 23,
            "Symfony\\Polyfill\\Mbstring\\" => 26,
            "Symfony\\Polyfill\\Ctype\\" => 23,
        ],
        "P" => [
            "PhpOption\\" => 10,
        ],
        "G" => [
            "GrahamCampbell\\ResultType\\" => 26,
        ],
        "D" => [
            "Dotenv\\" => 7,
        ],
    ];

    public static $prefixDirsPsr4 = [
        "Symfony\\Polyfill\\Php80\\" => [
            0 => __DIR__ . "/.." . "/symfony/polyfill-php80",
        ],
        "Symfony\\Polyfill\\Mbstring\\" => [
            0 => __DIR__ . "/.." . "/symfony/polyfill-mbstring",
        ],
        "Symfony\\Polyfill\\Ctype\\" => [
            0 => __DIR__ . "/.." . "/symfony/polyfill-ctype",
        ],
        "PhpOption\\" => [
            0 => __DIR__ . "/.." . "/phpoption/phpoption/src/PhpOption",
        ],
        "GrahamCampbell\\ResultType\\" => [
            0 => __DIR__ . "/.." . "/graham-campbell/result-type/src",
        ],
        "Dotenv\\" => [
            0 => __DIR__ . "/.." . "/vlucas/phpdotenv/src",
        ],
    ];

    public static $classMap = [
        "Attribute" =>
            __DIR__ .
            "/.." .
            "/symfony/polyfill-php80/Resources/stubs/Attribute.php",
        "Composer\\InstalledVersions" =>
            __DIR__ . "/.." . "/composer/InstalledVersions.php",
        "PhpToken" =>
            __DIR__ .
            "/.." .
            "/symfony/polyfill-php80/Resources/stubs/PhpToken.php",
        "Stringable" =>
            __DIR__ .
            "/.." .
            "/symfony/polyfill-php80/Resources/stubs/Stringable.php",
        "UnhandledMatchError" =>
            __DIR__ .
            "/.." .
            "/symfony/polyfill-php80/Resources/stubs/UnhandledMatchError.php",
        "ValueError" =>
            __DIR__ .
            "/.." .
            "/symfony/polyfill-php80/Resources/stubs/ValueError.php",
    ];

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(
            function () use ($loader) {
                $loader->prefixLengthsPsr4 =
                    ComposerStaticInite875ae8441d070d7dda5f4b47a2117aa::$prefixLengthsPsr4;
                $loader->prefixDirsPsr4 =
                    ComposerStaticInite875ae8441d070d7dda5f4b47a2117aa::$prefixDirsPsr4;
                $loader->classMap =
                    ComposerStaticInite875ae8441d070d7dda5f4b47a2117aa::$classMap;
            },
            null,
            ClassLoader::class
        );
    }
}
