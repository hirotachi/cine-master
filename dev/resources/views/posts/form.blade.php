@component("layouts.layout")
    @styles("components/post-form")
    <div class="form">
        <h1 class="form__title">{{$operation ?? "create"}} Post</h1>
        <form @if($_formAction ?? false)action="{{$_formAction}}" @endif method="post">
            @method({{strtoupper($_formMethod ?? "post")}})
            @include("components.input", ["label" => "title", "class" => "title", "placeholder" => "Your Post title goes here...","value" => $title ?? null] )
            @include("components.input", ["label" => "rating", "required" => false, "type" => "number", "value" => $rating ?? 0])
            @include("components.input", ["label" => "poster", "placeholder" => "Poster link", "value" => $poster ?? null])
            @include("components.input", ["label" => "banner", "placeholder" => "Banner link", "value" => $banner ?? null])
            @include("components.input", ["label" => "year", "value" => date("Y"), "type" => "number", "value" => $year ?? null])
            @include("components.input", ["label" => "genres", "placeholder" => "Genres separated by ; (comedy;action)", "value" => $genres ?? null])
            @include("components.textarea", ["label" => "description", "placeholder" => "Description about this post", "value" => $description ?? null])
            <button class="form__submit">{{$operation ?? "create"}} post</button>
        </form>
    </div>
@endcomponent

