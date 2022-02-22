@component("layouts.layout")
    @styles("pages/post")
    @styles("components/comments")
    <div class="post">

        <div class="post__banner"><img src="{{$post->banner}}" alt="{{$post->title}}"></div>
        <div class="post__main">
            <div class="intro">
                <div class="intro__poster"><img src="{{$post->poster}}" alt="{{$post->title}}"/></div>
                <div class="intro__details">
                    <p class="intro__rating">{{$post->rating}}<span>/10</span></p>
                    <div class="intro__more">
                        <span>18+</span>
                        <span>2h 12min</span>
                        <span>4 July 2019 (USA)</span>
                        <div class="genres">
                            @foreach($post->genres as $genre)
                                <span>{{$genre}}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="details">
                <p class="details__title">{{$post->title}} <span>({{$post->year}})</span></p>
                <div class="details__main">
                    <div class="details__more">
                        <span>18+</span>
                        <span>2h 12min</span>
                        <div class="genres">
                            @foreach($post->genres as $genre)
                                <span>{{$genre}}</span>
                            @endforeach
                        </div>
                        <span>4 July 2019 (USA)</span>
                    </div>
                    <p class="details__description">{{$post->description}}</p>
                </div>
                <div class="post__control">
                    <a href="/posts/{{$post->id}}/edit" class="edit">edit post</a>
                </div>
                <div class="comments">
                    <h3 class="comments__title">
                        Comments @if(count($post->comments) > 0)({{count($post->comments)}})@endif
                    </h3>
                    <form class="form" method="post">
                        <textarea required oninput="handleInput(this)" placeholder="Your Comment"
                                  name="comment"></textarea>
                        <button class="form__submit">publish</button>
                    </form>
                    <div class="comments__list">
                        @foreach($post->comments as $comment)
                            <div class="comment">
                                <div class="author">
                                    <span class="author__avatar">
                                        <img src="{{$comment->author->avatar}}"
                                             alt="{{$comment->author->fullName}}"
                                        >
                                    </span>
                                    <span class="author__name">{{$comment->author->fullName}}</span>
                                </div>
                                <p class="comment__content">{{$comment->content}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        function handleInput(target) {
            if (!target.value) {
                target.removeAttribute("style");
                return;
            }
            target.style.height = "auto";
            target.style.height = `${target.scrollHeight / 10}rem`;
        }
    </script>
@endcomponent
