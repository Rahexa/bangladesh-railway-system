<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bangladesh Railway</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }
        .sidebar {
            background: linear-gradient(180deg, #1e3a8a, #3b82f6);
            color: white;
            width: 250px;
            position: fixed;
            height: 100%;
            padding: 2rem 1rem;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            z-index: 1000;
        }
        .sidebar-hidden {
            transform: translateX(-100%);
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.5rem;
            transition: background 0.3s ease;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        .main-content {
            margin-left: 250px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }
        .main-content-full {
            margin-left: 0;
        }
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border-radius: 12px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        th {
            background: #3b82f6;
            color: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background: #10b981;
            color: white;
        }
        .btn-edit:hover {
            background: #059669;
        }
        .btn-delete {
            background: #ef4444;
            color: white;
        }
        .btn-delete:hover {
            background: #b91c1c;
        }
        .toggle-btn {
            position: fixed;
            top: 1rem;
            left: 1rem;
            background: #3b82f6;
            color: white;
            padding: 0.75rem;
            border-radius: 50%;
            cursor: pointer;
            z-index: 1100;
            display: none;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar-visible {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .toggle-btn {
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
        <a href="#overview" class="active"><i class="fas fa-tachometer-alt mr-2"></i> Overview</a>
        <a href="#users"><i class="fas fa-users mr-2"></i> Users</a>
        <a href="#bookings"><i class="fas fa-ticket-alt mr-2"></i> Bookings</a>
        <a href="#trains"><i class="fas fa-train mr-2"></i> Train Schedules</a>
        <a href="#seats"><i class="fas fa-chair mr-2"></i> Seats</a>
        <a href="#coaches"><i class="fas fa-bus mr-2"></i> Coaches</a>
        <a href="#ticket-prices"><i class="fas fa-money-bill mr-2"></i> Ticket Prices</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Toggle Button for Mobile -->
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <!-- Overview Section -->
        <section id="overview">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Dashboard Overview</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-700">Total Users</h3>
                    <p class="text-3xl font-bold text-blue-600" id="total-users">{{ $totalUsers ?? 0 }}</p>
                </div>
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-700">Total Bookings</h3>
                    <p class="text-3xl font-bold text-green-600" id="total-bookings">{{ $totalBookings ?? 0 }}</p>
                </div>
                <div class="card">
                    <h3 class="text-lg font-semibold text-gray-700">Revenue</h3>
                    <p class="text-3xl font-bold text-purple-600" id="total-revenue">৳{{ $totalRevenue ?? 0 }}</p>
                </div>
            </div>
            <div class="card mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Booking Status</h3>
                <canvas id="bookingChart" height="100"></canvas>
            </div>
        </section>

        <!-- Users Section -->
        <section id="users" class="mt-10">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Users</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="users-table">
                        @foreach ($users ?? [] as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    <button class="btn btn-edit" onclick="editUser({{ $user->id }})">Edit</button>
                                    <button class="btn btn-delete" onclick="deleteUser({{ $user->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Bookings Section -->
        <section id="bookings" class="mt-10">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Bookings</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Train</th>
                            <th>From-To</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bookings-table">
                        @foreach ($bookings ?? [] as $booking)
                            <tr>
                                <td>{{ $booking->id }}</td>
                                <td>{{ $booking->name }}</td>
                                <td>{{ $booking->train_name }}</td>
                                <td>{{ $booking->from }} - {{ $booking->to }}</td>
                                <td>{{ $booking->date }}</td>
                                <td>{{ $booking->status }}</td>
                                <td>
                                    <button class="btn btn-edit" onclick="editBooking({{ $booking->id }})">Edit</button>
                                    <button class="btn btn-delete" onclick="deleteBooking({{ $booking->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script>
        // Sidebar Toggle for Mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            sidebar.classList.toggle('sidebar-visible');
            sidebar.classList.toggle('sidebar-hidden');
            mainContent.classList.toggle('main-content-full');
        }

        // Chart.js for Booking Status
        const ctx = document.getElementById('bookingChart').getContext('2d');
        const bookingChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Confirmed', 'Pending', 'Cancelled'],
                datasets: [{
                    data: [{{ $confirmedBookings ?? 0 }}, {{ $pendingBookings ?? 0 }}, {{ $cancelledBookings ?? 0 }}],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                }
            }
        });

        // Placeholder Functions for Edit/Delete
        function editUser(id) { alert(`Edit User ID: ${id}`); }
        function deleteUser(id) { if (confirm(`Delete User ID: ${id}?`)) { /* AJAX Delete */ } }
        function editBooking(id) { alert(`Edit Booking ID: ${id}`); }
        function deleteBooking(id) { if (confirm(`Delete Booking ID: ${id}?`)) { /* AJAX Delete */ } }
    </script>
</body>
</html>