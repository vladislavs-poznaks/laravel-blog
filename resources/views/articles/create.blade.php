@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title..">
            </div>
            <div class="form-group">
                <label for="content">Content</label>
                <div class="form-group">
                    <textarea name="content" id="content" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>
@endsection
