<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = [
        'key', 'label', 'type', 'options', 'placeholder',
        'description', 'section', 'sort_order', 'required', 'active',
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
            'required' => 'boolean',
            'active' => 'boolean',
        ];
    }
}
