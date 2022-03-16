@component("layouts.layout")
    @styles("pages/home")
    <div class="home">
        @auth
            @if(!($isMyPosts ?? false))
                <a class="home__posts" href="/user/posts">my posts</a>
            @endif
        @endauth
        @include("components.posts")
    </div>
@endcomponent
