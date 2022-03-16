<header class="navigation">
    <div class="navigation__main">
        <a href="/" class="navigation__logo">cinémaster</a>
        <div class="navigation__other">
            <a href="/{{\App\Middleware\Auth::check() ? "logout" : "login"}}"
               class="navigation__login">{{\App\Middleware\Auth::check() ? "logout" : "sign in"}}</a>
            @auth
                <a title="Create Post" href="/posts/create" class="btn btn-light navigation__create">
                    <span><i class="fal fa-plus-square"></i></span>
                    <span>create</span>
                </a>
            @endauth
            <a href="/contact" type="button" class="btn navigation__create btn-light">Contact</a>
        </div>
    </div>
</header>

<script>
    const menuBtn = document.querySelector(".navigation__menu_btn");
    const nav = document.querySelector(".navigation");


    menuBtn?.addEventListener("click", e => {
        const openClass = "navigation__menu_btn--open";
        const isOpen = menuBtn.classList.contains(openClass);
        menuBtn.classList.toggle(openClass);
    })

    function toggleMenu(exists) {

    }
</script>
