<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                                <img src="{{asset("images/default.jpg")}}" class="w-25" id="newImgPriview">
                                <br>
                                <br>
                                <input type="file" class="form-control" id="img" oninput="newImgPriview.src=window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" id="closeBTN" data-bs-dismiss="modal"
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
    let closeBTN=document.getElementById("closeBTN")
    let formData= new FormData()
    formData.append("name",name)
    formData.append("price",price)
    formData.append("unit",unit)
    formData.append("img",img)
    formData.append("category_id",category_id)
    const config ={
        headers:{
            'content-type':'multipart/form-data'
        }
    }
    let res =await axios.post("/create-product",formData,config)
    if(res.status==200 && res.data.status=="sucessful")
    {
        successToast("Product Created Sucessfully")
        // document.getElementById("save-form").reset();
        // closeBTN.click();
        await getList()



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
