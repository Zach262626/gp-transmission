@extends('layouts.app', ['activePage' => 'MainPage', 'type' => 'login']) {{-- **IMPORTANT TO ADD activePage for styling** --}}
@section('content')
<style>
    /* secondary: #2F64AE */
    /* Light: #D9D9D9 */
    .hide {
        visibility: hidden;
    }
    
</style>
<div id="Main">
    <div class="container text-light w-75">
        <div class="fs-1 mb-5 border-bottom border-2 border-light text-center">
            Login
        </div>
        <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input name="email" type="email" class="form-control text-light" id="exampleInputEmail1" aria-describedby="emailHelp">
            @error('email')
            {{ $message }}
             @enderror
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input name="password" type="password" class="form-control text-light" id="exampleInputPassword1">
            @error('password')
            {{ $message }}
             @enderror
        </div>
        <button type="submit" class="btn btn-light">Submit</button>
        </form>
    </div>
</div>
@endsection