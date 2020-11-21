<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function index()
    {
        return view('articles.index', [
            'articles' => Article::all()
        ]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        auth()->user()->articles()->save(Article::make($request->all()));

        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return view('articles.show', [
            'article' => $article
        ]);
    }

    public function edit(Article $article)
    {
        return view('articles.edit', [
            'article' => $article
        ]);
    }

    public function update(Request $request, Article $article)
    {
        $article->update($request->all());

        return redirect()->route('articles.edit', ['article' => $article]);
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles.index');
    }
}
