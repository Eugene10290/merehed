<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    /**
     * User repository
     *
     * @return string
     */
    public function model(): string
    {
        return User::class;
    }
}
