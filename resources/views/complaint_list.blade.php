@auth
@extends('layouts.app', ['activePage' => 'ComplaintList'])
@section('content')
  <div style="max-width: 800px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
    <h1 style="text-align: center; color: #333;">All Submissions</h1>
    @if($submissions->isEmpty())
      <p style="text-align: center; color: #999;">No submissions yet.</p>
    @else
    <ul style="list-style: none; padding: 0;">
      @foreach($submissions as $data)
        <li style="border-bottom: 1px solid #ddd; padding: 12px 0;">
          <h2 style="margin: 0 0 6px; font-size: 1.2em; color: #555;">{{ $data['name'] }}</h2>
          <p style="margin: 4px 0;"><strong>Email:</strong> {{ $data['email'] }} | <strong>Phone:</strong> {{ $data['phone'] }}</p>
          <p style="margin: 4px 0;"><strong>Vehicle:</strong> {{ $data['year'] }} {{ $data['make'] }} {{ $data['model'] }} (VIN: {{ $data['vin'] ?? 'N/A' }})</p>
          <p style="margin: 4px 0;"><strong>License Plate:</strong> {{ $data['license_plate'] ?? 'N/A' }} | <strong>Kilometres:</strong> {{ isset($data['kilometres']) ? number_format($data['kilometres']) . ' km' : 'N/A' }}</p>
          <p style="margin: 4px 0;"><strong>Asset #:</strong> {{ $data['asset_number'] ?? 'N/A' }}</p>
          <p style="margin: 4px 0; color: #444;"><strong>Complaint:</strong> {{ Str::limit($data['complaint'], 100) }}</p>
          <p style="margin: 4px 0; font-size: 0.9em; color: #999;"><em>Created:</em> {{ $data['created_at'] }} | <em>Updated:</em> {{ $data['updated_at'] }}</p>
        </li>
      @endforeach
    </ul>
    @endif
  </div>
@endsection
@endauth