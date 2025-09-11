<?php

namespace App\Helpers;

class Helper
{
    /**
     * @param array $attributes
     * @param string<class-string> $model
     *
     * @return array
     */
    public static function filterFillable(array $attributes, string $model): array
    {
        $attributes = array_filter($attributes, fn ($i) => $i !== '' && $i !== null);
        return array_intersect_key($attributes, array_flip(app($model)->getFillable()));
    }

    public function response(string $type = '', string $message = ''): LogicResponse
    {
        if (!empty($type)) {
            $type = in_array($type, ['success', 'error']) ? $type : null;
            return LogicResponse::make($type && $type === 'success', $message)
                ->withType($this)
                ->withPayload($this->toArray());
        }

        return LogicResponse::make()
            ->withType($this)
            ->withPayload($this->toArray());
    }

    public function toArray(): array
    {
        return [];
    }
}
