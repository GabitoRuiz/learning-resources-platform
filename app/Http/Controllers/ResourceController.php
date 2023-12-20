<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ResourceController extends Controller
{
    public function index(Request $request){
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resources' => Resource::with('category')->latest()->get(),
        ]);
    }

    public function store(Request $request){
        // $request->validate([
        //  'title'=> ['required','max:255'],
        //  'category_id' =>['required','exists:categories,id'],
        //  'description' => ['required'],
        //  'url' => ['required','url']
        // ]);

        Resource::create([
            'title' => $request->title,
            'link' => $request->link,
            'description' =>$request->description,
            'category_id' =>$request->category_id,
            'creator_id' =>$request->User()->id,
        ]);

        return Inertia::location('/');
    }

    public function search(Request $request){
        return Resource::where('title', 'like', "%$request->search%")
        // ->orWhere('description', 'like', "%$request->search%")
        ->when(!empty($request->category_id), function ($query, $category_id){
            return $query->where('category_id', $category_id);
        })
        ->with('category')
        ->get();
    }
}
