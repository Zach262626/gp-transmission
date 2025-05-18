<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Submission Result</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px;">
  <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; color: #333;">Submission Details</h2>
    <table style="width: 100%; border-collapse: collapse;">
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Name:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['name'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Date:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['date'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Email:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['email'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Phone:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['phone'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Year:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['year'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Make:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['make'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Model:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['model'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">VIN:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['VIN'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">License Plate:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['license_plate'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Kilometres:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ number_format($data['kilometres']) }} km</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-bottom: 1px solid #ddd;">Asset Number:</td>
        <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $data['asset_number'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; vertical-align: top;">Complaint:</td>
        <td style="padding: 8px;">{{ $data['complaint'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold; border-top: 1px solid #ddd;">Created At:</td>
        <td style="padding: 8px; border-top: 1px solid #ddd;">{{ $data['created_at'] }}</td>
      </tr>
      <tr>
        <td style="padding: 8px; font-weight: bold;">Updated At:</td>
        <td style="padding: 8px;">{{ $data['updated_at'] }}</td>
      </tr>
    </table>
  </div>
</body>
</html>
