@component("layouts.layout")
    @styles("pages/contact")
    <form class="container contact">
        <h1>Contact page</h1>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Your message</label>
            <textarea placeholder="message" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-light " type="submit">Submit</button>
        </div>
    </form>
@endcomponent