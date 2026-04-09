<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin_style.css') }}">
</head>
<body>

<div class="d-flex">

    {{-- Sidebar --}}
    @include('admin.sidebar')

    <div class="flex-grow-1">

        {{-- Navbar --}}
        @include('admin.navbar')

        {{-- Content --}}
        <main class="p-4">
            @yield('content')
        </main>

    </div>
    @include('admin.user')
</div>
</body>
</html>