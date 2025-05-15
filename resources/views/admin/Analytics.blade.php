@extends('layout')

@section('title', 'Analytics')

@section('content_header')
<h1 class="mb-4"><i class="fas fa-chart-line"></i> Analytics Dashboard</h1>
@stop

@section('content')
<div class="row">
  <!-- New Users -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">
        <h3 class="card-title mb-0"><i class="fas fa-user-plus mr-2"></i> New Users (Last 7 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="usersChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Sales -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-success text-white">
        <h3 class="card-title mb-0"><i class="fas fa-dollar-sign mr-2"></i> Sales (Last 7 Days)</h3>
      </div>
      <div class="card-body">
        <canvas id="salesChart" height="200"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Shipping Status -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-info text-white">
        <h3 class="card-title mb-0"><i class="fas fa-shipping-fast mr-2"></i> Shipping Status (30d)</h3>
      </div>
      <div class="card-body">
        <canvas id="shipChart" height="200"></canvas>
      </div>
    </div>
  </div>

  <!-- Top Products -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow-sm">
      <div class="card-header bg-warning text-white">
        <h3 class="card-title mb-0"><i class="fas fa-star mr-2"></i> Top Products (30d)</h3>
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
document.addEventListener('DOMContentLoaded', function() {
  const userLabels  = JSON.parse(`{!! json_encode($usersLast7->keys()->toArray()) !!}`);
  const userData    = JSON.parse(`{!! json_encode($usersLast7->values()->toArray()) !!}`);
  const salesLabels = JSON.parse(`{!! json_encode($salesLast7->keys()->toArray()) !!}`);
  const salesData   = JSON.parse(`{!! json_encode($salesLast7->values()->toArray()) !!}`);
  const shipLabels  = JSON.parse(`{!! json_encode($shipping->keys()->toArray()) !!}`);
  const shipData    = JSON.parse(`{!! json_encode($shipping->values()->toArray()) !!}`);
  const prodLabels  = JSON.parse(`{!! json_encode($topProducts->keys()->toArray()) !!}`);
  const prodData    = JSON.parse(`{!! json_encode($topProducts->values()->toArray()) !!}`);

  // Chart 1: New Users
  new Chart(document.getElementById('usersChart'), {
    type: 'line',
    data: {
      labels: userLabels,
      datasets: [{
        label: 'New Users',
        data: userData,
        backgroundColor: 'rgba(0, 123, 255, 0.2)',
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

  // Chart 2: Sales
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

  // Chart 3: Shipping Status
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

  // Chart 4: Top Products
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
