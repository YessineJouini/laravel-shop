@extends($layout)
@section('header', 'Products on Sale')
@section('content')
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <h1 class="text-center mb-4">Products on Sale</h1>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          @foreach($sales as $sale)
            <div class="col-6 col-sm-4 col-md-3 mb-4">
              <div class="card card-hover h-100 shadow-sm position-relative">
                
              <div class="card-img-top overflow-hidden" style="height:180px;">
        <img src="{{ Storage::url($sale->product->image) }}"
             alt="{{ $sale->name }}"
             class="w-100"
             style="object-fit: cover; height: 100%;" />
      </div>

                <div class="card-body d-flex flex-column">
                  <h6 class="card-title">{{ Str::limit($sale->product->name, 30) }}</h6>
     

                  <div class="mt-auto">
                    <div>
                        <span class="font-weight-bold text-danger">
                            ${{ number_format($sale->product->price * (1 - $sale->discount_percent / 100), 2) }}
                        </span>
                        <small class="text-muted">
                            <s>
                            ${{ number_format($sale->product->price, 2) }}
                            </s>
                        </small>
                    </div>
                    <p class="small text-muted">
                      Sale Period: {{ $sale->start_date ?: '—' }} to {{ $sale->end_date ?: '—' }}
                    </p>
                  </div>

                  <a href="{{ route('products.show', $sale->product->id) }}" class="btn btn-sm btn-primary mt-2">
                    View Product
                  </a>
                  
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div class="d-flex justify-content-center">
          {{ $sales->links() }}
        </div>
      </div>
    </section>
  </div>
@endsection