<div class="modal fade" id="invoice-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body"  id="invoice-content">
                {{--  --}}
                <div>
                    <div class="card m-1 h-100">
                        <div class="row pt-4 px-2">
                            <div class="col-8">
                                <h5>BILLED TO</h5>
                                <span>Name: </span>
                                <span id="customer-name"></span>
                                <br>
                                <span>Email: </span>
                                <span id="customer-email"></span>
                                <br>
                                <span>Mobile: </span>
                                <span id="customer-mobile"></span>
                                <br>
                                <input type="hidden" id="customer-id"></span>
                            </div>
                            <div class="col-4">
                                <h5>Mister-X</h5>
                                <h6>Invoice</h6>
                                <span>Date: </span>
                                <br>
                                <span id="date"></span>

                            </div>
                        </div>
                        <table class="table" id="invoice-details-table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoice-details-table-body" class="text-center">
                            </tbody>
                        </table>
                        <div id="invoice-footer" class="px-2">
                            <span>Total : </span><span id="total-price"></span>
                            <br>
                            <span>Vat(5%) : </span><span id="vat"></span>
                            <br>
                            <span>Discount : </span><span id="discount-amount"></span>
                            <br>
                            <span>Payable : </span><span id="payable"></span>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()">Close</button>
                <button type="button" class="btn btn-primary" onclick="printInvoice()">Print</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function getProductById(element) {
        let response = await axios.post("product-by-id", {
            id: element['product_id']
        });
        return response.data;
    }

    async function getInvoiceDetails(customer_id, invoice_id) {
        let InvoiceTableBody = $("#invoice-details-table-body");
        let invoiceTable = $("#invoice-details-table");
        invoiceTable.DataTable().destroy();
        InvoiceTableBody.empty();

        let res = await axios.post("/details-invoice", {
            customer_id: customer_id,
            invoice_id: invoice_id
        });

        if (res.status === 200) {
            let data = res.data;

            $("#customer-name").text(data.customer.name);
            $("#customer-email").text(data.customer.email);
            $("#customer-mobile").text(data.customer.mobile);
            $("#date").text(data.customer.created_at.slice(0, 10));
            $("#total-price").text(data.invoice.total);
            $("#vat").text(data.invoice.id);
            $("#discount-amount").text(data.invoice.discount);
            $("#payable").text(data.invoice.payable);
            showLoader();
            let promises = data.product.map(element => getProductById(element));
            let results = await Promise.all(promises);
            let rows = results.map((productData, index) => {
                let element = data.product[index];
                return `
                <tr>
                    <td>${productData.name}</td>
                    <td>${element.qty}</td>
                    <td>${element.sale_price}</td>
                </tr>
            `;
            });
            InvoiceTableBody.append(rows);
            hideLoader();
            new DataTable(invoiceTable, {
                order: [
                    [0, 'desc']
                ],
                scrollCollapse: false,
                info: false,
                lengthChange: false,
                searching: false,
                paging: false
            });
        }
    }

    function printInvoice() {
        let invoiceContent = document.getElementById("invoice-content").innerHTML;
        let orgContent = document.body.innerHTML;
        document.body.innerHTML = invoiceContent;
        window.print()
        setTimeout(function() {
            location.reload()
        }, 100);
        document.body.innerHTML = orgContent

    }
    function closeModal()
    {
        $("#invoice-details-modal").modal("hide")
    }
</script>
