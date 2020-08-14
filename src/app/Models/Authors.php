<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authors extends Model
{
    /**
     * Author has many book
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function books() {
        return $this->hasMany(Books::class, 'author_id');
    }
}
