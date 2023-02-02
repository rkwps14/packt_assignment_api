<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Book::all();
        return response(["data"=>$data, "status"=>"Success"],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store books data
        $this->validate($request,[
            'title'=>'required',
            'author'=>'required',
            'genre'=>'required',
            'description'=>'required',
            'isbn'=>'required',
            'published'=>'required',
            'publisher'=>'required',
            'image'=>'required',
        ]);

        $image=$request->file('image');
        $slug = Str::slug($request->name);
        if (isset($image)){
            $currentDate=Carbon::now()->toDateString();
            $imagename= $slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();

            if (!file_exists('uploads/item')){
                mkdir('uploads/item',0777,true);
            }
            $image->move('uploads/item',$imagename);
        }
        else{
            $imagename="default.png";
        }

        $item= new Book();
        $item->title=$request->title;
        $item->author=$request->author;
        $item->genre=$request->genre;
        $item->description=$request->description;
        $item->isbn=$request->isbn;
        $item->published=$request->published;
        $item->publisher=$request->publisher;
        $item->image=$request->image;
        $item->save();

        return response([
            'message' => ['The Record Register Success'],
            'status' => 200

        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Book::where('id','=',$id)->first();
        if(empty($data)){
            return response([
                'message' => ['Record Not Found'],
                'status' => 400

            ],400);
        }
        return response([
                'data' => $data,
                'message' => ['Record Founded'],
                'status' => 200
            ],200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $image=$request->file('image');
        $slug = Str::slug($request->name);
        if (isset($image)){
            $currentDate=Carbon::now()->toDateString();
            $imagename= $slug.'-'.$currentDate.'-'.uniqid().'.'.
                $image->getClientOriginalExtension();

            if (!file_exists('uploads/item')){
                mkdir('uploads/item',0777,true);
            }
            $image->move('uploads/item',$imagename);
        }
        else{
            $imagename="default.png";
        }

        $item= Book::find($id);
        $item->title=$request->title;
        $item->author=$request->author;
        $item->genre=$request->genre;
        $item->description=$request->description;
        $item->isbn=$request->isbn;
        $item->published=$request->published;
        $item->publisher=$request->publisher;
        $item->image=$imagename;
        $item->update();

        return response([
            'message' => ['The Record Updated Success'],
            'status' => 200

        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response([
            'message' => 'The Record Deleted Successfully',
            'status' => 200

        ],200);
    }
}
