<?php

namespace App\Helpers;

use App\Helpers\Helper;

class Formatter extends Helper
{
    /*
     * Class constructor
     */
    public function __construct()
    {
        //
    }

    public static function formatOptions(array $data): array
    {
        return collect($data)  // Convert the data to a collection
            ->map(fn($item) => [  // Map each item to a new array
                'value' => $item['id'],  // Set the value key to the item's id
                'label' => $item['name'],  // Set the label key to the item's name
            ])
            ->toArray();  // Convert the collection back to an array
    }
}
