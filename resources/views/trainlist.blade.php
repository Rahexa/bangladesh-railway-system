<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Train List - Railway System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #e9ecef;
    }

    .hero-section {
      background: linear-gradient(135deg, #003087 0%, #00a3b5 100%);
      color: white;
      padding: 5rem 0;
      text-align: center;
      border-radius: 0 0 60px 60px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
    }

    .filter-bar {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      position: sticky;
      top: 20px;
      z-index: 1000;
      margin-bottom: 2.5rem;
    }

    .train-card {
      background-color: #ffffff;
      border: none;
      border-radius: 16px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      opacity: 0;
      animation: fadeIn 0.6s ease forwards;
    }

    .train-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
    }

    .train-card .badge {
      font-size: 0.85rem;
      padding: 0.4rem 0.8rem;
      border-radius: 12px;
    }

    .btn-search {
      background: linear-gradient(90deg, #f59e0b, #d97706);
      border: none;
      transition: background 0.3s ease;
    }

    .btn-search:hover {
      background: linear-gradient(90deg, #d97706, #b45309);
    }

    .progress {
      height: 10px;
      border-radius: 12px;
      background-color: #e2e8f0;
    }

    .progress-bar {
      background-color: #00a3b5;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .train-card:nth-child(1) {
      animation-delay: 0.1s;
    }

    .train-card:nth-child(2) {
      animation-delay: 0.2s;
    }

    .train-card:nth-child(3) {
      animation-delay: 0.3s;
    }

    .icon-text {
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    /* Floating Button */
    .floating-button {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
      padding: 12px 20px;
      border-radius: 30px;
      background-color: #0d6efd;
      color: #fff;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .floating-button:hover {
      background-color: #0b5ed7;
      color: #fff;
    }
  </style>
</head>
<body>

  <!-- Hero Section -->
  <div class="hero-section">
    <div class="container">
      <h1 class="display-4 fw-bold mb-3">Explore Our Train List</h1>
      <p class="lead mb-4">Find the perfect train for your journey with our comprehensive train list.</p>
    </div>
  </div>

  <!-- Filter Bar and Train List -->
  <div class="container my-5">
    <div class="filter-bar">
      <form method="GET" action="{{ route('trainlist') }}">
        <div class="row g-3">
          <div class="col-md-3">
            <label for="from_station" class="form-label fw-medium">From Station</label>
            <select name="from_station" id="from_station" class="form-select">
              <option value="">All Stations</option>
              @foreach ($stations as $station)
              <option value="{{ $station }}" {{ request('from_station') == $station ? 'selected' : '' }}>{{ $station }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="to_station" class="form-label fw-medium">To Station</label>
            <select name="to_station" id="to_station" class="form-select">
              <option value="">All Stations</option>
              @foreach ($stations as $station)
              <option value="{{ $station }}" {{ request('to_station') == $station ? 'selected' : '' }}>{{ $station }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label for="date" class="form-label fw-medium">Travel Date</label>
            <input type="date" name="date" id="date" value="{{ request('date') }}" class="form-control" />
          </div>
          <div class="col-md-3">
            <label for="class" class="form-label fw-medium">Class</label>
            <select name="class" id="class" class="form-select">
              <option value="">All Classes</option>
              @foreach ($classes as $class)
              <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>{{ $class }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 mt-4 text-center">
            <button type="submit" class="btn btn-search text-white fw-semibold px-5 py-2">
              <i class="bi bi-train-front-fill me-2"></i>Find Trains
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Train List -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
      @forelse ($trains as $train)
      <div class="col">
        <div class="train-card card h-100">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title mb-0 fw-bold">{{ $train->train_name }}</h5>
              <span class="badge bg-info text-dark">{{ $train->train_type }}</span>
            </div>
            <p class="card-text icon-text text-muted">
              <i class="bi bi-geo-alt-fill"></i>{{ $train->from_station }} → {{ $train->to_station }}
            </p>
            <p class="card-text icon-text">
              <i class="bi bi-clock-fill"></i>{{ \Carbon\Carbon::parse($train->departure_time)->format('h:i A') }} -
              {{ \Carbon\Carbon::parse($train->arrival_time)->format('h:i A') }}
            </p>
            <p class="card-text icon-text">
              <i class="bi bi-chair"></i>{{ $train->seats->where('status', 'available')->count() }} Seats Available
            </p>
            @if ($train->price && request('class'))
            <p class="card-text icon-text text-success fw-bold">
              <i class="bi bi-currency-dollar"></i>{{ number_format($train->price->{strtolower(request('class'))}, 2) }} BDT ({{ request('class') }})
            </p>
            @endif
            <div class="mt-4">
              <small class="text-muted">Seat Availability</small>
              <div class="progress mt-1">
                <div class="progress-bar" role="progressbar"
                     style="width: {{ $train->seats->count() ? ($train->seats->where('status', 'available')->count() / $train->seats->count() * 100) : 0 }}%"
                     aria-valuenow="{{ $train->seats->where('status', 'available')->count() }}"
                     aria-valuemin="0" aria-valuemax="{{ $train->seats->count() ?: 1 }}"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @empty
      <div class="col-12">
        <p class="text-muted text-center py-5 fs-5">
          <i class="bi bi-info-circle me-2"></i>No trains found. Try adjusting your search criteria.
        </p>
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-5 d-flex justify-content-center">
      {{ $trains->links() }}
    </div>
  </div>

  <!-- Floating Button -->
  <a href="{{ route('dashboard') }}" class="floating-button">
    <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
  </a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
