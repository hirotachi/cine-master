@component("layouts.layout")
    @styles("pages/post")
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
                <div class="comments">
                    <h3>Comments</h3>
                    <div>comment input</div>
                    <div>list of comments</div>
                </div>
            </div>
        </div>

    </div>
@endcomponent
