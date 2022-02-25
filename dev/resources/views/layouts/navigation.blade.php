<header class="navigation">
    <div class="navigation__main">
        <a href="/" class="navigation__logo">cinémaster</a>
        <div class="navigation__menu_btn">
            @for($i = 0; $i < 3; $i++)
                <span></span>
            @endfor
        </div>
        <div class="navigation__other">
            <span class="navigation__search">
                <i class="fal fa-search"></i>
            </span>

            <a href="/{{\App\Middleware\Auth::check() ? "logout" : "login"}}"
               class="navigation__login">{{\App\Middleware\Auth::check() ? "logout" : "sign in"}}</a>
            @if(\App\Middleware\Auth::check())
                <a title="Create Post" href="/posts/create" class="navigation__create">
                    <span><i class="fal fa-plus-square"></i></span>
                    <span>create</span>
                </a>
            @endif
        </div>
    </div>
    {{--    <div class="navigation__menu">--}}
    {{--        <div>categories</div>--}}
    {{--    </div>--}}
</header>

<script>
    const menuBtn = document.querySelector(".navigation__menu_btn");
    const nav = document.querySelector(".navigation");


    menuBtn.addEventListener("click", e => {
        const openClass = "navigation__menu_btn--open";
        const isOpen = menuBtn.classList.contains(openClass);
        menuBtn.classList.toggle(openClass);
    })

    function toggleMenu(exists) {

    }
</script>
