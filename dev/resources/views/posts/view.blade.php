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
                        <span class="intro__author">Created by ( {{$usersMapByID[$post->author_id]->name}} )</span>
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
                        <div class="genres">
                            @foreach($post->genres as $genre)
                                <span>{{$genre}}</span>
                            @endforeach
                        </div>
                        <span class="details__author">Created by ( {{$usersMapByID[$post->author_id]->name}} )</span>
                    </div>
                    <p class="details__description">{{$post->description}}</p>
                </div>
                @owner($post->author_id)
                <div class="post__control">
                    <a href="/posts/{{$post->id}}/edit" class=" btn btn-light edit">edit post</a>
                    <a href="/posts/{{$post->id}}/delete" class="btn btn-danger delete">delete post</a>
                </div>
                @endowner
                <div class="comments">
                    <h3 class="comments__title">
                        Comments @if(count($comments) > 0)({{count($comments)}})@endif
                    </h3>
                    @auth
                        <form class="form" action="/posts/{{$post->id}}/comments" method="post">
                        <textarea required oninput="handleInput(this)" placeholder="Your Comment"
                                  name="content"></textarea>
                            <button class="form__submit">publish</button>
                        </form>
                    @endauth
                    <div class="comments__list">
                        @forelse($comments as $comment)
                            <?php $author = $usersMapByID[$comment->author_id];?>
                            <div class="comment">
                                <div class="author">
                                    <span class="author__avatar">
                                        <img src="{{$avatar}}"
                                             alt="{{$author->name}}"
                                        >
                                    </span>
                                    <span class="author__name">{{$author->name}}</span>
                                    @owner($comment->author_id)
                                    <span onclick="handleDelete(this)" data-id="{{$comment->id}}"
                                          class="comment__delete" title="remove"><i class="far fa-trash-alt"></i></span>
                                    @endowner
                                </div>
                                <p class="comment__content">{{$comment->content}}</p>
                            </div>
                        @empty
                            <p class="comments__placeholder">no comments</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        const commentForm = document.querySelector(".form");
        const commentInput = commentForm.querySelector("textarea");
        const commentsList = document.querySelector(".comments__list");
        const commentsTitle = document.querySelector(".comments__title");

        commentForm.addEventListener("submit", e => {
            e.preventDefault();
            const content = commentInput.value;
            fetch("/posts/{{$post->id}}/comments", {
                method: "POST",
                body: new FormData(commentForm)
            }).then(res => res.json()).then(data => {
                const {commentId} = data;
                const comment = `
            <div class="comment" >
                                <div class="author">
                                    <span class="author__avatar">
                                        <img src="{{$avatar}}"
                                             alt="{{$user->name}}"
                                        >
                                    </span>
                                    <span  class="author__name">{{$user->name}}</span>
                <span onclick="handleDelete(this)" data-id="${commentId}"
                                       class="comment__delete" title="remove"><i class="far fa-trash-alt"></i></a>
                </div>
                <p class="comment__content">${content}</p>
                            </div>`
                const commentsPlaceholder = document.querySelector(".comments__placeholder");
                if (commentsPlaceholder) {
                    commentsPlaceholder.remove();
                }
                commentsList.innerHTML = comment + commentsList.innerHTML;

                commentsTitle.textContent = `Comments${commentsList.childElementCount ? ` (${commentsList.childElementCount})` : ""}`
                commentInput.value = "";
            });
        })

        function handleDelete(btn) {
            const commentId = btn.getAttribute("data-id");
            fetch(`/posts/{{$post->id}}/comments/${commentId}/delete`).then(res => res.json()).then(() => {
                const comment = btn.parentElement.parentElement;
                comment.remove();
                commentsTitle.textContent = `Comments${commentsList.childElementCount ? ` (${commentsList.childElementCount})` : ""}`
                if (!commentsList.childElementCount) {
                    commentsList.innerHTML = `<p class="comments__placeholder">no comments</p>`;
                }
            })
        }

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
