<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <style>
    body      { font-family:Arial,sans-serif; background:#f9fafb; margin:0; padding:20px; }
    .card     { background:#fff; border-radius:12px; max-width:520px; margin:0 auto;
                border:1px solid #e5e7eb; overflow:hidden; }
    .header   { background:#4f46e5; padding:24px 28px; }
    .header h1{ color:#fff; font-size:16px; margin:0 0 2px; font-weight:700; }
    .header p { color:#c7d2fe; font-size:12px; margin:0; }
    .body     { padding:28px; }
    .greeting { font-size:15px; color:#111827; font-weight:600; margin-bottom:6px; }
    .sub      { font-size:13px; color:#6b7280; margin-bottom:20px; line-height:1.6; }
    .section  { margin-bottom:20px; }
    .sec-title{ font-size:11px; color:#6b7280; text-transform:uppercase;
                letter-spacing:0.5px; margin-bottom:10px; font-weight:600; }
    .item     { background:#f9fafb; border:1px solid #e5e7eb; border-radius:8px;
                padding:12px 14px; margin-bottom:8px; }
    .item-name{ font-size:13px; color:#111827; font-weight:600; margin-bottom:2px; }
    .item-note{ font-size:12px; color:#d97706; }
    .badge-p  { display:inline-block; background:#fef3c7; color:#d97706;
                border:1px solid #fde68a; border-radius:4px; padding:2px 8px;
                font-size:11px; font-weight:600; }
    .badge-e  { display:inline-block; background:#ffedd5; color:#ea580c;
                border:1px solid #fed7aa; border-radius:4px; padding:2px 8px;
                font-size:11px; font-weight:600; }
    .btn      { display:inline-block; background:#4f46e5; color:#fff;
                text-decoration:none; padding:12px 24px; border-radius:8px;
                font-size:13px; font-weight:600; }
    .footer   { background:#f9fafb; border-top:1px solid #e5e7eb;
                padding:14px 28px; text-align:center; }
    .footer p { font-size:11px; color:#9ca3af; margin:0; }
  </style>
</head>
<body>
<div class="card">
  <div class="header">
    <h1>{{ config('brand.name') }}</h1>
    <p>Daily Activity Summary — {{ now()->format('D, d M Y') }}</p>
  </div>
  <div class="body">
    <p class="greeting">Hello {{ $user->name }},</p>
    <p class="sub">
      Here's your daily summary. You have entries that need your attention today.
    </p>

    @if($pendingCount > 0)
    <div class="section">
      <p class="sec-title">⏳ Pending Entries ({{ $pendingCount }})</p>
      <div class="item">
        <div class="item-name">{{ $pendingCount }} {{ $pendingCount === 1 ? 'entry is' : 'entries are' }} pending review</div>
        <div style="margin-top:4px;"><span class="badge-p">Pending</span></div>
      </div>
    </div>
    @endif

    @if($editRequests->count() > 0)
    <div class="section">
      <p class="sec-title">✏ Edit Requested ({{ $editRequests->count() }})</p>
      @foreach($editRequests as $sub)
      <div class="item">
        <div class="item-name">{{ $sub->registerName() }}</div>
        <div class="item-note">Manager note: {{ $sub->review_note }}</div>
        <div style="margin-top:4px;"><span class="badge-e">Edit Required</span></div>
      </div>
      @endforeach
    </div>
    @endif

    <a href="{{ route('submissions.index') }}" class="btn">
      View My Entries →
    </a>
  </div>
  <div class="footer">
    <p>{{ config('brand.name') }} · {{ config('brand.location') }}</p>
    <p style="margin-top:4px;">Sent daily at 5:00 PM on weekdays.</p>
  </div>
</div>
</body>
</html>