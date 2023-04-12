<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Book;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    public function getBooksFromFaker()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://fakerapi.it/api/v1/books', [
            'query' => [ "_quantity" => "100"]
        ]);
        $responseMessage = null;

        if($res->getStatusCode() === 200) {

            $booksData = [];
            $responseData = (json_decode($res->getBody()->getContents(), true));

            if(count($responseData['data'])) {
                foreach ($responseData['data'] as $bookKey => $bookValue) {
                    $booksData[] = [
                        'title'         => $bookValue['title'],
                        'author'        => $bookValue['author'],
                        'genre'         => $bookValue['genre'],
                        'description'   => $bookValue['description'],
                        'isbn'          => $bookValue['isbn'],
                        'image'         => $bookValue['image'],
                        'published_at'  => $bookValue['published'],
                        'publisher'     => $bookValue['publisher'],
                        'created_by'    => 'Admin',
                        'created_at'    => Carbon::now(),
                    ];
                }

                Book::insert($booksData);
                $responseMessage = [
                    'success' => true,
                    'message' => 'Data updated for the books'
                ];

            } else {

                $responseMessage = [
                    'success' => false,
                    'message' => 'Could not fetch data'
                ];

            }


        } else {
            $responseMessage = [
                'success' => false,
                'message' => 'Could not fetch data'
            ];
        }
        return $responseMessage;
    }

    public function index()
    {
        $getBooksData = Book::paginate(10);
        return response()->json([
            'success'   => true,
            'data'      => $getBooksData
        ]);
    }

    public function getBookById($bookId)
    {
        $bookDetail = Book::where('id', $bookId)->first();
        if($bookDetail) {
            return response()->json([
                'success'   => true,
                'data'      => $bookDetail
            ]);
        }

        return response()->json([
            'success'   => false,
            'error'     => 'Data not found.'
        ], 404);
    }

    public function store(BookRequest $request)
    {
        $validateRequest = $request->validated();
        $validateRequest['created_by'] = 'Admin';
        try {

            $newBook = Book::create($validateRequest);
            return response()->json([
                'success'   => true,
                'data'      => $newBook,
                'message'   => 'Book created.'
            ], 201);

        } catch(\Exception $e) {
            \Log::error($e);
            return response()->json([
                'success' => false,
                'errors'  => $e->getMessage()
            ], 500);
        }

    }

    public function update(BookRequest $request, $bookId)
    {
        $getBookData = Book::find($bookId);
        if(!$getBookData) {
            return response()->json([
                'success'   => false,
                'error'     => 'Model not found'
            ], 404);
        }

        try {
            $validateBookRequestData = $request->validated();
            $validateRequest['updated_by'] = 'Admin';
            $getBookData->update($validateBookRequestData);
            return response()->json([
                'success'   => true,
                'data'      => $getBookData,
                'message'   => 'Book data updated'
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'success'   => false,
                'error'      => $e->getMessage(),
            ], 500);
        }

    }

    public function delete($bookId)
    {
        $bookData = Book::find($bookId);
        if(!$bookData) {
            return response()->json([
                'success'   => false,
                'error'     => 'Book not found'
            ], 404);
        }

        try {

            $bookData->delete();

            return response()->json([
                'success'   => true,
                'data'      => null,
                'message'   => 'Book deleted successfully.'
            ], 204);

        } catch(\Exception $e) {

            return response()->json([
                'success'   => false,
                'error'      => $e->getMessage(),
            ], 500);

        }
    }
}
