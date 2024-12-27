<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $books = Book::with('authors')->get();
        if(!empty($books)){
            return Response::json(['data'=> $books], 200);
        }
        return Response::json(['message'=> 'No records found'], 404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $data= array();
        $data['book_title'] = $request->book_title;
        $data['book_isbn'] = $request->book_isbn;
        $data['book_price'] = $request->book_price;
        $data['book_publish_year'] = $request->book_publish_year;
        $data['author_id'] = $request->author_id;
        $data['created_at'] = Carbon::now();

        $rules = array(
            'book_title' => 'required',
            'book_isbn' => 'required',
            'book_price' => 'required',
            'book_publish_year' => 'required',
            'author_id' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        else{
            $book = Book::create($data); // Corrected 'Author::created' to 'Author::create'
            //Condition
            if($book){
                return Response::json(['message'=>
                    'New Book has been create successfully !'],
                    200);
            }
            return Response::json(['message'=>
                'Something went wrong ! '],
                404);
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $bookss = Book::find($book->id);
        if(!empty($bookss)){
            return Response::json(['data'=> $bookss], 200);
        }
        return Response::json(['message'=> 'No records found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book): \Illuminate\Http\JsonResponse
    {
//        $data= array();
//        $data['book_title'] = $request->book_title;
//        $data['book_isbn'] = $request->book_isbn;
//        $data['book_price'] = $request->book_price;
//        $data['book_publish_year'] = $request->book_publish_year;
//        $data['author_id'] = $request->author_id;
//        $data['updated_at'] = Carbon::now();
        $boo = Book::find($book->id);
        $boo->update($request->all());
        //$aut = Author::where('id', $author->id)->update($data); // Corrected 'Author::created' to 'Author::create'
        //Condition
        if($boo){
            return Response::json(['message'=>
                'Book data has been update successfully !'],
                200);
        }
        return Response::json(['message'=>
            'Something went wrong ! '],
            404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): \Illuminate\Http\JsonResponse
    {
        $boo = Book::where('id', $book->id)->delete();
        if($boo){
            return Response::json(['message'=>
                'Book has been delete successfully !'],
                200);
        }
        return Response::json(['message'=>
            'Something went wrong ! '],
            404);
    }

}
