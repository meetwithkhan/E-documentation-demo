<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <style>
    body        { font-family: Arial, sans-serif; background: #f9fafb; margin: 0; padding: 20px; }
    .card       { background: #ffffff; border-radius: 12px; max-width: 520px; margin: 0 auto;
                  border: 1px solid #e5e7eb; overflow: hidden; }
    .header     { background: #4f46e5; padding: 24px 28px; }
    .header h1  { color: #ffffff; font-size: 16px; margin: 0; font-weight: 600; }
    .header p   { color: #c7d2fe; font-size: 12px; margin: 4px 0 0; }
    .body       { padding: 24px 28px; }
    .label      { font-size: 11px; color: #6b7280; text-transform: uppercase;
                  letter-spacing: 0.5px; margin-bottom: 4px; }
    .value      { font-size: 14px; color: #111827; margin-bottom: 16px; font-weight: 500; }
    .reason-box { background: #fef3c7; border: 1px solid #fde68a; border-radius: 8px;
                  padding: 12px 16px; margin-bottom: 20px; }
    .reason-box p { font-size: 13px; color: #92400e; margin: 0; }
    .btn        { display: inline-block; background: #4f46e5; color: #ffffff;
                  text-decoration: none; padding: 12px 24px; border-radius: 8px;
                  font-size: 13px; font-weight: 600; }
    .footer     { background: #f9fafb; border-top: 1px solid #e5e7eb;
                  padding: 16px 28px; text-align: center; }
    .footer p   { font-size: 11px; color: #9ca3af; margin: 0; }
    .meta       { font-size: 12px; color: #6b7280; margin-top: 20px; }
    .tag        { display: inline-block; background: #fee2e2; color: #dc2626;
                  border-radius: 4px; padding: 2px 8px; font-size: 11px;
                  font-weight: 600; }
  </style>
</head>
<body>
<div class="card">

  <!-- Header -->
  <div class="header">
    <h1>{{ config('brand.name') }}</h1>
    <p>Account Deletion Request — Admin Approval Required</p>
  </div>

  <!-- Body -->
  <div class="body">
    <p style="font-size:14px; color:#374151; margin-bottom:20px;">
      A manager has submitted a request to delete another manager's account.
      Your approval is required to proceed.
    </p>

    <!-- Target User -->
    <div class="label">User to be Deleted</div>
    <div class="value">
      {{ $deletionRequest->targetUser->name }}
      <span class="tag">Manager</span>
    </div>

    <div class="label">Employee ID</div>
    <div class="value">{{ $deletionRequest->targetUser->employee_id ?? '—' }}</div>

    <div class="label">Email</div>
    <div class="value">{{ $deletionRequest->targetUser->email }}</div>

    <div class="label">Department / Function</div>
    <div class="value">
      {{ $deletionRequest->targetUser->department?->name ?? '—' }}
      /
      {{ $deletionRequest->targetUser->function?->name ?? '—' }}
    </div>

    <!-- Divider -->
    <hr style="border:none; border-top:1px solid #e5e7eb; margin: 4px 0 16px;"/>

    <!-- Requester -->
    <div class="label">Requested By</div>
    <div class="value">
      {{ $deletionRequest->requester->name }}
      ({{ $deletionRequest->requester->email }})
    </div>

    <div class="label">Submitted</div>
    <div class="value">{{ $deletionRequest->created_at->format('D, d M Y H:i') }}</div>

    <!-- Reason -->
    <div class="label">Reason</div>
    <div class="reason-box">
      <p>"{{ $deletionRequest->reason }}"</p>
    </div>

    <!-- CTA -->
    <a href="{{ route('deletion-requests.index') }}" class="btn">
      Review Request →
    </a>

    <p class="meta">
      You are receiving this email because you have admin access to
      {{ config('brand.name') }}.
    </p>
  </div>

  <!-- Footer -->
  <div class="footer">
    <p>{{ config('brand.name') }} · {{ config('brand.location') }}</p>
  </div>

</div>
</body>
</html>