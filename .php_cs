<?php

declare(strict_types=1);

if (!\file_exists(__DIR__.'/src')) {
    exit(0);
}

$header = <<<'EOF'
This file is a part of logrotate package.

Copyright (c) %s Christin Gruber <c.gruber@touchdesign.de>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PSR2' => true,
        'header_comment' => ['header' => sprintf($header, date('Y'))],
        'php_unit_dedicate_assert' => ['target' => '5.6'],
        'array_syntax' => ['syntax' => 'short'],
        'fopen_flags' => false,
        'protected_to_private' => false,
        'combine_nested_dirname' => true,
        'ordered_imports' => true,
        'declare_strict_types' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced'],
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([__DIR__.'/src', __DIR__.'/tests', __DIR__.'/examples', __DIR__.'/bin'])
            ->notPath('#/Fixtures/#')
    );
