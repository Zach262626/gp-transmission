@extends('layouts.app', ['activePage' => 'MainPage']) {{-- **IMPORTANT TO ADD activePage for styling** --}}
@section('content')
<style>
    /* secondary: #2F64AE */
    /* Light: #D9D9D9 */
    .hide {
        visibility: hidden;
    }
    
</style>
<section id="Header">
    @include('layouts.navbars.nav_top', ['headerId' => 'Header', 'type' => 'signin'])
    <div class="container text-light w-75">
        <div class="fs-1 mb-5 border-bottom border-2 border-light text-center">
            Sign in
        </div>
        <form>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control text-light" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text text-light">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control text-light" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-light">Submit</button>
        </form>
    </div>
    @include('layouts.footers.footer')
</section>
@endsection