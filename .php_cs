<?php

declare(strict_types=1);

if (!\file_exists(__DIR__.'/src')) {
    exit(0);
}

return PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PSR2' => true,
        'php_unit_dedicate_assert' => ['target' => '5.6'],
        'array_syntax' => ['syntax' => 'short'],
        'fopen_flags' => false,
        'protected_to_private' => false,
        'combine_nested_dirname' => true,
        'ordered_imports' => true,
        'declare_strict_types' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced']
    ])
    ->setRiskyAllowed(true)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/src')
            ->append([__FILE__])
            ->notPath('#/Fixtures/#')
            ->exclude([
                'Symfony/Bridge/PhpUnit/Tests/DeprecationErrorHandler/',
            ])
            // Support for older PHPunit version
            ->notPath('Symfony/Bridge/PhpUnit/SymfonyTestsListener.php')
            ->notPath('#Symfony/Bridge/PhpUnit/.*Mock\.php#')
            ->notPath('#Symfony/Bridge/PhpUnit/.*Legacy#')
            // file content autogenerated by `var_export`
            ->notPath('Symfony/Component/Translation/Tests/fixtures/resources.php')
            // test template
            ->notPath('Symfony/Bundle/FrameworkBundle/Tests/Templating/Helper/Resources/Custom/_name_entry_label.html.php')
            // explicit trigger_error tests
            ->notPath('Symfony/Component/ErrorHandler/Tests/DebugClassLoaderTest.php')
    )
;