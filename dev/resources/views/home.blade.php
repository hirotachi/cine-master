@component("layouts.layout")
    @styles("pages/home")
    <div class="home">
        {{--        intro with featured posts --}}
        @auth
            @if(!($isMyPosts ?? false))
                <a class="home__posts" href="/user/posts">my posts</a>
            @endif
        @endauth
        @include("components.posts")
        {{--        @if(count($posts) > 0)--}}
        {{--            <a class="home__more" href="/posts">view more</a>--}}
        {{--        @endif--}}
    </div>
@endcomponent
