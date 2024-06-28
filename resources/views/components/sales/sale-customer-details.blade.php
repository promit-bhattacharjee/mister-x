<div class="card m-1 p-2 h-100">
    <table class="table" id="customer-table">
        <thead>
          <tr>
            <th scope="col">Customer</th>
            <th scope="col">Pick</th>
          </tr>
        </thead>
        <tbody  id="customer-table-body">
        </tbody>
      </table>

</div>
<script>
    async function getCustomerData()
    {
        let customerTable = $('#customer-table-body');
        showLoader();
        let res=await axios.get("/get-customer");
        hideLoader();
        if(res.status==200 && res.data.status=="sucessful")
        {
            res.data.data.forEach(function(value,index){
                let tr = `
                <tr>
                <td>
                ${value['name']}
                </td>
                <td>
                <button
                class='btn add-customer'
                data-customer-id='${value["id"]}'
                data-customer-name='${value["name"]}'
                data-customer-email='${value["email"]}'
                data-customer-mobile='${value["mobile"]}'
                > Add </button>
                </td>
                </tr>
                `
                customerTable.append(tr)
            })
        }
        $('.add-customer').on('click', async function(){
        let customerName=$(this).data('customer-name');
        let customerId=$(this).data('customer-id');
        let customerMobile=$(this).data('customer-mobile');
        let customerEmail=$(this).data('customer-email');
        $('#customer-name').text(customerName)
        $('#customer-email').text(customerEmail)
        $('#customer-mobile').text(customerMobile)
        $('#customer-id').val(customerId)
    })
        new DataTable('#customer-table',{
            order:[[0,'desc']],
            scrollCollapse:false,
            info:false,
            lengthChange:false

        });

    }
    getCustomerData()


</script>
