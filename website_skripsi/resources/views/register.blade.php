@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-5">
    <div class="col-lg-5">
        <main class="form-registration">
            <h1 class="h3 mb-5 fw-normal text-center">Registration Form</h1>
            <div class="row">
              <div class="col-10 mx-auto">
                <form action="/register" method="post" class="pt-3">
                  @csrf              
                  <div class="form-floating">
                    <input type="text" name="name" class="form-control @error('name')is-invalid @enderror" id="name" placeholder="name" required value="{{ old('name') }}">
                    <label for="name">name</label>
                    @error('name')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="form-floating">
                    <input type="email" name="email" class="form-control @error('email')is-invalid @enderror" id="email" placeholder="name@example.com" required>
                    <label for="email">Email address</label>
                    @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                  <div class="form-floating">
                    <input type="password" name="password" class="form-control rounded-bottom @error('password')is-invalid @enderror" id="password" placeholder="Password" required value="{{ old('password') }}">
                    <label for="password">Password</label>
                    @error('password')
                      <div class="invalid-feedback">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>         
            
                  <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Register</button>
                </form>
                <small class="d-block text-center mt-3">Already registered? <a href="/login">Login</a></div>
              
            </div>
        </main>
    </div>
</div>

@endsection