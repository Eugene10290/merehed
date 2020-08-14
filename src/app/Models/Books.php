<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'author_id',
        'pages_number',
        'annotation',
        'image_path'
    ];

    /**
     * Book has one author
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author() {
        return $this->belongsTo(Authors::class);
    }
}
