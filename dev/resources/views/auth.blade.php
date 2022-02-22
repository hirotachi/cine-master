@component("layouts.layout")
    @styles("pages/auth")
    <div class="auth">
        <div class="auth__intro">
            <h1>{{$page === "login" ? "welcome back buddy" : "join us for free"}}</h1>
            @if($page === "login")<p>We missed you!</p>@endif
        </div>
        <form action="/{{$page}}" method="post" class="form">
            @if($page === "register")
                @include("components.input", ["placeholder" => "John Smith", "label" => "full name", "name" => "name"] )
                @include("components.input", ["placeholder" => "Your email address", "label" => "email"] )
            @endif
            @include("components.input", ["placeholder" => $page === "login" ?  "Username or email" : "Username", "label" => "username"] )
            @include("components.input", ["placeholder" => "********", "label" => "password"] )
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
