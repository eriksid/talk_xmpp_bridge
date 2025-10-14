<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor');

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'indentation_type' => true,
    ])
    ->setFinder($finder)
    ->setIndent("\t")
    ->setLineEnding("\n");