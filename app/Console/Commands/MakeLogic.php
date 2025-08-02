<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class MakeLogic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:logic {name} {--extends=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new logic class in the application';

    protected array $reservedClassNames = [
        'Array', 'Bool', 'Class', 'Double', 'Error', 'Exception', 'Float', 'Function', 'Int', 'Number', 'Object', 'stdClass', 'String', 'Throwable', 'true', 'false', 'array', 'float', 'string', 'int', 'null'
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = trim($this->argument('name'));
        $extends = trim($this->option('extends'));

        try {
            $path = $this->createClass($name, $extends);
            $this->info("The class created successfully in: {$path}");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    protected function createClass(string $name, ?string $extends): ?string
    {
        $this->validateExtendClass($extends);

        [$namespace, $filePath, $className] = $this->getClassDetails($name);

        if ($this->isReservedClassName($className)) {
            throw new InvalidArgumentException("The class name '{$className}' is reserved and cannot be used");
        }

        if (File::exists($filePath)) {
            throw new \Exception("Class already exists at: {$filePath}");
        }

        $this->generateClassContent($filePath, $namespace, $className, $extends);

        return $filePath;
    }

    public function generateClassContent(
        string $path = '',
        string $namespace = '',
        string $className = '',
        string $extends = ''
    ): bool|int {
        $template = File::exists(resource_path('templates/__class_template.stub'))
            ? File::get(resource_path('templates/__class_template.stub'))
            : throw new \Exception("The template file does not exists.");

        $useStatement = $extends ? "\nuse {$extends};\n" : '';
        $extendsStatement = $extends ? "extends " . class_basename($extends) : '';
        $classDeclaration = "{$className} {$extendsStatement}";

        $classContent = str_replace(
            ['{{ namespace }}', '{{ useStatement }}', '{{ classStatement }}'],
            [$namespace, $useStatement, $classDeclaration],
            $template
        );

        return File::put($path, $classContent);
    }

    protected function isReservedClassName(string $className): bool
    {
        return in_array($className, $this->reservedClassNames, true);
    }

    protected function getClassDetails(string $name): array
    {
        $nameParts = explode('/', $name);
        $className = Str::studly(array_pop($nameParts));

        $nameParts = array_map(fn ($part) => Str::studly($part), $nameParts);
        $subPath = implode('/', $nameParts);

        $fullPath = app_path($subPath);
        $this->createDirIfNeeded($fullPath);

        $namespace = $this->buildNamespace($subPath);
        $filePath = "{$fullPath}/{$className}.php";

        return [$namespace, $filePath, $className];
    }

    protected function buildNamespace(string $subPath): string
    {
        $namespace = 'App';

        if (empty($subPath)) {
            return $namespace;
        }

        $parts = array_map(fn ($part) => Str::studly($part), explode('/', str_replace('\\', '/', $subPath)));

        return "{$namespace}\\" . implode('\\', $parts);
    }

    protected function createDirIfNeeded(string $path): void
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    protected function validateExtendClass(?string $className)
    {
        if (!$className) {
            return null;
        }

        if (!class_exists($className)) {
            throw new InvalidArgumentException("The class '{$className}' does not exist.");
        }

        return $className;
    }
}
