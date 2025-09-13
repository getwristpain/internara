<?php

if (!function_exists('css')) {
    /**
     * Build a CSS class string with conditional support
     *
     * @param  string|array  ...$classes
     * @return string
     */
    function css(...$classes): string
    {
        $result = [];

        foreach ($classes as $class) {
            if (is_array($class)) {
                // Handle associative arrays: ['class-name' => true/false]
                foreach ($class as $name => $condition) {
                    if (is_string($name)) {
                        if ($condition && trim($name) !== '') {
                            $result = array_merge(
                                $result,
                                preg_split('/\s+/', trim($name))
                            );
                        }
                    } elseif (is_string($condition) && trim($condition) !== '') {
                        // Handle indexed arrays: ['bg-red-500 text-white']
                        $result = array_merge(
                            $result,
                            preg_split('/\s+/', trim($condition))
                        );
                    }
                }
            } elseif (is_string($class) && trim($class) !== '') {
                // Handle plain strings: "w-full h-full"
                $result = array_merge(
                    $result,
                    preg_split('/\s+/', trim($class))
                );
            }
        }

        // Cleanup: remove empty values, trim, and deduplicate
        $result = array_unique(array_filter(array_map('trim', $result)));

        return implode(' ', $result);
    }
}
