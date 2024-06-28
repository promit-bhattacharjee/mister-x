@extends('layout.sidenav-layout')
@section('content')
   <div class="row justify-content-around">
    <div class="col-4">
        @include('components.sales.sale-invoice-details')
    </div>
    <div class="col-4">
        @include('components.sales.sale-product-details')
   </div>
    <div class="col-4">
        @include('components.sales.sale-customer-details')
   </div>
@endsection
<script>

</script>
