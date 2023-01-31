<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        '@PHP80Migration:risky' => true,
        'php_unit_construct' => true,
        'php_unit_strict' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;