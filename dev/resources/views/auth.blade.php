@component("layouts.layout")
    @styles("pages/auth")
    <div class="auth">
        <div class="auth__intro">
            <h1>{{$page === "login" ? "welcome back buddy" : "join us for free"}}</h1>
            @if($page === "login")<p>We missed you!</p>@endif
        </div>
        <form action="/{{$page}}" method="post" class="form">
            @if(isset($message))
                <p class="form__error">{{$message}}</p>
            @endif
            @if($page === "register")
                @include("components.input", ["placeholder" => "John Smith", "label" => "full name", "name" => "name", "errorClass" => "form__field--error"] )
                @include("components.input", ["placeholder" => "Your email address", "label" => "email", "type" => "email", "errorClass" => "form__field--error"] )
            @endif
            @include("components.input", ["placeholder" => $page === "login" ?  "Username or email" : "Username", "label" => "username", "errorClass" => "form__field--error"] )
            @include("components.input", ["placeholder" => "********", "label" => "password", "errorClass" => "form__field--error"] )
            <button class="form__submit">{{$page === "login" ? "Sign In" : "Create Account"}}</button>
        </form>
        <p class="auth__register">
            {{$page === "login" ? "Don't have an account" : "Already have an account"}}? <a
                    href="/{{$page === "login" ? "register" : "login"}}">
                {{$page === "login" ? "Sign up for free" : "Sign in"}}
            </a>
        </p>
    </div>
@endcomponent()
