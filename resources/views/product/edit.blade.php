<div class="modal modal-slide-in fade" id="editProduct" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">
                    <span class="align-middle">Edit Product</span>
                </h5>
            </div>

            <div class="modal-body flex-grow-1">

                <form id="productForm" name="productForm" method="POST" action="{{ route('product.update',$product->id) }}"  class="manuallyAddForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="customer-name" class="form-label">Item</label>
                        <select name="item_id" class="form-control" placeholder="Select Item">
                            @foreach ($item as $item)
                                <option value="{{ $item->id }}" {{ $item->id == $product->item_id ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="customer-name" class="form-label">Price</label>
                        <input type="text" class="form-control" value="{{ $product->price }}" name="price" data-rule-required="true" data-rule-numeric
                            placeholder="Price" />
                    </div>

                    <div class="form-group">
                        <label for="customer-name" class="form-label">Qty</label>
                        <input type="text" class="form-control" value="{{ $product->qty }}" name="qty" data-rule-required="true" data-rule-numeric
                            placeholder="Qty" />
                    </div>

                    <div class="form-group">
                        <label for="customer-name" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" />
                        <img src="{{ asset('storage'.'/'.$product->image) }}" height="100px">
                    </div>

                    <div class="form-group d-flex flex-wrap mt-2">
                        <button type="submit" class="btn btn-primary mr-1">Update Product</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/scripts/validation/product.js') }}"></script>
