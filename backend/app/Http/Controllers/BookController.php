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

    public function index(Request $request)
    {
        $perPage = $request->get('perPage') ?? 10;
        $searchTerm = $request->get('search') ?? null;
        $filters = $request->get('filters');
        $authorFilter = $filters['author'] ?? [];
        $genreFilter = $filters['genre'] ?? [];
        $publishedAtFilter = $filters['published_at'] ?? [];
        $publisherFilter = $filters['publisher'] ?? [];
        $booksDataQuery = Book::query();
        $booksDataQuery->when(count($authorFilter) > 0, function ($q) use ($authorFilter) {
            $q->orWhereIn('author', $authorFilter);
        });
        $booksDataQuery->when(count($genreFilter) > 0, function ($q) use ($genreFilter) {
            $q->whereIn('genre', $genreFilter);
        });
        $booksDataQuery->when(count($publishedAtFilter) > 0, function ($q) use ($publishedAtFilter) {
            $q->whereIn(\DB::raw('YEAR(published_at)'), $publishedAtFilter);
        });
        $booksDataQuery->when(count($publisherFilter) > 0, function ($q) use ($publisherFilter) {
            $q->whereIn('publisher', $publisherFilter);
        });
        $booksDataQuery->when($searchTerm, function ($q) use ($searchTerm) {
            return $q->whereYear('published_at', 'like', '%' . $searchTerm . '%')
                    ->orWhere('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('author', 'like', '%' . $searchTerm . '%')
                    ->orWhere('publisher', 'like', '%' . $searchTerm . '%');
        });
        $getBooksData = $booksDataQuery->paginate($perPage);
        return response()->json([
            'success'   => true,
            'data'      => $getBooksData
        ]);
    }

    public function filters()
    {
        $filters = [];
        $filters['author'] = Book::groupBy('author')->pluck('author')->toArray();
        $filters['genre'] = Book::groupBy('genre')->pluck('genre')->toArray();
        $filters['publisher']  = Book::groupBy('publisher')->pluck('publisher')->toArray();
        $filters['published_at'] = Book::selectRaw('YEAR(published_at) AS year')
                                    ->distinct()
                                    ->orderBy('year', 'desc')
                                    ->pluck('year')
                                    ->toArray();
        return response()->json([
            'success'   => true,
            'data'      => $filters,
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
