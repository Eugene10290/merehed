<?php
namespace App\Repositories;

use App\Models\Books;

class BooksRepository extends BaseRepository
{

    /**
     * User repository
     *
     * @return string
     */
    public function model(): string
    {
        return Books::class;
    }
}
