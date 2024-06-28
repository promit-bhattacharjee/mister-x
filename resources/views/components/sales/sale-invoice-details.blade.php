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
    <table class="table" id="invoice-table">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Qty</th>
                <th scope="col">Total</th>
                <th scope="col">Remove</th>
            </tr>
        </thead>
        <tbody id="invoice-table-body" class="text-center">
        </tbody>
    </table>
    <div id="invoice-footer" class="px-2">
        <span>Total : </span><span id="total-price">0</span>
        <br>
        <span>Vat(5%) : </span><span id="vat">0</span>
        <br>
        <span>Discount : </span><span id="discount-amount">0</span>
        <br>
        <div class="row">
            <div class="justify-content-between d-flex"><input id="discount-precent" class="form-control w-50">
                <button class="btn btn-sm " onclick="discountAmount()">Apply</button>
            </div>
        </div>
        <br>
        <span>Payable : </span><span id="payable">0</span>
        <br>
        <br>
        <button class="btn btn-success" onclick="createInvoice()">Confim Order</button>
    </div>
</div>

<script>
    let pro = [];

    function getCurrentDateInBangladesh() {
        // Create a new Date object for the current date and time
        let now = new Date();

        // Get the UTC time in milliseconds
        let utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);

        // Create a new Date object for Bangladesh time (UTC+6)
        let bangladeshTime = new Date(utcTime + (6 * 60 * 60000));

        // Get the components of the date
        let year = bangladeshTime.getFullYear();
        let month = (bangladeshTime.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
        let day = bangladeshTime.getDate().toString().padStart(2, '0');

        // Format the date as YYYY-MM-DD
        let currentDate = `${year}-${month}-${day}`;

        return currentDate;
    }

    // Example usage
    $('#date').text(getCurrentDateInBangladesh());

    function showProducts(products) {

        let InvoiceTableBody = $("#invoice-table-body");
        InvoiceTableBody.empty()
        products.forEach(function(element, index) {
            console.log(element);
            let row = `
            <tr>
                <td>
                    ${element['productName']}
                </td>
                <td>
                    ${element['qty']}
                </td>
                <td>
                    ${element['sale_price']}
                </td>
                <td>
                    <button class='btn remove-product text-danger' data-remove-index='${index}'>Remove</button>
                </td>

            </tr>
            `
            InvoiceTableBody.append(row)
        });
        $('.remove-product').on('click', function() {
            products.splice($(this).data("remove-index"), 1)
            showProducts(products)
        })
        pro = products;
        invoiceCalculate(products)
    }

    function discountAmount() {
        showProducts(pro)

    }

    function invoiceCalculate(products) {
        let totalPrice = 0;
        let discountAmount = 0;
        let vat = 0;
        if (products && products.length > 0) {

            products.forEach(function(value, index) {
                totalPrice = totalPrice + value['sale_price']
                discountAmount = (totalPrice * $('#discount-precent').val()) / 100
            })
            $('#discount-amount').text(discountAmount)
            totalPrice = totalPrice - discountAmount;
            vat = totalPrice * 5 / 100
            $('#total-price').text(totalPrice)
            $('#vat').text(vat)
            $('#payable').text(totalPrice + vat)
        }else{
            $('#discount-amount').text(0)
            $('#total-price').text(0)
            $('#vat').text(0)
            $('#payable').text(0)
        }
    }
    async function createInvoice() {
        let total = $('#total-price').text();
        let discount = $('#discount-amount').text();
        let vat = $('#vat').text();
        let payable = $('#payable').text();
        let customer_id = $('#customer-id').val();
        let products = pro;
        if (customer_id == null || customer_id == '') {
            errorToast("Add Customer First");
        } else if (products == null || products == '') {
            errorToast("Add Product First");
        } else {
            showLoader()
            let data = {
                "total": total,
                "discount": discount,
                "vat": vat,
                "payable": payable,
                "customer_id": customer_id,
                "products": products
            }
            let res = await axios.post('create-invoice', data)
            if (res.data == 1) {
                successToast('Invoice Created Successfully')
            } else {
                errorToast("Something went wrong");
            }
            hideLoader()
        }
    }
</script>
