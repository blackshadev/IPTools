<?php

declare(strict_types=1);

use PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff;
use PhpCsFixer\Fixer\Alias\MbStrFunctionsFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(DeclareStrictTypesFixer::class);

    $services->set(StrictComparisonFixer::class);

    $services->set(StrictParamFixer::class);

    $services->set(ReturnTypeDeclarationFixer::class);

    $services->set(AssignmentInConditionSniff::class);

    $services->set(MbStrFunctionsFixer::class);

    $services->set(OrderedClassElementsFixer::class);

    $services->set(ClassAttributesSeparationFixer::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::SETS, [SetList::CLEAN_CODE, SetList::PSR_12]);

    $parameters->set(Option::PATHS, [__DIR__ . '/src', __DIR__ . '/tests', __FILE__ ]);
};
