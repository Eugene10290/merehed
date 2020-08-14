<?php
namespace App\Repositories;

use App\Models\Authors;

class AuthorsRepository extends BaseRepository
{

    /**
     * User repository
     *
     * @return string
     */
    public function model(): string
    {
        return Authors::class;
    }
}
