<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Category</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <div>
                                    <label class="form-label d-block">Product Category *</label>
                                    <select class="dropdown w-100 form-control" type="button" id="category" value="">
                                        <option value="" id="default">Select Category</option>
                                    </select>
                                </div>

                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="name">
                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="price">
                                <label class="form-label">Product Unite *</label>
                                <input type="text" class="form-control" id="unit">
                                <label class="form-label">Product Image *</label>
                                <br>
                                <img src="{{asset("images/default.jpg")}}" class="w-25" id="newImg">
                                <br>
                                <br>
                                <input type="file" class="form-control" id="img" oninput="newImg.src=window.URL.createObjectURL(this.files[0])">
                                {{-- <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="categoryName"> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="createProduct()" id="save-btn" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
fillCategoryDropDown()
    async function fillCategoryDropDown()
    {
        let res=await axios.get("/categories")
        let category=document.getElementById("category")
        res.data.data.forEach(function (item,index){
            let option=document.createElement("option")
            option.value=item.id
            option.textContent=item.name
                category.append(option)
        });
    }
async function createProduct() {
   try{
    let name=document.getElementById("name").value
    let price=document.getElementById("price").value
    let unit=document.getElementById("unit").value
    let img=document.getElementById("img").files[0]
    let category_id=document.getElementById("category").value

    let res =await axios.post("/create-product",
    {
        name:name,
        price:price,
        unit:unit,
        category_id:category_id,
        img:img
    })
    if(res.status==200 && res.data.status=="sucessful")
    {
        successToast("Product Created Sucessfully")
        document.getElementById("save-form").reset()

    }
    else{
        errorToast("Product Created Faild")
    }
   }
   catch(e){

       errorToast(e)
   }


}

</script>
