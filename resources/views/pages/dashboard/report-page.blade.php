@extends('layout.sidenav-layout')
@section('content')
    <form class="card w-50 mx-auto my-5 p-5">
        <div class="mb-3">
            <label for="from" class="form-label">Form Date</label>
            <input type="date" class="form-control" id="from" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="to" class="form-label">To Date</label>
            <input type="date" class="form-control" id="to">
        </div>
        <button type="submit" onclick="report()" class="btn btn-primary">Submit</button>
    </form>
    <script>
        function report() {
            let form = $("#form").val()
            let to = $("#to").val()
            if (form.length === 0 || to.length === 0) {
                errorToast("Select Date")
            } else {
                window.open("/sale-report/" + from + "/" + to)
            }

        }
    </script>
@endsection
