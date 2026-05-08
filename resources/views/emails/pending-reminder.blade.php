<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <style>
    body        { font-family:Arial,sans-serif; background:#f9fafb; margin:0; padding:20px; }
    .card       { background:#fff; border-radius:12px; max-width:560px; margin:0 auto;
                  border:1px solid #e5e7eb; overflow:hidden; }
    .header     { background:#4f46e5; padding:24px 28px; }
    .header h1  { color:#fff; font-size:16px; margin:0 0 2px; font-weight:700; }
    .header p   { color:#c7d2fe; font-size:12px; margin:0; }
    .body       { padding:28px; }
    .greeting   { font-size:15px; color:#111827; font-weight:600; margin-bottom:6px; }
    .sub        { font-size:13px; color:#6b7280; margin-bottom:20px; line-height:1.6; }
    .stat-box   { background:#fef3c7; border:1px solid #fde68a; border-radius:10px;
                  padding:16px 20px; margin-bottom:20px; display:flex;
                  align-items:center; gap:16px; }
    .stat-num   { font-size:36px; font-weight:800; color:#d97706; line-height:1; }
    .stat-label { font-size:13px; color:#92400e; }
    .table-wrap { border:1px solid #e5e7eb; border-radius:8px;
                  overflow:hidden; margin-bottom:20px; }
    table       { width:100%; border-collapse:collapse; font-size:12px; }
    th          { background:#f9fafb; padding:9px 12px; text-align:left;
                  color:#6b7280; font-weight:600; border-bottom:1px solid #e5e7eb; }
    td          { padding:9px 12px; color:#374151;
                  border-bottom:1px solid #f3f4f6; }
    tr:last-child td { border-bottom:none; }
    .badge      { display:inline-block; background:#fef3c7; color:#d97706;
                  border:1px solid #fde68a; border-radius:4px;
                  padding:2px 8px; font-size:11px; font-weight:600; }
    .btn        { display:inline-block; background:#4f46e5; color:#fff;
                  text-decoration:none; padding:13px 28px; border-radius:8px;
                  font-size:13px; font-weight:600; }
    .footer     { background:#f9fafb; border-top:1px solid #e5e7eb;
                  padding:14px 28px; text-align:center; }
    .footer p   { font-size:11px; color:#9ca3af; margin:0; }
    .time-note  { font-size:11px; color:#9ca3af; margin-top:16px; text-align:center; }
  </style>
</head>
<body>
<div class="card">

  <div class="header">
    <h1>{{ config('brand.name') }}</h1>
    <p>Daily Pending Review Reminder — {{ now()->format('D, d M Y') }}</p>
  </div>

  <div class="body">
    <p class="greeting">Hello {{ $manager->name }},</p>
    <p class="sub">
      This is your daily reminder. You have logbook entries waiting for your review.
      Please take a moment to process them before end of day.
    </p>

    <!-- Stat -->
    <div class="stat-box">
      <div class="stat-num">{{ $pendingCount }}</div>
      <div>
        <div class="stat-label" style="font-weight:700; font-size:14px;">
          Pending {{ $pendingCount === 1 ? 'Entry' : 'Entries' }}
        </div>
        <div class="stat-label">Awaiting your review</div>
      </div>
    </div>

    <!-- Pending entries table -->
    @if($pendingSubmissions->count() > 0)
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Register</th>
            <th>Submitted By</th>
            <th>Submitted</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pendingSubmissions->take(10) as $sub)
          <tr>
            <td>{{ $sub->registerName() }}</td>
            <td>{{ $sub->user->name }}</td>
            <td>{{ $sub->created_at->format('d M Y H:i') }}</td>
            <td><span class="badge">Pending</span></td>
          </tr>
          @endforeach
          @if($pendingSubmissions->count() > 10)
          <tr>
            <td colspan="4" style="text-align:center; color:#9ca3af; font-style:italic;">
              ... and {{ $pendingSubmissions->count() - 10 }} more entries
            </td>
          </tr>
          @endif
        </tbody>
      </table>
    </div>
    @endif

    <a href="{{ route('manager.dashboard') }}" class="btn">
      Review Now →
    </a>

    <p class="time-note">
      Sent at 5:00 PM · {{ config('brand.name') }}
    </p>
  </div>

  <div class="footer">
    <p>{{ config('brand.name') }} · {{ config('brand.location') }}</p>
    <p style="margin-top:4px;">
      You receive this because you are a manager.
      Emails only sent when pending entries exist.
    </p>
  </div>

</div>
</body>
</html>