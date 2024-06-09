<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Category</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0 bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-secondary" />
                <div class="table-responsive">
                    <table class="table" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th>No</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    getList();

    async function getList() {

        let tableData = $("#tableData")
        let tableList = $("#tableList")


        tableData.DataTable().destroy()
        tableList.empty()

        let res = await axios.get("/categories")
        res.data.data.forEach(function(item, index) {
            let data = `<tr>
            <td>${index+1} </td>
            <td>${item['name']} </td>
            <td>
                <button data-id="${item['id']}" class="btn edit btn-outline-success">Edit </button>
                <button data-id="${item['id']}" class="btn delete btn-outline-danger">Delete </button>
            </td>

            </tr>`
            tableList.append(data)
        });
    $(".edit").on("click",async function(){
        let id = $(this).data("id");
       await categoryByID(id)
        $("#update-modal").modal("show")
    })
    $(".delete").on("click", function(){
        let id = $(this).data("id");
            $("#delete-modal").modal("show")
            $("#deleteID").val(id)
    })
        let table = new DataTable('#tableData', {
            lengthMenu: [5, 10, 15]
        });

    }
</script>
