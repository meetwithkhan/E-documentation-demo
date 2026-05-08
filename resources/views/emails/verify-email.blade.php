<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8"/>
  <style>
    body        { font-family: Arial, sans-serif; background: #f9fafb;
                  margin: 0; padding: 20px; }
    .card       { background: #ffffff; border-radius: 12px; max-width: 520px;
                  margin: 0 auto; border: 1px solid #e5e7eb; overflow: hidden; }
    .header     { background: #4f46e5; padding: 28px; text-align: center; }
    .header h1  { color: #ffffff; font-size: 18px; margin: 0 0 4px; font-weight: 700; }
    .header p   { color: #c7d2fe; font-size: 12px; margin: 0; }
    .body       { padding: 32px 28px; text-align: center; }
    .avatar     { width: 56px; height: 56px; background: #4f46e5; border-radius: 50%;
                  display: inline-flex; align-items: center; justify-content: center;
                  font-size: 20px; font-weight: 700; color: white; margin-bottom: 16px; }
    .body h2    { font-size: 18px; color: #111827; margin: 0 0 8px; }
    .body p     { font-size: 13px; color: #6b7280; margin: 0 0 24px; line-height: 1.6; }
    .btn        { display: inline-block; background: #4f46e5; color: #ffffff;
                  text-decoration: none; padding: 14px 32px; border-radius: 8px;
                  font-size: 14px; font-weight: 600; margin-bottom: 24px; }
    .divider    { border: none; border-top: 1px solid #e5e7eb; margin: 24px 0; }
    .info-box   { background: #f3f4f6; border-radius: 8px; padding: 16px;
                  text-align: left; margin-bottom: 20px; }
    .info-row   { display: flex; justify-content: space-between; margin-bottom: 8px; }
    .info-row:last-child { margin-bottom: 0; }
    .info-label { font-size: 11px; color: #9ca3af; text-transform: uppercase; }
    .info-value { font-size: 12px; color: #374151; font-weight: 600; }
    .link-text  { font-size: 11px; color: #9ca3af; word-break: break-all; }
    .footer     { background: #f9fafb; border-top: 1px solid #e5e7eb;
                  padding: 16px 28px; text-align: center; }
    .footer p   { font-size: 11px; color: #9ca3af; margin: 0; }
    .warning    { font-size: 12px; color: #d97706; margin-top: 16px; }
  </style>
</head>
<body>
<div class="card">

  <!-- Header -->
  <div class="header">
    <h1>{{ config('brand.name') }}</h1>
    <p>{{ config('brand.location') }}</p>
  </div>

  <!-- Body -->
  <div class="body">

    <!-- Avatar -->
    <div class="avatar">
      {{ strtoupper(substr($user->name, 0, 2)) }}
    </div>

    <h2>Verify your email address</h2>
    <p>
      Hi <strong>{{ $user->name }}</strong>, your account has been created.<br>
      Please verify your email address to activate your account and get started.
    </p>

    <!-- User Info Box -->
    <div class="info-box">
      <div class="info-row">
        <span class="info-label">Employee ID: </span>
        <span class="info-value">{{ $user->employee_id ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Department: </span>
        <span class="info-value">{{ $user->department?->name ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Function: </span>
        <span class="info-value">{{ $user->function?->name ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Designation: </span>
        <span class="info-value">{{ $user->designation?->name ?? '—' }}</span>
      </div>
    </div>

    <!-- CTA Button -->
    <a href="{{ $url }}" class="btn" style="color: #ffffff; text-decoration: none;">
        Verify Email Address
    </a>

    <hr class="divider"/>

    <p class="link-text">
      If the button doesn't work, copy and paste this link:<br>
      <a href="{{ $url }}" style="color:#4f46e5;">{{ $url }}</a>
    </p>

    <p class="warning">
      ⏱ This link expires in 60 minutes.
      If you did not expect this email, please ignore it.
    </p>

  </div>

  <!-- Footer -->
  <div class="footer">
    <p>{{ config('brand.name') }} · {{ config('brand.location') }}</p>
    <p style="margin-top:4px;">This is an automated message, please do not reply.</p>
  </div>

</div>
</body>
</html>