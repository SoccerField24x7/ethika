<?php

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>

    <title>Order Management</title>
    <style>
        #nav-back:hover {
            cursor: pointer;
        }
        #nav-back-container {
            display: none;
        }
    </style>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
<div id="appZ">
    <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
        <div class="container">
            <a href="#" class="navbar-brand"><img src="images/ethika.png" height="75" /></a>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/order">Create Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/search">Search Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div>
            <div class="card card-header mb-2" id="search-header"><h2>Order Search</h2></div>
            <div class="card card-header mb-2" id="nav-back-container"><i class="fas fa-arrow-left fa-2x" id="nav-back" style="width:100px;"></i></div>
            <div class="alert" style="display:none;" id="err-message"></div>
            <div class="card card-body" id="search-form">
                <h3>By Customer</h3>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-12 mb-2"><input class="form-control" type="text" name="first_name" id="first-name" placeholder="First Name" /></div>
                        <div class="col-md-12 mb-2"><input class="form-control" type="text" name="last_name" id="last-name" placeholder="Last Name" /></div>
                        <div class="col-md-12 mb-2"><input class="form-control" type="text" name="email" id="email" placeholder="Email Address" /></div>
                        <div class="col-md-12 mb-4"><input class="form-control" type="text" name="name" id="name" placeholder="Product Name" /></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12 text-right"><button class="btn btn-success" id="do-search">Search</button></div>
                    </div>
                </div>
            </div>
        </div>
        <table id="dtable" style="display:none;" class="table table-striped table-bordered">
            <thead>
            <tr><th>Order Id</th><th>First Name</th><th>Last Name</th><th>Email Address</th><th>Line Items</th></tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    @csrf
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#do-search').on('click', function() {
            let fname = $('#first-name').val() === '' ? null : $('#first-name').val();
            let lname = $('#last-name').val() === '' ? null : $('#last-name').val();
            let email = $('#email').val() === '' ? null : $('#email').val();
            let product = $('#name').val() === '' ? null : $('#name').val();

            $('#err-message').removeClass('alert-danger').html('').hide();

            if(product === null && fname === null && lname === null && email === null) {
                $('#err-message').addClass('alert-danger').html('You did not select any search criteria.').show();
                return false;
            }

            $('#search-form').hide();

            getData(fname, lname, email, product); // TODO: add promise

        });

        getToken();
    });

    function getData(first, last, email, product) {
        const postData = {
            'fname': first,
            'lname': last,
            'email': email,
            'product': product
        };

        $.ajax({
            url: '/api/1.0/order-search',
            data: JSON.stringify(postData),
            headers: {
                'X-CSRF-TOKEN': $('input[name=_token]').val(),
                'Content-Type': 'application/json'
            },
            error: function(err) {
                console.log(err);
            },
            success: function(data) {
                let obj = JSON.parse(data);
                $.each(obj, function(a, item) {
                    $('tbody').append('<tr><td>' + item.id + '</td><td>' + item.first_name + '</td><td>' + item.last_name + '</td><td>' + item.email + '</td><td>' + item.order_items.length + '</td></tr>');
                });


                $('#search-header').hide();
                $('#nav-back-container').show();
                $('#dtable').show().DataTable();
            },
            type: 'POST'
        });
    }

    function getToken() {
        $.ajax({
            url: '/api/1.0/get-csrf',
            //data: header_dto,
            error: function(err) {
                console.log(err);
            },
            //dataType: 'jsonp',
            success: function(data) {
                $('input[name=_token]').val(data);
            },
            type: 'GET'
        });
    }

    $('#nav-back').on('click', function() {
        $('#dtable_wrapper').hide();
        $('#nav-back-container').hide();
        $('#search-header, #search-form').show();
        $('#first-name').val('');
        $('#last-name').val('');
        $('#email').val('');
        $('#product').val('');

    });

</script>

</body>
</html>
