<?php

namespace App\Services\Console;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeLogicService
{
    protected array $reservedClassNames = [
        'Array', 'array', 'bool', 'Class', 'double', 'Error', 'Exception', 'false', 'float', 'Function',
        'int', 'null', 'Number', 'Object', 'object', 'stdClass', 'String', 'string', 'Throwable', 'true',
    ];

    public function make(string $name, ?string $extends = null): string
    {
        [$namespace, $filePath, $className] = $this->getClassDetails($name);

        if ($this->isReservedClassName($className)) {
            throw new \Exception("The class name '$className' is reserved and cannot be used.");
        }

        $extends = $this->validateExtendsClass($extends);

        if ($this->classExists($filePath)) {
            throw new \Exception("Class already exists at $filePath");
        }

        $classContent = $this->generateClassContent($namespace, $className, $extends);
        File::put($filePath, $classContent);

        return $filePath;
    }

    protected function getClassDetails(string $name): array
    {
        $nameParts = explode('/', $name);
        $className = Str::studly(array_pop($nameParts));
        $nameParts = array_map(fn ($part) => Str::studly($part), $nameParts);
        $subPath = implode('/', $nameParts);

        $fullPath = app_path($subPath);
        $this->createDirectoryIfNeeded($fullPath);

        $namespace = $this->buildNamespace($subPath);
        $filePath = $fullPath.'/'.$className.'.php';

        return [$namespace, $filePath, $className];
    }

    protected function buildNamespace(string $subPath): string
    {
        if (!$subPath) {
            return 'App';
        }
        $parts = array_map(fn ($part) => Str::studly($part), explode('/', str_replace('\\', '/', $subPath)));
        return 'App\\' . implode('\\', $parts);
    }

    protected function createDirectoryIfNeeded(string $fullPath): void
    {
        if (! File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
    }

    protected function classExists(string $filePath): bool
    {
        return File::exists($filePath);
    }

    protected function validateExtendsClass(?string $extends): ?string
    {
        if (! $extends) {
            return null;
        }

        if (class_exists($extends)) {
            return $extends;
        }

        throw new \Exception("The class $extends does not exist.");
    }

    protected function isReservedClassName(string $className): bool
    {
        return in_array($className, $this->reservedClassNames);
    }

    protected function generateClassContent(string $namespace, string $className, ?string $extends): string
    {
        $template = File::get(resource_path('templates/__class_template.stub'));
        $extendsStatement = $extends ? 'extends '.class_basename($extends) : '';

        $useStatement = $extends ? "\nuse $extends;\n" : '';
        $classStatement = $extends ? $className.' '.$extendsStatement : $className;

        return str_replace(
            ['{{ namespace }}', '{{ useStatement }}', '{{ classStatement }}'],
            [$namespace ?? '', $useStatement ?? '', $classStatement ?? ''],
            $template
        );
    }
}
