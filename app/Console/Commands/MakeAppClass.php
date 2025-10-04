<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeAppClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:class
                            {name : The name of the class (e.g., Helpers/ClassName)}
                            {--extends= : The class to extend (fully qualified name)}
                            {--implements= : Interfaces to implement (comma separated, fully qualified names)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new class in the app/ directory with optional extends and implements clauses.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {

        $name = $this->argument('name');
        $extends = $this->option('extends');
        $implements = $this->option('implements');

        $path = app_path("{$name}.php");
        $className = basename($name);

        $namespace = 'App' . (str_contains($name, '/') ? '\\' . str_replace('/', '\\', dirname($name)) : '');

        if (File::exists($path)) {
            $this->error("Class '{$name}' already exists!");
            return self::FAILURE;
        }

        $directory = dirname($path);
        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true, true);
            $this->info("Directory '{$directory}' successfully created.");
        }

        $extendsClause = $extends ? " extends " . $this->getShortClassName($extends) : '';

        $implementsClause = '';
        if ($implements) {
            $interfaces = array_map('trim', explode(',', $implements));
            $shortInterfaces = array_map([$this, 'getShortClassName'], $interfaces);
            $implementsClause = ' implements ' . implode(', ', $shortInterfaces);
        }

        $useStatements = $this->buildUseStatements($extends, $implements);

        $stub = "<?php\n\n";
        $stub .= "namespace {$namespace};\n\n";

        $stub .= $useStatements;

        $stub .= "class {$className}{$extendsClause}{$implementsClause}\n";
        $stub .= "{\n";
        $stub .= "    //\n";
        $stub .= "}\n";

        File::put($path, $stub);

        $this->info("Class '{$name}' successfully created at: {$path}");
        return self::SUCCESS;
    }

    /**
     * Extract the short class name from a fully qualified name (FQN).
     */
    protected function getShortClassName(string $fqn): string
    {

        return basename(str_replace('\\', '/', $fqn));
    }

    /**
     * Build the necessary use statements for the class.
     */
    protected function buildUseStatements(?string $extends, ?string $implements): string
    {
        $uses = [];

        if ($extends && str_contains($extends, '\\')) {
            $uses[] = $extends;
        }

        if ($implements) {
            $interfaces = array_map('trim', explode(',', $implements));
            foreach ($interfaces as $interface) {
                if (str_contains($interface, '\\')) {
                    $uses[] = $interface;
                }
            }
        }

        $uses = array_unique($uses);

        $output = '';
        foreach ($uses as $use) {
            $output .= "use {$use};\n";
        }

        return $output ? $output . "\n" : '';
    }
}
