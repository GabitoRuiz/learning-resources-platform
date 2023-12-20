<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Voter extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
    ];

    public function resources(){
        return $this->BelongsToMany(Resources::class, 'votes');
    }
    
}

