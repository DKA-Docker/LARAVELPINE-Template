<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
        .header { background-color: #f8f9fa; padding: 15px; border-bottom: 1px solid #ddd; text-align: center; }
        .content { padding: 20px 0; }
        .footer { font-size: 12px; color: #777; text-align: center; margin-top: 20px; border-top: 1px solid #eee; padding-top: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #eee; }
        .badge { display: inline-block; padding: 3px 6px; border-radius: 4px; font-size: 12px; font-weight: bold; background: #e3e3e3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Delivery Request Created</h2>
        </div>
        <div class="content">
            <p>Dear {{ $user->information->first_name ?? $user->contact->email }},</p>
            <p>Your delivery request has been successfully created. Here are the details:</p>
            
            <h3>Request Information</h3>
            <table>
                <tr>
                    <th>Request Name</th>
                    <td>{{ $requestOrder->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Urgency</th>
                    <td>{{ $requestOrder->urgent ?? 'Normal' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $requestOrder->status ?? 'Draft' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $requestOrder->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>

            @if($requestOrder->destinations && $requestOrder->destinations->count() > 0)
                <h3>Destinations</h3>
                @foreach($requestOrder->destinations as $index => $destination)
                    <div style="background: #fafafa; padding: 10px; margin-bottom: 10px; border: 1px solid #eee; border-radius: 4px;">
                        <strong>#{{ $index + 1 }} To: {{ $destination->receipt_name ?? 'N/A' }}</strong><br>
                        <small>{{ $destination->receipt_address ?? 'No Address' }}</small>
                        
                        @if($destination->packages && $destination->packages->count() > 0)
                            <div style="margin-top: 5px; padding-left: 10px; border-left: 3px solid #ddd;">
                                <small>Packages:</small>
                                <ul style="margin: 5px 0; padding-left: 20px;">
                                    @foreach($destination->packages as $pkg)
                                        <li>{{ $pkg->name }} ({{ $pkg->qty }} {{ $pkg->unit }}) - {{ $pkg->weight }}kg</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p><small><em>No packages listed.</em></small></p>
                        @endif
                    </div>
                @endforeach
            @endif

            <p>Thank you for using our service.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
