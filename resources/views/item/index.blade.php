@extends('layouts.app')

@section('page_title','Item')

@section('button')
    @component('components.heading',[
            'add_modal' => collect([
                'action' => route('item.create'),
                'target' => '#addItem',
                'btn_name' => 'Add Item',
            ])
        ])
    @endcomponent
@endsection

@section('content')
@include('components.error')    
<section>
    <div class="card">
        <div class="card-datatable table-responsive pt-0">
            <table class="table" id="itemTable" data-url="{{ route('item.datalist') }}">
                <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
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
    <script src="{{ asset('assets/js/scripts/datatable/item.js') }}"></script>
@endpush