<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = ['data', 'first_name', 'email', 'status'];

    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
