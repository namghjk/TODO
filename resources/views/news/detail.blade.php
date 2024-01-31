<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
</head>

<body>
    <div class="container">
        <div class="blog-box">
            <div class=" text text-center ">
                <h1>{{ $post->title }}</h1>
            </div>
            <b>{{ $post->description }}</b>
            <br>
            <div class="content">{!! $post->content !!}</div>
        </div>
    </div>
</body>

</html>
