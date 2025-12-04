<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasUuids;
    protected $fillable = [
        'id',
        'account_id',
        'category_id',
        'type',
        'sum',
        'description',
        'created_at',
    ];
}
