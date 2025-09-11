<?php

if (!function_exists('stateIf')) {
    function stateIf(bool $condition, mixed $state): mixed
    {
        if ($condition) {
            return $state;
        }

        return null;
    }
}
