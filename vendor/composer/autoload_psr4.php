<?php

$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);

return [
    "Symfony\\Polyfill\\Php80\\" => [$vendorDir . "/symfony/polyfill-php80"],
    "Symfony\\Polyfill\\Mbstring\\" => [
        $vendorDir . "/symfony/polyfill-mbstring",
    ],
    "Symfony\\Polyfill\\Ctype\\" => [$vendorDir . "/symfony/polyfill-ctype"],
    "PhpOption\\" => [$vendorDir . "/phpoption/phpoption/src/PhpOption"],
    "GrahamCampbell\\ResultType\\" => [
        $vendorDir . "/graham-campbell/result-type/src",
    ],
    "Dotenv\\" => [$vendorDir . "/vlucas/phpdotenv/src"],
];
