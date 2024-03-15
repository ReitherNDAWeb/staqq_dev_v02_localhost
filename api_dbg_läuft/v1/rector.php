<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/parts',
        __DIR__ . '/push',
<<<<<<< HEAD
        __DIR__ . '/tests',
    ])
    // uncomment to reach your current PHP version
    ->withPhpSets(php82: true)
=======
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
>>>>>>> 774de6a2a3f06dcfd52ab55cbef2f9fb8a241e6f
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ]);
