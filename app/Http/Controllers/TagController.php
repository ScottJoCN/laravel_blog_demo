<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Redirect;
use App\Tag;

class TagController extends Controller
{
    public function __construct(){
        $this->middleware('auth',['only'=>['create','store','edit','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tags = Tag::where('count','>','0')->take(10)->get();
        return view('tags.list')->with('tags',$tags);
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
        //
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
        //
        return view('tags.edit')->with('tag',Tag::find($id));
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
        $rules = [
            'name' => ['required', 'regex:/^\w+$/'],
        ];
        $validator = Validator::make(['name'=>$request->input('name')], $rules); 
        if ($validator->passes()) {
            Tag::find($id)->update(['name'=>$request->input('name')]);
            return Redirect::back()->with('message', ['type' => 'success', 'content' => 'Modify tag successfully']);
        } else {
            return Redirect::back()->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tag = Tag::find($id);
        $tag->count = 0;
        $tag->save();
        foreach ($tag->article as $article) {
            # code...
            $tag->articles()->detach($article->id);
        }
        return Redirect::back();
    }
    public function articles($id){
        $tag = Tag::find($id);
        $articles = $tag->articles()->orderBy('created_at','desc')->paginate(5);
        return view('articles.specificTag')->with('tag',$tag)->with('articles',$articles);
    }
}
