<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        /* Base Reset */
        body { background-color: #f5f8fa; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; height: 100% !important; width: 100% !important; }
        
        /* Layout */
        .wrapper { width: 100%; table-layout: fixed; background-color: #f5f8fa; padding-bottom: 0; }
        .container { max-width: 100%; margin: 0; background-color: #ffffff; border-radius: 0; overflow: hidden; box-shadow: none; }
        
        /* Content Styling */
        .content { padding: 40px; }
        .header-strip { height: 4px; background: linear-gradient(90deg, #009ef7 0%, #0064b8 100%); width: 100%; }
        
        h1 { color: #181c32; font-size: 24px; font-weight: 700; margin: 0 0 20px 0; letter-spacing: -0.5px; }
        h2 { color: #3f4254; font-size: 18px; font-weight: 600; margin: 30px 0 15px 0; }
        p { color: #5e6278; font-size: 14px; line-height: 1.6; margin: 0 0 15px 0; }
        
        /* Info Grid */
        .info-grid { display: flex; flex-wrap: wrap; margin-bottom: 20px; background: #f9f9f9; border-radius: 6px; padding: 15px; border: 1px solid #f1f1f4; }
        .info-item { width: 50%; padding-bottom: 10px; box-sizing: border-box; }
        .info-label { display: block; font-size: 12px; color: #a1a5b7; text-transform: uppercase; font-weight: 600; margin-bottom: 4px; }
        .info-value { display: block; font-size: 14px; color: #181c32; font-weight: 500; }
        
        /* Badges */
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; display: inline-block; }
        .badge-urgent-high { background-color: #ffe2e5; color: #f1416c; }
        .badge-urgent-normal { background-color: #e8fff3; color: #50cd89; }
        .badge-status { background-color: #f1faff; color: #009ef7; }
        
        /* Cards */
        .card { background: #ffffff; border: 1px solid #eeffff; border-radius: 6px; margin-bottom: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
        .card-header { background: #f9f9f9; padding: 12px 15px; border-bottom: 1px dashed #e4e6ef; border-radius: 6px 6px 0 0; }
        .card-title { font-weight: 600; color: #181c32; font-size: 14px; }
        .card-subtitle { font-size: 12px; color: #7e8299; display: block; margin-top: 2px; }
        .card-body { padding: 15px; }
        
        /* Package List */
        .pkg-list { list-style: none; padding: 0; margin: 0; }
        .pkg-item { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f4f6fa; font-size: 13px; color: #5e6278; }
        .pkg-item:last-child { border-bottom: none; padding-bottom: 0; }
        .pkg-qty { font-weight: 600; color: #181c32; margin-right: 5px; }
        
        /* Footer */
        .footer { text-align: center; padding: 20px; color: #b5b5c3; font-size: 12px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <br>
        <div class="container">
            <div class="header-strip"></div>
            <div class="content">
                <h1>Delivery Request Created</h1>
                <p>Dear {{ $user->information->first_name ?? $user->getRelationValue('contact')?->email }},</p>
                <p>Your delivery request has been successfully created. Below are the details of your submission.</p>

                <!-- Summary Grid -->
                <h2>Request Summary</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Request Name</span>
                        <span class="info-value">{{ $requestOrder->name ?? '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Created At</span>
                        <span class="info-value">{{ $requestOrder->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="info-item" style="padding-bottom: 0;">
                        <span class="info-label">Urgency</span>
                        <span class="badge {{ ($requestOrder->urgent === 'High') ? 'badge-urgent-high' : 'badge-urgent-normal' }}">
                            {{ $requestOrder->urgent ?? 'Normal' }}
                        </span>
                    </div>
                    <div class="info-item" style="padding-bottom: 0;">
                        <span class="info-label">Status</span>
                        <span class="badge badge-status">{{ $requestOrder->status ?? 'Draft' }}</span>
                    </div>
                </div>

                <!-- Destinations -->
                @if($requestOrder->destinations && $requestOrder->destinations->count() > 0)
                    <h2>Destinations ({{ $requestOrder->destinations->count() }})</h2>
                    @foreach($requestOrder->destinations as $index => $destination)
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">#{{ $index + 1 }} {{ $destination->receipt_name ?? 'N/A' }}</span>
                                <span class="card-subtitle">{{ $destination->receipt_address ?? 'No Address Provided' }}</span>
                            </div>
                            <div class="card-body">
                                @if($destination->packages && $destination->packages->count() > 0)
                                    <ul class="pkg-list">
                                        @foreach($destination->packages as $pkg)
                                            <li class="pkg-item">
                                                <span>
                                                    <span class="pkg-qty">{{ $pkg->qty }} {{ $pkg->unit?->name ?? 'pcs' }}</span>
                                                    {{ $pkg->name }}
                                                </span>
                                                <span>{{ $pkg->weight }} kg</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p style="margin:0; font-style:italic; font-size:12px; color:#b5b5c3;">No packages listed.</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
                
                <div style="margin-top: 30px; border-top: 1px solid #f1f1f4; padding-top: 20px;">
                    <p style="margin-bottom: 0;">Thank you for using <strong>{{ config('app.name') }}</strong>.</p>
                </div>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
