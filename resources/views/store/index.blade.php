@extends($layout)

@section('title', 'Store')

@section('content')
<div class="content-wrapper">

  <!-- Page Header -->
  <section class="content-header">
    <div class="container-fluid">
      <h1>Product Catalog</h1>
    </div>
  </section>

  <!-- Main Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        @foreach($products as $product)
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card card-outline card-info h-100">

              <!-- Image -->
              <div class="position-relative overflow-hidden" style="height:180px;">
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-100 h-100"
                     style="object-fit:cover;">
              </div>

              <!-- Body -->
              <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="text-sm flex-grow-1">
                  {{ Str::limit($product->description, 80) }}
                </p>
              </div>

              <!-- Footer -->
              <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
                <span class="font-weight-bold text-info">
                  ${{ number_format($product->price, 2) }}
                </span>
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="m-0">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-cart-plus mr-1"></i> Add
                  </button>
                </form>
              </div>

            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center">
          {{ $products->links() }}
        </div>
      @endif

    </div>
  </section>

  <!-- Floating Cart Button -->
<!-- Floating Cart Button -->
<a href="{{ route('cart.view') }}"
   class="btn btn-info btn-lg rounded-circle shadow position-fixed
          d-flex align-items-center justify-content-center"
   style="bottom: 20px; right: 20px; width: 60px; height: 60px;">
  <!-- Cart Icon -->
  <i class="fas fa-shopping-cart fa-lg text-white"></i>

  <!-- Badge: use a darker color, pill shape, and smaller font -->
  <span class="badge badge-danger badge-pill position-absolute"
        style="top: -6px; right: -6px; font-size:0.75rem;">
    {{ Auth::user()->cart?->items->sum('quantity') ?? 0 }}
  </span>
</a>


</div>
@endsection
