<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>403 — Access Denied</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center">
  <div class="text-center">
    <p class="text-6xl font-medium text-indigo-600 mb-4">403</p>
    <h1 class="text-xl font-medium text-gray-200 mb-2">Access Denied</h1>
    <p class="text-sm text-gray-500 mb-6">You don't have permission to view this page.</p>
    <a href="{{ route('dashboard') }}"
       class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
              px-5 py-2.5 rounded-lg transition-colors">
      Go to Dashboard
    </a>
  </div>
</body>
</html>