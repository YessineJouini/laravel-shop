@extends('layout')

@section('title', 'Analytics')

@section('content_header')
<h1 class="mb-4"><i class="fas fa-chart-line"></i> Analytics Dashboard</h1>
@stop

@section('content')
<div class="row">
  <!-- Stats Cards -->
  <div class="col-12">
    <div class="row g-4">
      <!-- Total Users -->
      <div class="col-md-3">
        <div class="card border-0 bg-primary text-white shadow-sm h-100">
          <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white-50">Total Users</h6>
              <h2 class="fw-bold">{{ number_format($totalUsers) }}</h2>
            </div>
            <i class="fas fa-users fa-2x opacity-50"></i>
          </div>
        </div>
      </div>

      <!-- Total Revenue -->
      <div class="col-md-3">
        <div class="card border-0 bg-success text-white shadow-sm h-100">
          <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white-50">Total Revenue</h6>
              <h2 class="fw-bold">${{ number_format($totalRevenue, 2) }}</h2>
            </div>
            <i class="fas fa-dollar-sign fa-2x opacity-50"></i>
          </div>
        </div>
      </div>

      <!-- Average Order Value -->
      <div class="col-md-3">
        <div class="card border-0 bg-info text-white shadow-sm h-100">
          <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white-50">Avg. Order Value</h6>
              <h2 class="fw-bold">${{ number_format($avgOrder, 2) }}</h2>
            </div>
            <i class="fas fa-shopping-cart fa-2x opacity-50"></i>
          </div>
        </div>
      </div>

      <!-- Conversion Rate -->
      <div class="col-md-3">
        <div class="card border-0 bg-warning text-white shadow-sm h-100">
          <div class="card-body p-4 d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white-50">Conversion Rate</h6>
              <h2 class="fw-bold">{{ $conversionRate }}%</h2>
            </div>
            <i class="fas fa-chart-pie fa-2x opacity-50"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Row 1 -->
  <div class="col-lg-6 mt-5 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i> New Users (Last 7 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="usersChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mt-5 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white">
        <h3 class="card-title mb-0"><i class="fas fa-dollar-sign me-2"></i> Sales (Last 7 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="salesChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Charts Row 2 -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">
        <h3 class="card-title mb-0"><i class="fas fa-shipping-fast me-2"></i> Shipping Status (30 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="shipChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-white">
        <h3 class="card-title mb-0"><i class="fas fa-star me-2"></i> Top Products (30 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="topProdChart" height="200"></canvas>
      </div>
    </div>
  </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const userLabels  = {!! json_encode($usersLast7->keys()) !!};
  const userData    = {!! json_encode($usersLast7->values()) !!};
  const salesLabels = {!! json_encode($salesLast7->keys()) !!};
  const salesData   = {!! json_encode($salesLast7->values()) !!};
  const shipLabels  = {!! json_encode($shipping->keys()) !!};
  const shipData    = {!! json_encode($shipping->values()) !!};
  const prodLabels  = {!! json_encode($topProducts->keys()) !!};
  const prodData    = {!! json_encode($topProducts->values()) !!};

  new Chart(document.getElementById('usersChart'), {
    type: 'line',
    data: {
      labels: userLabels,
      datasets: [{
        label: 'New Users',
        data: userData,
        backgroundColor: 'rgba(0,123,255,0.2)',
        borderColor: '#007bff',
        fill: true,
        tension: 0.4
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true } }
    }
  });

  new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
      labels: salesLabels,
      datasets: [{
        label: 'Sales ($)',
        data: salesData,
        backgroundColor: '#28a745'
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true } },
      scales: { y: { beginAtZero: true } }
    }
  });

  new Chart(document.getElementById('shipChart'), {
    type: 'doughnut',
    data: {
      labels: shipLabels,
      datasets: [{
        label: 'Order Status',
        data: shipData,
        backgroundColor: ['#17a2b8', '#ffc107', '#dc3545']
      }]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'bottom' } }
    }
  });

  new Chart(document.getElementById('topProdChart'), {
    type: 'bar',
    data: {
      labels: prodLabels,
      datasets: [{
        label: 'Units Sold',
        data: prodData,
        backgroundColor: '#fd7e14'
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      scales: { x: { beginAtZero: true } }
    }
  });
});
</script>
@endsection
