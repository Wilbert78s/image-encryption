@extends('layouts.main')

@section('container')
<!-- Jumbotron -->
<div class="container mt-5">
    @if(session()->has('success_send'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success_send') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session()->has('failed_send'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('failed_send') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session()->has('success_encrypt'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success_encrypt') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>          
     @endif
    <div class="row">
      <div class="col-6">
        <h2 class="text-center mb-5">Plain Image</h2>
        <img class="justify-content-center mx-auto gambar" id="preview-image" alt="Preview Image" style="display: block"
          @if(session()->has('image_plain')) 
            src="data:image/png;base64,{{ session('image_plain') }}" 
          @else 
            src="img/blank_image.png" 
          @endif/>       

        <form action="/encrypt" method="post" id="main" class="mt-5" enctype="multipart/form-data">
          <div id="flexSwitchCheckDefault">
            
          </div>
          <input name="image" type="file" class="form-control" id="inputGroupFile02" onchange="displayImage(this)" required/>
          
          <div class="row inputan">
            <div class="col-sm">
              <div class="mb-3">
                <span class="input-group-text w-25">P1</span>
                <input name="p1" value="{{ @old('p1') ?? session('p1') ?? 3 }}" placeholder="ex : 3" aria-label="First name" class="form-control w-50 @error('p1') is-invalid @enderror" required />
                <p style="display:inline">prime</p>
                @error('p1')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">P2</span>
                <input name="p2" value="{{ @old('p2') ?? session('p2') ?? 5 }}" placeholder="ex : 5" aria-label="First name" class="form-control w-50 @error('p2') is-invalid @enderror" required />
                <p style="display:inline">prime</p>
                @error('p2')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">K1</span>
                <input name="k1" value="{{ @old('k1') ?? session('k1') ?? 5 }}" placeholder="ex : 5" aria-label="First name" class="form-control w-50 @error('k1') is-invalid @enderror" required />
                <p style="display:inline">int 1-8</p>
                @error('k1')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">K2</span>
                <input name="k2" value="{{ @old('k2') ?? session('k2') ?? 1 }}" placeholder="ex : 1" aria-label="First name" class="form-control w-50 @error('k2') is-invalid @enderror" required />
                <p style="display:inline">int 1-8</p>
                @error('k2')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">a</span>
                <input name="a" value="{{ @old('a') ?? session('a') ?? 560 }}" placeholder="ex : 560" aria-label="First name" class="form-control w-50 @error('a') is-invalid @enderror" required />
                <p style="display:inline">>500</p>
                @error('a')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="col-sm">
              <div class="mb-3">
                <span class="input-group-text w-25">X0</span>
                <input name="x0" value="{{ @old('x0') ?? session('x0') ?? 0.3 }}" placeholder="ex : 0.3" aria-label="First name" class="form-control w-50 @error('x0') is-invalid @enderror" required />
                <p style="display:inline">(0,1)</p>
                @error('x0')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">A0</span>
                <input name="a0" value="{{ @old('a0') ?? session('a0') ?? 0.8 }}" placeholder="ex : 0.8" aria-label="First name" class="form-control w-50 @error('a0') is-invalid @enderror" required />
                <p style="display:inline">(0,4]</p>
                @error('a0')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">X1</span>
                <input name="x1" value="{{ @old('x1') ?? session('x1') ?? 0.4 }}" placeholder="ex : 0.4" aria-label="First name" class="form-control w-50 @error('x1') is-invalid @enderror" required />
                <p style="display:inline">(0,1)</p>
                @error('x1')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-3">
                <span class="input-group-text w-25">A1</span>
                <input name="a1" value="{{ @old('a1') ?? session('a1') ?? 0.6 }}" placeholder="ex : 0.6" aria-label="First name" class="form-control w-50 @error('a1') is-invalid @enderror" required />
                <p style="display:inline">(0,4]</p>
                @error('a1')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>              
              <div class="mb-3">
                <span class="input-group-text w-25">b</span>
                <input name="b" value="{{ @old('b') ?? session('b') ?? 539 }}" placeholder="ex : 539" aria-label="First name" class="form-control w-50 @error('b') is-invalid @enderror" required />
                <p style="display:inline">>500</p>
                @error('b')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>           
        
          </div>

          <div class="inputan"></div>
          <div class="row justify-content-center mt-4 text-center">
            <div class="col">
              <div id="overlay">
                <div class="spinner"></div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>
        </form>
      </div>


      
      <div class="col-6">
        <h2 class="text-center mb-5">Cipher Image</h2>
        <img class="mx-auto gambar" id="result-image" alt="Preview Image" style="display: block" 
          @if(session()->has('image_cipher'))
            src="data:image/png;base64,{{ session('image_cipher') }}" 
          @else 
            src="img/blank_image.png" 
          @endif/>
        
        <button id="download-button" onclick="downloadImage()" type="button" class="btn btn-primary mt-5 mx-auto" style="display: block">Download</button>
        
        <hr>
        <p class="mt-3 mb-1">Hash</p>
        <textarea readonly id="hashValue" class="form-control mb-2" style="height: 120px; resize: none">@if(session()->has('hash')){{ session('hash') }}@endif</textarea>
      
        <div class="row">
          <div class="col-sm-3">
            <p class="mb-1">width</p>
            <input readonly id="width" type="number" aria-label="First name" class="form-control w-50 mb-2" 
              @if(session()->has('width'))
                value="{{ session('width') }}"
              @endif/>

          </div>
          <div class="col-sm-3">
            <p class="mb-1">height</p>
            <input readonly  id="height" type="number" aria-label="First name" class="form-control w-50 mb-2" 
            @if(session()->has('height'))
              value="{{ session('height') }}"
            @endif/>

          </div>
        </div>

        
        <hr>
        <h5 class="mt-5 ms-2">Send to</h5>
        <form action="/send-image" method="post" class="mt-4 form-check" enctype="multipart/form-data"> 
            <input name="image_cipher_id" id="image_id" value="{{ session('image_cipher_id') }}" hidden>
            @foreach ($users as $user)
            <div>
              <input class="form-check-input" type="checkbox" value="{{ $user->id }}" id="flexCheckDefault" name="users[]">
              <label class="form-check-label" for="flexCheckDefault">
                {{ $user->name }}
              </label>
            </div>
            @endforeach
            <button  id="send-button" type="submit"  class="btn btn-primary mt-4">Send</button>
            <div class="loader"></div>
        </form>       
      </div>
    </div>
    </div>

    
  </div>
  <!-- Akhir Jumbotron -->      
@endsection