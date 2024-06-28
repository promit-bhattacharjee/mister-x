<div class="card my-1 p-1 h-100">
    <table class="table" id="product-table">
        <thead>
            <tr>
                <th scope="col">Product</th>
                <th scope="col">Pick</th>
            </tr>
        </thead>
        <tbody id="product-table-body">
        </tbody>
    </table>
</div>

{{-- modal --}}
<form action="" id="product-form">
    <div class="modal" tabindex="-1" id="product-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <label for="product-name">Product Name</label>
                        <input type="text" id="product-name" class="form-control">
                    </div>
                    <div class="container">
                        <label for="product-price">Product Price</label>
                        <input type="text" id="product-price" class="form-control">
                    </div>
                    <div class="container">
                        <label for="product-quantity">Product Quantity</label>
                        <input type="text" id="product-quantity" class="form-control">
                    </div>
                    <div class="container"><label for="product-id">Product ID</label>
                        <input type="text" id="product-id" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="addProduct()" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    let invoiceItems=[];
    async function getProduct() {
        let productTable = $('#product-table-body');
        showLoader();
        let res = await axios.get("/get-product");
        hideLoader();
        if (res.status == 200 && res.data.status == "sucessful") {
            res.data.data.forEach(function(value, index) {
                let tr = `
                <tr>
                    <td>
                        <span>${value['name']} $${value['price']}</span>
                    </td>
                    <td>
                        <button class='btn add-product' data-product-id='${value["id"]}' data-product-price='${value['price']}' data-product-name='${value['name']}'> Add </button>
                    </td>
                </tr>
                `;
                productTable.append(tr);
            });

            // Bind the click event to the dynamically added buttons
            $('.add-product').on('click', async function() {
                let productName = $(this).data('product-name');
                let productPrice = $(this).data('product-price');
                let productId = $(this).data('product-id');

                $('#product-name').val(productName);
                $('#product-price').val(productPrice);
                $('#product-id').val(productId);

                // Show the modal using Bootstrap's modal method
                $('#product-modal').modal('show');
            });

            new DataTable('#product-table', {
                order: [
                    [0, 'desc']
                ],
                scrollCollapse: false,
                info: false,
                lengthChange: false
            });
        }
    }
 getProduct();
   function addProduct(){
        let productName = $('#product-name').val();
        let productPrice = $('#product-price').val();
        let productID = $('#product-id').val();
        let productQuantity = $('#product-quantity').val();
        let product={
            'product_id':productID,
            'qty':productQuantity,
            'sale_price':parseFloat(productPrice)*parseFloat(productQuantity),
            'productName':productName
        };
        invoiceItems.push(product);
        $('#product-modal').modal('hide');

        showProducts(invoiceItems)
        $('#product-form')[0].reset();

    }
</script>
