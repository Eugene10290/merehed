<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Books\BooksStoreRequest;
use App\Http\Requests\Books\BooksUpdateRequest;
use App\Models\Books;
use App\Repositories\BooksRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BooksController extends ApiController
{
    /**
     * Show all books list
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index()
    {
        $books = (new BooksRepository())->all();

        return response()->json($books->toArray());
    }

    /**
     * Shows all users list
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function indexUser()
    {
        $books = (new BooksRepository())->findBy('user_id', Auth::user()->id);

        return response()->json($books->toArray());
    }

    /**
     * Store new book
     *
     * @param \App\Http\Requests\Books\BooksStoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function store(BooksStoreRequest $request)
    {
        $base64Image = base64_encode(file_get_contents($request->file('image_path')));

        $data            = $request->validated();
        $data['user_id'] = Auth::user()->id;
        $data['image_path'] = $base64Image;

        $book = (new BooksRepository())->create($data);

        return response()->json($book->toArray());
    }

    /**
     * Updates book
     *
     * @param \App\Http\Requests\Books\BooksUpdateRequest $request
     * @param                                             $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function update(BooksUpdateRequest $request, $id)
    {
        $book = (new BooksRepository())->findOrFail($id);
        $book->update($request->validated());

        return response()->json($book->toArray());
    }

    /**
     * Destroy by id
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function destroy($id)
    {
        $book = (new BooksRepository())->findOrFail($id);
        $book->delete();

        return response()->json('200');
    }
}
