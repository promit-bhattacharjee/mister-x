@extends('layout.sidenav-layout')
@section('content')
    <div class="row justify-content-around d-flex align-items-center text-center">
        <div class="container card col-3 m-1 p-3">
            <h4>Customers</h4>
            <br>
            <h4 id="customer"></h4>
        </div>

        <div class="container card col-3 m-1 p-3 ">
            <h4>Products</h4>
            <br>
            <h4 id="product"></h4>
        </div>

        <div class="container card col-3 m-1 p-3 ">
            <h4>Category</h4>
            <br>
            <h4 id="category"></h4>
        </div>

        <div class="container card col-3 m-1 p-3 ">
            <h4>Invoice</h4>
            <br>
            <h4 id="invoice"></h4>
        </div>

        <div class="container card col-3 m-1 p-3 ">
            <h4>Total Sale</h4>
            <br>
            <h4 id="total"></h4>
        </div>
        <div class="container card col-3 m-1 p-3 ">
            <h4>Vat</h4>
            <br>
            <h4 id="vat"></h4>
        </div>
    </div>
    <div class="row justify-content-start col-10 m-1 text-center mx-5">
        <div class="container card col-4 m-1 p-3 ">
            <h4>Payable</h4>
            <br>
            <h4 id="payable"></h4>
        </div>
        <div class="container card col-4 m-1 p-3 mx-5">
            <h4>discount</h4>
            <br>
            <h4 id="discount"></h4>
        </div>
    </div>
        <script>
            async function getDashboard()
            {
                let res = await axios.get("/summary-dashboard")
                    console.log(res.data);
                    $("#customer").text(res.data['customer'])
                    $("#product").text(res.data['product'])
                    $("#invoice").text(res.data['invoice'])
                    $("#category").text(res.data['customer'])
                    $("#total").text(res.data['total'])
                    $("#vat").text(res.data['vat'])
                    $("#payable").text(res.data['payable'])
                    $("#discount").text(res.data['discount'])
            }
            getDashboard()
        </script>
    @endsection
