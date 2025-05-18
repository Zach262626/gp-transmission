@extends('layouts.app', ['activePage' => 'ContactPage']) {{-- **IMPORTANT TO ADD activePage for styling** --}}
@include('layouts.navbars.nav_top', ['headerId' => 'Header', 'type' => 'main'])
@section('content')
  <div class="container mt-5 text-light">
    <h2 class="mb-4">Customer Information Form</h2>
    <form method="post" action="{{ route('customerInformationCreate') }}">
    @csrf
    <div class="row g-3">
      <!-- Personal Info -->
      <div class="col-md-6">
      <label for="name" class="form-label">Full Name</label>
      <input name="name" name="" type="text" class="form-control" id="name" placeholder="John Doe" required>
      @error('name')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-6">
      <label for="date" class="form-label">Date</label>
      <input name="date" type="date" class="form-control" id="date" required>
      @error('date')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-6">
      <label for="email" class="form-label">Email</label>
      <input name="email" type="email" class="form-control" id="email" placeholder="name@example.com" required>
      @error('email')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-3">
      <label for="cell" class="form-label">Cell Phone</label>
      <input name="cell_phone" type="tel" class="form-control" id="cell" placeholder="(555) 123-4567">
      @error('cell_phone')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-3">
      <label for="home" class="form-label">Home Phone</label>
      <input name="home_phone" type="tel" class="form-control" id="home" placeholder="(555) 765-4321">
      @error('home_phone')
      {{ $message }}
    @enderror
      </div>

      <!-- Vehicle Details -->
      <div class="col-md-2">
      <label for="year" class="form-label">Year</label>
      <input name="year" type="number" class="form-control" id="year" placeholder="2020" min="1900" max="2099"
        step="1">
      @error('year')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-5">
      <label for="make" class="form-label">Make</label>
      <input name="make" type="text" class="form-control" id="make" placeholder="Toyota">
      @error('make')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-5">
      <label for="model" class="form-label">Model</label>
      <input name="model" type="text" class="form-control" id="model" placeholder="Corolla">
      @error('model')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-4">
      <label for="vin" class="form-label">VIN</label>
      <input name="vin" type="text" class="form-control" id="vin" maxlength="17" placeholder="1HGCM82633A004352">
      @error('vin')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-4">
      <label for="plate" class="form-label">License Plate</label>
      <input name="license_plate" type="text" class="form-control" id="plate" placeholder="ABC-1234">
      @error('license_plate')
      {{ $message }}
    @enderror
      </div>
      <div class="col-md-4">
      <label for="kms" class="form-label">Kilometres</label>
      <input name="kilometres" type="number" class="form-control" id="kms" placeholder="120000">
      @error('kilometres')
      {{ $message }}
    @enderror
      </div>
      
      <!-- Service Info -->
      <div class="col-12">
      <label for="asset" class="form-label">Asset Number</label>
      <input name="asset_number" type="text" class="form-control" id="asset" placeholder="Asset #">
      @error('asset_number')
      {{ $message }}
    @enderror
      </div>
      <div class="col-12">
      <label for="complaint" class="form-label">Complaint / Description of Issue</label>
      <textarea name="complaint" class="form-control" id="complaint" rows="4" placeholder="Describe the issue..."
        required></textarea>
      @error('complaint')
      {{ $message }}
    @enderror
      </div>


      <!-- Submit -->
      <div class="col-12">
      <button type="submit" class="btn btn-light">Submit Request</button>
      </div>
    </div>
    </form>
  </div>
  @include('layouts.footers.footer')
@endsection