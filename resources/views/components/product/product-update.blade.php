<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Category</h6>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <div>
                                    <label class="form-label d-block">Product Category *</label>
                                    <form id="UpdateCategoriesForm">
                                        <select class="dropdown w-100 form-control" type="button" id="UpdateCategory">
                                            <option id="default">Select Category</option>
                                        </select>
                                    </form>
                                </div>
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="updateName" value="">
                                <input type="hidden" class="form-control" id="updateID" value="">
                                <input type="hidden" class="form-control" id="privious_img" value="">
                                <label class="form-label">Product Price *</label>
                                <input type="text" class="form-control" id="updatePrice">
                                <label class="form-label">Product Unite *</label>
                                <input type="text" class="form-control" id="updateUnit">
                                <label class="form-label">Product Image *</label>
                                <br>
                                <img class="w-25" id="previewImg">
                                <br>
                                <br>
                                <input type="file" class="form-control" id="newImg" oninput="previewImg.src=window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-gradient-primary" id="closeUpdateModal" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="update()" id="" class="btn bg-gradient-success">Save</button>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    async function fillUpdateDropDown(id) {
        let res = await axios.get("/categories")
        let category = document.getElementById("UpdateCategory")
        category.innerHTML = '';
        res.data.data.forEach(function(item, index) {
            let option = document.createElement("option")
            option.value = item.id
            option.textContent = item.name
            if (item.id === id) {
                option.selected = true
            }
            category.append(option)
        });
    }
    async function fillUpdate(id,path) {
        let res = await axios.post("/product-by-id", {
            id: id
        })
        let data = res.data.data
        document.getElementById("update-form").reset();
        await fillUpdateDropDown(data['category_id']);
        document.getElementById("updateName").value = data['name']
        document.getElementById("updateID").value = data['id']
        document.getElementById("updatePrice").value = data['price']
        document.getElementById("updateUnit").value = data['unit']
        document.getElementById("previewImg").src= path
    }

    async function update() {
        try {
            let id = document.getElementById("updateID").value
            let name = document.getElementById("updateName").value
            let price = document.getElementById("updatePrice").value
            let unit = document.getElementById("updateUnit").value
            let category_id = document.getElementById("UpdateCategory").value
            let privious_img = document.getElementById("privious_img").value
            let NewImg=document.getElementById("newImg").files[0]
                        console.log(NewImg);
            // let img = document.getElementById("newImg").files[0]
            let updateForm = new FormData()
            updateForm.append("name", name)
            updateForm.append("id", id)
            updateForm.append("unit", unit)
            updateForm.append("price", price)
            updateForm.append("category_id", category_id)
            updateForm.append("img", NewImg)
            updateForm.append("privious_img", privious_img)
            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                    }
                    }
                    let res = await axios.post("/update-product", updateForm, config)
                    if (res.status == 200 && res.data.status == "sucessful") {

                        showLoader()
                        await getList()
                        setTimeout(() => {
                            hideLoader()
                        }, 2000);
                    successToast(res.data.message)
                    document.getElementById("update-form").reset();
                    document.getElementById('closeUpdateModal').click();



            } else {
                errorToast(res.data.message)
            }
        } catch (e) {

            errorToast(e)
        }


    }
</script>
