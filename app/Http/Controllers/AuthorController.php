<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;



class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $authors = Author::all();
        if(!empty($authors)){
            return Response::json(['data'=> $authors], 200);
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
        $data['author_name'] = $request->author_name;
        $data['author_contact_no'] = $request->author_contact_no;
        $data['author_country'] = $request->author_country;
        $data['created_at'] = Carbon::now();

        $rules = array(
            'author_name' => 'required',
            'author_contact_no' => 'required',
            'author_country' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        else{
            $author = Author::create($data); // Corrected 'Author::created' to 'Author::create'
            //Condition
            if($author){
                return Response::json(['message'=>
                    'New Author has been create successfully !'],
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
    public function show(Author $author)
    {
        $authorr = Author::find($author->id);
        if(!empty($authorr)){
            return Response::json(['data'=> $authorr], 200);
        }
        return Response::json(['message'=> 'No records found'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author): \Illuminate\Http\JsonResponse
    {
//        $data= array();
//        $data['author_name'] = $request->author_name;
//        $data['author_contact_no'] = $request->author_contact_no;
//        $data['author_country'] = $request->author_country;
//        $data['updated_at'] = Carbon::now();
        $aut = Author::find($author->id);
        $aut->update($request->all());
        //$aut = Author::where('id', $author->id)->update($data); // Corrected 'Author::created' to 'Author::create'
        //Condition
        if($aut){
            return Response::json(['message'=>
                'Author data has been update successfully !'],
                200);
        }
        return Response::json(['message'=>
            'Something went wrong ! '],
            404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author): \Illuminate\Http\JsonResponse
    {
        $aut = Author::where('id', $author->id)->delete();
        if($aut){
            return Response::json(['message'=>
                'Author has been delete successfully !'],
                200);
        }
        return Response::json(['message'=>
            'Something went wrong ! '],
            404);
    }

    public function search($term): \Illuminate\Http\JsonResponse
    {
        $authors = Author::where('author_name', "LIKE", "%".$term."%")->get();
        if(!empty($authors)){
            return Response::json(['data'=> $authors], 200);
        }
        return Response::json(['message'=> 'No records found'], 404);
    }
}
