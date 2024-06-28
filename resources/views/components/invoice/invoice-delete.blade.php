<div class="container">
    <div class="modal" tabindex="-1" role="dialog" id="delete-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirm</h5>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Confim Delete</p>
                </div>
                <input type="hidden" id="delete-id">
                <div class="modal-footer">
                    <button type="button" onclick="deleteInvoice()" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hideModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
   function hideModal(){
    $('#delete-modal').modal('hide')
   }
    async function deleteInvoice() {
                let invoice_id=$("#delete-id").val()
                showLoader();
                let res = await axios.post('delete-invoice', {
                    invoice_id: invoice_id
                })
                hideLoader()
                $("#delete-modal").modal("hide")
                if (res.data = 1) {
                    successToast("Invoice Deleted")
                    await getInvoice()
                } else {
                    errorToast("Invoice delete Faild")
                }
    }
</script>
