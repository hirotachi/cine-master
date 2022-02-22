@component("layouts.layout")
    @styles("pages/home")
    <div class="home">
        {{--        intro with featured posts --}}
        @include("components.posts")
        <a class="home__more" href="/posts">view more</a>
    </div>
@endcomponent
