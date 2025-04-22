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
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
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
      </div>
      <div class="card-footer clearfix">
        {{ $orders->links('pagination::bootstrap-4') }}
      </div>
    </div>
  </div>
</section>
@endsection
