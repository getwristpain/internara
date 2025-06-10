<?php

namespace App\Traits\Traits;

use App\Helpers\Attribute;

trait HasAttribute
{
    protected Attribute $attributes;

    public function setAttributes(array $data = [], array $defaults = []): static
    {
        $defaults = array_merge($this->setDefaultAttributes(), $defaults);
        $this->attributes = Attribute::make($data, $defaults);
        return $this;
    }

    public function getAttributes(): Attribute
    {
        return $this->attributes ?? Attribute::make();
    }

    protected function setDefaultAttributes(): array
    {
        return [];
    }
}
