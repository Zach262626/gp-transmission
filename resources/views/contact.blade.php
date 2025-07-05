@extends('layouts.app', ['activePage' => 'ContactPage', 'type' => 'contact']) {{-- **IMPORTANT TO ADD activePage for styling** --}}
@section('content')
  <div class="container mt-5 text-light">
    <h2 class="mb-4 contact-form">Customer Information Form</h2>
    <form method="post" action="{{ route('customerInformationCreate') }}">
      @csrf

      @if ($errors->any())
        <div class="alert alert-danger">
          <strong>There were some problems with your submission.</strong>
        </div>
      @endif

      <div class="row g-3">

        <!-- Personal Info -->
        <div class="col-md-3">
          <label for="name" class="form-label">Full Name</label>
          <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
            id="name" placeholder="John Doe" value="{{ old('name') }}" required>
          @error('name')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-5">
          <label for="email" class="form-label">Email</label>
          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror"
            id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
          @error('email')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="phone" class="form-label">Phone</label>
          <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
            id="phone" placeholder="(555) 123-4567" value="{{ old('phone') }}" required>
          @error('phone')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Vehicle Details -->
        <div class="col-md-2">
          <label for="year" class="form-label">Year</label>
          <input name="year" type="number" class="form-control @error('year') is-invalid @enderror"
            id="year" placeholder="2020" min="1900" max="2099" step="1" value="{{ old('year') }}" required>
          @error('year')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-5">
          <label for="make" class="form-label">Make</label>
          <input name="make" type="text" class="form-control @error('make') is-invalid @enderror"
            id="make" placeholder="Toyota" value="{{ old('make') }}" required>
          @error('make')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-5">
          <label for="model" class="form-label">Model</label>
          <input name="model" type="text" class="form-control @error('model') is-invalid @enderror"
            id="model" placeholder="Corolla" value="{{ old('model') }}" required>
          @error('model')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="vin" class="form-label">VIN (optional)</label>
          <input name="vin" type="text" class="form-control @error('vin') is-invalid @enderror"
            id="vin" maxlength="17" placeholder="1HGCM82633A004352" value="{{ old('vin') }}">
          @error('vin')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="license_plate" class="form-label">License Plate (optional)</label>
          <input name="license_plate" type="text" class="form-control @error('license_plate') is-invalid @enderror"
            id="license_plate" placeholder="ABC-1234" value="{{ old('license_plate') }}">
          @error('license_plate')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-md-4">
          <label for="kilometres" class="form-label">Kilometres (optional)</label>
          <input name="kilometres" type="number" class="form-control @error('kilometres') is-invalid @enderror"
            id="kilometres" placeholder="120000" value="{{ old('kilometres') }}">
          @error('kilometres')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Service Info -->
        <div class="col-12">
          <label for="asset_number" class="form-label">Asset Number (optional)</label>
          <input name="asset_number" type="text" class="form-control @error('asset_number') is-invalid @enderror"
            id="asset_number" placeholder="Asset #" value="{{ old('asset_number') }}">
          @error('asset_number')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12">
          <label for="complaint" class="form-label">Description of Issue</label>
          <textarea name="complaint" class="form-control @error('complaint') is-invalid @enderror"
            id="complaint" rows="4" placeholder="Describe the issue..." required>{{ old('complaint') }}</textarea>
          @error('complaint')
            <div class="invalid-feedback d-block text-danger">{{ $message }}</div>
          @enderror
        </div>

        <!-- Submit -->
        <div class="col-12">
          <button type="submit" class="btn btn-light">Submit Request</button>
        </div>
      </div>
    </form>
  </div>
@endsection
