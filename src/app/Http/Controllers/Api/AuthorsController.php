<?php

namespace App\Http\Controllers\Api;

use App\Repositories\AuthorsRepository;

class AuthorsController extends ApiController
{
    /**
     * Shows all authors
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index()
    {
        $authors = (new AuthorsRepository())->all();

        return response()->json($authors->toArray());
    }

    public function getAuthorBooks($id)
    {
        $author = (new AuthorsRepository())->findOrFail($id);
        $books = $author->books()->get();

        return response()->json($books->toArray());
    }
}
