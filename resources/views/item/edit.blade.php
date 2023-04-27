<div class="modal modal-slide-in fade" id="editItem" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog sidebar-lg">
        <div class="modal-content p-0">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title">
                    <span class="align-middle">Edit Item</span>
                </h5>
            </div>

            <div class="modal-body flex-grow-1">
                <form id="itemForm" name="itemForm" method="POST" enctype="multipart/form-data"
                    action="{{ route('item.update',$item->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="customer-name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ $item->name }}" name="name" data-rule-required="true"
                            placeholder="Name" />
                    </div>

                    <div class="form-group">
                        <label for="customer-name" class="form-label">Description</label>
                        <textarea type="text" class="form-control" name="description" data-rule-required="true" placeholder="Description">{{ $item->description }}</textarea>
                    </div>

                    <div class="form-group d-flex flex-wrap mt-2">
                        <button type="submit" class="btn btn-primary mr-1">Update Item</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('assets/js/scripts/validation/item.js') }}"></script>
