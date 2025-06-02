<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">  <!-- Include your CSS file -->
</head>
<body>
    <header>
        <!-- Add header content here -->
    </header>

    <main>
        @yield('content')  <!-- This will inject the profile content here -->
    </main>

    <footer>
        <!-- Add footer content here -->
    </footer>
</body>
</html>
