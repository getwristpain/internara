<?php

namespace App\Services\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Helpers\Debugger;

/**
 * Service for generating logic utility class with dynamic namespace and optional base class.
 */
class MakeLogicService
{
    /**
     * ------------------------------------------------------------------------
     * Reserved Class Names
     * ------------------------------------------------------------------------
     * Prevent usage of PHP and Laravel core class names.
     *
     * @var array<string>
     */
    protected array $reservedClassNames = [
        'Array', 'array', 'bool', 'Class', 'double', 'Error', 'Exception', 'false', 'float', 'Function',
        'int', 'null', 'Number', 'Object', 'object', 'stdClass', 'String', 'string', 'Throwable', 'true',
    ];

    /**
     * Generate a logic class file with given name and optional extends.
     *
     * @param string $name
     * @param string|null $extends
     * @return string
     */
    public function make(string $name, ?string $extends = null): string
    {
        [$namespace, $filePath, $className] = $this->getClassDetails($name);

        if ($this->isReservedClassName($className)) {
            Debugger::handle("The class name '$className' is reserved and cannot be used.", ['name' => $name])->throw();
        }

        $extends = $this->validateExtendsClass($extends);

        if ($this->classExists($filePath)) {
            Debugger::handle("Class already exists at: $filePath", ['file' => $filePath])->throw();
        }

        $classContent = $this->generateClassContent($namespace, $className, $extends);
        File::put($filePath, $classContent);

        return $filePath;
    }

    /**
     * Parse class details from given name string.
     *
     * @param string $name
     * @return array{0: string, 1: string, 2: string}
     */
    protected function getClassDetails(string $name): array
    {
        $nameParts = explode('/', $name);
        $className = Str::studly(array_pop($nameParts));
        $nameParts = array_map(fn ($part) => Str::studly($part), $nameParts);
        $subPath = implode('/', $nameParts);

        $fullPath = app_path($subPath);
        $this->createDirectoryIfNeeded($fullPath);

        $namespace = $this->buildNamespace($subPath);
        $filePath = "{$fullPath}/{$className}.php";

        return [$namespace, $filePath, $className];
    }

    /**
     * Build PSR-4 namespace from subpath.
     *
     * @param string $subPath
     * @return string
     */
    protected function buildNamespace(string $subPath): string
    {
        if (empty($subPath)) {
            return 'App';
        }

        $parts = array_map(fn ($part) => Str::studly($part), explode('/', str_replace('\\', '/', $subPath)));

        return 'App\\' . implode('\\', $parts);
    }

    /**
     * Create directory if it doesn't exist yet.
     *
     * @param string $fullPath
     * @return void
     */
    protected function createDirectoryIfNeeded(string $fullPath): void
    {
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
    }

    /**
     * Check if file already exists.
     *
     * @param string $filePath
     * @return bool
     */
    protected function classExists(string $filePath): bool
    {
        return File::exists($filePath);
    }

    /**
     * Validate if the extends class exists.
     *
     * @param string|null $extends
     * @return string|null
     */
    protected function validateExtendsClass(?string $extends): ?string
    {
        if (!$extends) {
            return null;
        }

        if (class_exists($extends)) {
            return $extends;
        }

        Debugger::handle("The class '$extends' does not exist.", ['extends' => $extends])->throw();
    }

    /**
     * Check if class name is a reserved PHP name.
     *
     * @param string $className
     * @return bool
     */
    protected function isReservedClassName(string $className): bool
    {
        return in_array($className, $this->reservedClassNames, true);
    }

    /**
     * Generate class content using template stub.
     *
     * @param string $namespace
     * @param string $className
     * @param string|null $extends
     * @return string
     */
    protected function generateClassContent(string $namespace, string $className, ?string $extends): string
    {
        $template = File::get(resource_path('templates/__class_template.stub'));

        $useStatement = $extends ? "\nuse {$extends};\n" : '';
        $extendsStatement = $extends ? 'extends ' . class_basename($extends) : '';
        $classDeclaration = "{$className} {$extendsStatement}";

        return str_replace(
            ['{{ namespace }}', '{{ useStatement }}', '{{ classStatement }}'],
            [$namespace, $useStatement, $classDeclaration],
            $template
        );
    }
}
