@extends('layouts.app')

@section('page_title', 'Product')

@section('button')
    @component('components.heading',
        [
            'add_modal' => collect([
                'action' => route('product.create'),
                'target' => '#addProduct',
                'btn_name' => 'Add Product',
            ]),
        ])
    @endcomponent
@endsection

@section('content')
    @include('components.error')
    <section>

        <div class="card">
            <div class="card-datatable table-responsive pt-0">
                <table class="table" id="productTable" data-url="{{ route('product.datalist') }}">
                    <thead class="thead-light">
                        <tr>
                            <th>Image</th>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th width="5%" data-orderable="false" class="text-center">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
    <div id="load-modal"></div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/scripts/datatable/product.js') }}"></script>
@endpush
