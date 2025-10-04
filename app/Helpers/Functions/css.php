<?php

use Illuminate\Support\Arr;

if (!function_exists('css')) {
    /**
     * Conditionally compiles a list of CSS class names into a single string.
     *
     * @param string|array ...$classes
     * @return string
     */
    function css(...$classes): string
    {
        $filtered = array_filter($classes, fn ($class) => $class !== null && $class !== '');
        $final = array_map(fn ($class) => is_string($class) ? [$class] : $class, $filtered);

        return Arr::toCssClasses(array_merge([], ...$final));
    }
}
