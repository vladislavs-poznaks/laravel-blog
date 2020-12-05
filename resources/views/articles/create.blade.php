@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Title..">
            </div>
{{--            <div>--}}
{{--                <label for="title-disable">Disable Title Input</label>--}}
{{--                <input type="checkbox" id="title-input" name="title-input" onchange="disableTitle()">--}}
{{--            </div>--}}
            <div class="form-group">
                <label for="content">Content</label>
                <div class="form-group">
                    <textarea name="content" id="content" class="form-control"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>
    </div>
    <script type="text/javascript">
        const disableTitle = () => {
            if (document.getElementById('title').disabled) {
                document.getElementById('title').disabled = false
            } else {
                document.getElementById('title').disabled = true
            }
        }
    </script>
@endsection
