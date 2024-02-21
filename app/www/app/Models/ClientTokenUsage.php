<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * @extends Builder
 */
class ClientTokenUsage extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "client_token_usages";
}
