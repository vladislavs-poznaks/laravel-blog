@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('articles.create') }}" class="btn btn-primary btn-sm mb-4">
            Create new article
        </a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Created at</th>
                <th scope="col">Updated at</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <th scope="row">{{ $article->id }}</th>
                    <td>
                        <a href="{{ route('articles.show', ['article' => $article]) }}">
                            {{ $article->title }}
                        </a>
                    </td>
                    <td>{{ $article->created_at->diffForHumans() }}</td>
                    <td>{{ $article->updated_at->diffForHumans() }}</td>
                    <td>
                        @can('update', $article)
                            <a href="{{ route('articles.edit', ['article' => $article]) }}">Edit</a>
                        @endcan
                        @can('delete', $article)
                            <form method="post" action="{{ route('articles.destroy', $article) }}"
                                  style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
