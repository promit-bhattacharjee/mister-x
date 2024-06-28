<div class="container">
    <table class="table table-success table-striped" id="invoice-table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Total</th>
                <th scope="col">Vat</th>
                <th scope="col">Discount</th>
                <th scope="col">Payable</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody id="invoice-table-body">
        </tbody>
    </table>
</div>
<script>
    async function getInvoice() {
        let invoiceTableBody = $('#invoice-table-body');
        let invoiceTable = $("#invoice-table")
        invoiceTable.DataTable().destroy()
        invoiceTableBody.empty()
        showLoader();
        let res = await axios.get("/get-invoice");
        hideLoader();
        $('#invoice-table-body').text('')
        if (res.data) {
            res.data.forEach(function(value, index) {
                let tr = `
                <tr>
                    <td>
                        <span>${index+1}</span>
                    </td>
                    <td>
                        <span>${value['customer']['name']}</span>
                    </td>
                    <td>
                        <span>${value['customer']['mobile']}</span>
                    </td>
                    <td>
                        <span>${value['total']}</span>
                    </td>
                    <td>
                        <span>${value['vat']}</span>
                    </td>
                    <td>
                        <span>${value['discount']}</span>
                    </td>
                    <td>
                        <span>${value['payable']}</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-around">
                            <button class="btn text-danger card delete-invoice" data-delete-id="${value['id']}"> D </button>
                        <button class="btn card detalisInvoice" data-customer-id="${value['customer_id']}" data-invoice-id="${value['id']}"> V </button>
                        </div>
                    </td>
                </tr>
                `;
                invoiceTableBody.append(tr);
            });
            $('.delete-invoice').on('click',function() {
                $("#delete-id").val($(this).data('delete-id'));
                $("#delete-modal").modal("show")

                // await deleteInvoice(invoice_id)
            });
            $('.detalisInvoice').on('click',function() {
                $("#invoice-details-modal").modal("show")
                let customer_id =  $(this).data('customer-id');
                let invoice_id =  $(this).data('invoice-id');
                getInvoiceDetails(customer_id,invoice_id)
                // $("#delete-id").val($(this).data('delete-id'));

                // await deleteInvoice(invoice_id)
            });

            new DataTable(invoiceTable, {
                order: [
                    [0, 'desc']
                ],
                // scrollCollapse: false,
                // info: false,
                // lengthChange: false
            });
        }
    }
    getInvoice()
</script>
