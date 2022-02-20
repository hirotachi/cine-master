<header class="navigation">
    <div class="navigation__main">
        <a href="/" class="navigation__logo">logo</a>
        <div class="navigation__menu_btn">
            @for($i = 0; $i < 3; $i++)
                <span></span>
            @endfor
        </div>
        <div class="navigation__other">
            <span class="navigation__search">
                <i class="fal fa-search"></i>
            </span>
            <a href="/login" class="navigation__login">sign in</a>
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
