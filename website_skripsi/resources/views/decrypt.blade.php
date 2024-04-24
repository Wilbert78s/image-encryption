@extends('layouts.main')

@section('container')
<!-- Jumbotron -->
<div class="container mt-5">
  @if(session()->has('success_decrypt'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success_decrypt') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>          
     @endif
    <div class="row">
      <div class="col-6">
        <h2 class="text-center mb-5">Cipher Image</h2>
        <img class="justify-content-center mx-auto gambar" id="preview-image" alt="Preview Image" style="display: block"
          @if(session()->has('image_cipher')) 
            src="data:image/png;base64,{{ session('image_cipher') }}" 
          @else 
            src="img/blank_image.png" 
          @endif/>
        <form id="encrypt"></form>
        <input id="image_id" value="" hidden>
        <input id="user_id" value="{{ auth()->user()->id }}" hidden>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
          <label class="form-check-label" for="flexSwitchCheckDefault">Choose from your database</label>
        </div>
        <form action="/decrypt" method="post" id="main" class="mt-5" enctype="multipart/form-data">
          <div id="dynamicElementContainer">
            
          </div>
          <input required name="image" type="file" class="form-control" id="inputGroupFile02" onchange="displayImage(this)" />
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
              <div class="mb-3">
                <span class="input-group-text w-25">width</span>
                <input name="width" id="width" value="{{ @old('width') ?? session('width') ?? 512 }}" placeholder="ex : 512" aria-label="First name" class="form-control w-50 @error('width') is-invalid @enderror" required />
                <p style="display:inline"><=512</p>
                @error('width')
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
              <div class="mb-3">
                <span class="input-group-text w-25">height</span>
                <input name="height" id="height" value="{{ @old('height') ?? session('height') ?? 512 }}" placeholder="ex : 512" aria-label="First name" class="form-control w-50 @error('height') is-invalid @enderror" required />
                <p style="display:inline"><=512</p>
                @error('height')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-sm-2">
              <span class="input-group-text h-100">Hash</span>
            </div>
            <div class="col-sm">
              <textarea placeholder="ex : 1100010100000010000100000110001000000001011001001101000010101000010001111001101010100000110001010001111100011101011010101000111110101011101011010110010001010001111011101000101110111101110101000110010011100101001100001110101110110101110100111111010000100110" id="hashValue" name="hashing" class="form-control @error('hashing') is-invalid @enderror" id="exampleFormControlTextarea1" style="height: 150px; resize: none">{{@old('hashing')??session('hashing')??""}}</textarea>
              <p style="display:inline">hash value</p>
              @error('hashing')
              <div class="invalid-feedback">
                {{ $message }}
              </div>
            @enderror
            </div>            
          </div>

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
        <h2 class="text-center mb-5">Plain Image</h2>
        <img class="mx-auto gambar" id="result-image" alt="Preview Image" style="display: block" 
          @if(session()->has('image_plain'))
            src="data:image/png;base64,{{ session('image_plain') }}" 
          @else 
            src="img/blank_image.png" 
          @endif/>
        <button id="download-button" onclick="downloadImage()" type="button" class="btn btn-primary mt-5 mx-auto" style="display: block">Download</button>
        
      </div>
    </div>

  </div>
  <!-- Akhir Jumbotron -->

  
  @endsection