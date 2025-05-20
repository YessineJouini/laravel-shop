{{-- resources/views/admin/orders/index.blade.php --}}

@extends('layout')

@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <h3 class="card-title">Order Management</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <form method="get" class="mb-3">
          <div class="form-inline">
            <label class="mr-2">Status:</label>
            <select name="status" class="form-control mr-2" onchange="this.form.submit()">
              <option value="">All</option>
              <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="shipping_in_progress" {{ ($status ?? '') === 'shipping_in_progress' ? 'selected' : '' }}>Shipping</option>
              <option value="declined" {{ ($status ?? '') === 'declined' ? 'selected' : '' }}>Declined</option>
            </select>
            <noscript><button type="submit" class="btn btn-primary btn-sm">Filter</button></noscript>
          </div>
        </form>
        <form id="bulk-action-form" method="post" action="{{ route('orders.bulkAction') }}">
          @csrf
          <input type="hidden" name="action" id="bulk-action-type">

          <div class="mb-2">
            <button type="button" class="btn btn-success btn-sm" onclick="setBulkAction('accept')">Accept Selected</button>
            <button type="button" class="btn btn-danger btn-sm" onclick="setBulkAction('decline')">Decline Selected</button>
          </div>

          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th><input type="checkbox" id="select-all"></th>
                @php
                  // helper to flip direction
                  $flip = fn($field) => $sort === $field && $direction === 'asc' ? 'desc' : 'asc';
                  $icon = fn($field) => $sort === $field
                    ? '<i class="fas fa-sort-'.($direction==='asc'?'up':'down').'"></i>'
                    : '<i class="fas fa-sort"></i>';
                @endphp

                <th>
                  <a href="{{ route('orders.index', ['sort'=>'id','direction'=>$flip('id')]) }}" class="text-dark">
                    # {!! $icon('id') !!}
                  </a>
                </th>
                <th>
                  <a href="{{ route('orders.index', ['sort'=>'user','direction'=>$flip('user')]) }}" class="text-dark">
                    User {!! $icon('user') !!}
                  </a>
                </th>
                <th>
                  <a href="{{ route('orders.index', ['sort'=>'total','direction'=>$flip('total')]) }}" class="text-dark">
                    Total {!! $icon('total') !!}
                  </a>
                </th>
                <th>
                  <a href="{{ route('orders.index', ['sort'=>'status','direction'=>$flip('status')]) }}" class="text-dark">
                    Status {!! $icon('status') !!}
                  </a>
                </th>
                <th>Payment</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
                <tr>
                  <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}"></td>
                  <td>{{ $order->id }}</td>
                  <td>{{ $order->user->name ?? 'Guest' }}</td>
                  <td>${{ number_format($order->total, 2) }}</td>
                  <td>
                    <span class="badge badge-{{ $order->status === 'pending' ? 'warning' :
                                           ($order->status === 'shipping_in_progress' ? 'info' : 'danger') }}">
                      {{ ucfirst(str_replace('_',' ',$order->status)) }}
                    </span>
                  </td>
                  <td>{{ ucfirst(str_replace('_',' ',$order->payment_method)) }}</td>
                  <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-info btn-sm">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
      <div class="card-footer clearfix">
        {{ $orders->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</section>
<script>
function setBulkAction(action) {
  document.getElementById('bulk-action-type').value = action;
  document.getElementById('bulk-action-form').submit();
}
document.getElementById('select-all').addEventListener('change', function() {
  document.querySelectorAll('input[name="order_ids[]"]').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
