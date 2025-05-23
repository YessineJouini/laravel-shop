@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">

      <div class="card-header bg-light position-relative">
        <h5 class="mb-0 d-flex align-items-center text-secondary">
          <i class="fas fa-receipt mr-2"></i> 
          Order #{{ $order->id }}
        </h5>

        @php
          $steps = [
            'pending' => ['label' => 'Pending', 'icon' => 'fas fa-clock'],
            'shipping_in_progress' => ['label' => 'Shipping', 'icon' => 'fas fa-truck'],
            'delivered' => ['label' => 'Delivered', 'icon' => 'fas fa-check-circle'],
            'declined' => ['label' => 'Declined', 'icon' => 'fas fa-times-circle'],
          ];
          $statusOrder = array_keys($steps);
          $currentIndex = array_search($order->status, $statusOrder);
          $isDeclined = $order->status === 'declined';
          $primaryColor = '#00c2ed';
        @endphp

        <div class="mt-4 mb-3">
          <div class="progress-container position-relative px-2 py-4">
            <!-- Base Line -->
            <div class="position-absolute top-50 start-0 end-0 translate-middle-y" 
                 style="height: 6px; background-color: #e9ecef; border-radius: 3px; z-index: 1;"></div>

            <!-- Active Progress Line -->
            <div class="position-absolute top-50 start-0 translate-middle-y" 
                 style="height: 6px; background-color: {{ $isDeclined ? '#dc3545' : $primaryColor }};
                        border-radius: 3px; z-index: 2;
                        width: {{ $isDeclined ? '100%' : (100 * ($currentIndex + 1) / count($statusOrder)) . '%' }};
                        transition: width 0.5s ease;">
            </div>

            <!-- Steps -->
            <div class="d-flex justify-content-between align-items-center position-relative z-3 flex-wrap">
              @foreach($steps as $key => $step)
                @php
                  $stepIndex = array_search($key, $statusOrder);
                  $isActive = $order->status === $key;
                  $isCompleted = !$isDeclined && $stepIndex <= $currentIndex;
                @endphp

                <div class="text-center flex-fill px-2" style="min-width: 80px;">
                  <!-- Step Circle -->
                  <div class="mx-auto mb-2 d-flex align-items-center justify-content-center"
                       style="width: 44px; height: 44px; border-radius: 50%;
                              background-color: {{
                                $isActive ? ($isDeclined ? '#dc3545' : $primaryColor) :
                                ($isCompleted ? $primaryColor : '#e9ecef')
                              }};
                              border: 3px solid {{
                                $isActive ? ($isDeclined ? '#dc3545' : $primaryColor) :
                                ($isCompleted ? $primaryColor : '#dee2e6')
                              }};
                              transition: all 0.3s ease;">
                    <i class="{{ $step['icon'] }}" 
                       style="color: {{ $isActive || $isCompleted ? '#fff' : '#6c757d' }};
                              font-size: 18px;"></i>
                  </div>

                  <!-- Step Label -->
                  <div class="small fw-semibold" 
                       style="color: {{
                         $isActive ? ($isDeclined ? '#dc3545' : $primaryColor) :
                         ($isCompleted ? $primaryColor : '#6c757d')
                       }};">
                    {{ $step['label'] }}
                  </div>

                  <!-- Active Step Badge -->
                  @if($isActive)
                    <span class="badge mt-2" 
                          style="background-color: {{ $isDeclined ? '#dc3545' : $primaryColor }};
                                 font-size: 0.7rem;">
                      Current
                    </span>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

      <div class="card-body">
        <p class="text-muted mb-2">
          <strong>Order Date:</strong> {{ $order->created_at->format('M d, Y h:ia') }}
        </p>

        <hr class="my-4">

        <h5 class="mb-3"><i class="fas fa-box mr-2"></i> Order Items</h5>
        <table class="table table-sm table-hover">
          <thead class="thead-light">
            <tr>
              <th>Product</th>
              <th class="text-center">Quantity</th>
              <th class="text-right">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->orderItems as $item)
              <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">${{ number_format($item->quantity * $item->price, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <hr class="my-4">

        <h5 class="mb-3"><i class="fas fa-map-marker-alt mr-2"></i> Shipping Address</h5>
        <div class="pl-2">
          <p class="mb-1">{{ $order->shippingAddress->line1 }}</p>
          @if($order->shippingAddress->line2)
            <p class="mb-1">{{ $order->shippingAddress->line2 }}</p>
          @endif
          <p class="mb-1">{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->zip }}</p>
          <p class="mb-0">{{ $order->shippingAddress->country }}</p>
        </div>

        <div class="text-right mt-5">
          <h4 class="mb-0">Total Paid:</h4>
          <div class="display-5 font-weight-bold mt-2 p-2 text-success d-inline-block rounded">
            ${{ number_format($order->total, 2) }}
          </div>
        </div>
      </div>

      <div class="card-footer text-right bg-light">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
        </a>
      </div>

    </div>
  </div>
</div>
@endsection
