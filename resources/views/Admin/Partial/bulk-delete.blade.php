<a class="btn btn-danger" id="bulk_delete_btn"><i class="voyager-trash"></i> <span>Bulk Delete</span></a>

{{-- Bulk delete modal --}}
<div class="modal modal-danger fade" tabindex="-1" id="bulk_delete_modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">
                    <i class="voyager-trash"></i> Are you sure you want to delete <span id="bulk_delete_count"></span> <span id="bulk_delete_display_name"></span>?
                </h4>
            </div>
            <div class="modal-body" id="bulk_delete_modal_body">
            </div>
            <div class="modal-footer">
                <form action="" id="bulk_delete_form" method="POST">
                    {{ method_field("DELETE") }}
                    {{ csrf_field() }}
                    <input type="hidden" name="ids" id="bulk_delete_input" value="">
                    <input type="submit" class="btn btn-danger pull-right delete-confirm"
                           value="Yes, Delete these records">
                </form>
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function () {
        // Bulk delete selectors
        let $bulkDeleteBtn = $('#bulk_delete_btn');
        let $bulkDeleteModal = $('#bulk_delete_modal');
        let $bulkDeleteCount = $('#bulk_delete_count');
        let $bulkDeleteDisplayName = $('#bulk_delete_display_name');
        let $bulkDeleteInput = $('#bulk_delete_input');

        // Reposition modal to prevent z-index issues
        $bulkDeleteModal.appendTo('body');

        // Bulk delete listener
        $bulkDeleteBtn.click(function () {
            let ids = [];
            let $checkedBoxes = $('#dataTable input[type=checkbox]:checked').not('.select_all');
            let count = $checkedBoxes.length;
            if (count) {

                // Reset input value
                $bulkDeleteInput.val('');

                // Deletion info
                let displayName = count > 1 ? 'records' : 'record';
                displayName = displayName.toLowerCase();
                $bulkDeleteCount.html(count);
                $bulkDeleteDisplayName.html(displayName);

                let dataFor = $('#dataTable').data('for');
                // Gather IDs
                $.each($checkedBoxes, function () {
                    let value = $(this).val();
                    if(dataFor == 'users') {
                        if(value != '{{Auth::user()->id}}') {
                            ids.push(value);
                        }
                    } else {
                        ids.push(value);
                    }
                });

                if(ids.length > 0) {
                    // Set input value
                    $bulkDeleteInput.val(ids);

                    // Set action
                    $('#bulk_delete_form')[0].action = $('#dataTable').data('delete-url');

                    // Show modal
                    $bulkDeleteModal.modal('show');
                } else {
                    toastr.warning('Logged In user can not be deleted');
                }
            } else {
                // No row selected
                toastr.warning('You haven&#039;t selected anything to delete');
            }
        });
    }
</script>
