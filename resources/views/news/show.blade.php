<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
</head>

<body>


    @foreach ($posts as $post)
        <div class="container mt-3 ">
            <div class="text-center">
                <div class="mb-20 flex row">
                    <div class="horizontalPost__avt avt-240">
                        <a href="{{ route('detail_news', $post->slug) }}" title="{{ $post->title }}">
                            <picture>
                                <img src="{{ asset($post->thumbnail) }}" class="lazy-loaded" alt="{{ $post->title }}"
                                    style="width: 100px; height: 100px;">
                            </picture>
                        </a>
                    </div>
                    <div class="m-lg-2">
                        <h3 class="horizontalPost__main-title vnn-title title-bold">
                            <a href="{{ route('detail_news', $post->slug) }}" title="{{ $post->title }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <div class="horizontalPost__main-desc">
                            <p>{{ $post->description }}</p>
                        </div>
                        <div class="horizontalPost__main-desc">
                            <p>{{ $post->publish_date_formatted }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div style= "border-bottom: 1px solid black">

            </div>
        </div>
    @endforeach

    @include('partials.footer')
</body>

</html>
