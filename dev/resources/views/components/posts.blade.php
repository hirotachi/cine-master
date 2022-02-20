@styles("components/posts")

<div class="posts">
    @forelse($posts as $post)
        <div class="post">
            <a class="post__poster">
                <img
                        src="{{$post->poster}}"
                        alt="{{$post->title}}" loading="lazy"
                >
            </a>
            <div class="post__data">
                <a class="post__data_main">
                    <span class="post__title">{{$post->title}}</span>
                    <span class="post__year">({{$post->year}})</span>
                </a>
                <span class="post__rating">{{$post->rating}}/10</span>
            </div>
        </div>
    @empty
        <p class="posts__placeholder">no posts</p>
    @endforelse
</div>
