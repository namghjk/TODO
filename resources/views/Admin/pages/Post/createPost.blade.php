@extends('layouts.main')
@section('header')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
@endsection

@section('content')
    <div class="card-body">
        <div class="form-group">
            <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter title" value="{{ old('title') }}">
                    @if ($errors->has('title'))
                        <span type='error' style="color: red">{{ $errors->first('title') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" name="description" placeholder="Enter description" value="{{ old('description') }}">
                    @if ($errors->has('description'))
                        <span type='error' style="color: red">{{ $errors->first('description') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="description" name="content" placeholder="Enter content">{{ old('content') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail Image</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                        <label class="custom-file-label" for="thumbnail">Choose file</label>
                    </div>
                    @if ($errors->has('thumbnail'))
                        <span type='error' style="color: red">{{ $errors->first('thumbnail') }}</span>
                    @endif
                </div>

                <script>
                    document.getElementById('thumbnail').addEventListener('change', function(e) {
                        var fileName = e.target.files[0].name;
                        var label = document.querySelector('.custom-file-label');
                        label.innerHTML = fileName;
                    });
                </script>
                <button type="submit" class="btn btn-danger col-1  mt-5 float-right">Submit</button>
            </form>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
