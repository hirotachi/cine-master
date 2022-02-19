<header>
    @push("styles")
        <link rel="stylesheet" href="{{ asset("css/tester.css") }}">
        @endpush
    <div>logo</div>
    <div>
        <span>search btn</span>
        <div>create post btn</div>
        @auth()
            nice
        @endauth()
        <a href="/login">sign in</a>
    </div>
</header>
