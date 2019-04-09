<template>
    <div>
        <div class="card card-header mb-2"><h2>Order Entry</h2></div>
        <div class="alert" style="display:none;" id="err-message"></div>
        <div class="card card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-12 mb-2"><input class="form-control" type="text" name="first_name" id="first-name" placeholder="First Name" /></div>
                    <div class="col-md-12 mb-2"><input class="form-control" type="text" name="last_name" id="last-name" placeholder="Last Name" /></div>
                    <div class="col-md-12 mb-4"><input class="form-control" type="text" name="email" id="email" placeholder="Email Address" /></div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 text-right"><button class="btn btn-success" id="add-line">Add Line</button></div>
                </div>
            </div>
            <div class="row text-center" id="sub-button-container">
                <button id="can-button" class="btn btn-danger">Cancel Order</button>
                <button id="sub-button" class="btn btn-secondary">Save Order</button>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
	export default {
		name: "Entry"
	}

	let lineno = 0;

	$(document).ready(function() {
        $('#add-line').on('click', function() {
            $('.form-group').append('<div class="row mb-1 item item' + lineno + '">' +
                '<div class="col-md-2"><input class="form-control" name="line_number" id="line-number" placeholder="Line Number" /></div>' +
                '<div class="col-md-6"><input class="form-control" name="name" id="name" placeholder="Item Name" /></div>' +
                '<div class="col-md-3"><input class="form-control" name="quantity" id="quantity" placeholder="Quantity" /></div>' +
            '</div>');

            /* enable submit button */
            $('#sub-button-container').show();

            $('.item' + lineno +' #line-number').val(lineno++);
        });

        getToken();

        $('#sub-button').on('click', function() {
            /* package up the data */
            let header_dto = {
                first_name: $('#first-name').val(),
                last_name: $('#last-name').val(),
                email: $('#email').val(),
                order_items: []
            };

            let count = 0;
            for(let i=0; i < lineno; i++) {
                let items_dto = {
                    line_number: -1,
                    order_id: -1,
                    name: '',
                    quantity: -1
                };

                items_dto.line_number = $('.item' + i + ' #line-number').val();
                items_dto.name = $('.item' + i + ' #name').val();
                items_dto.quantity = $('.item' + i + ' #quantity').val();

                header_dto.order_items.push(items_dto);
            }

            /* AJAX to API */
            $.ajax({
                url: '/api/1.0/order-save',
                data: JSON.stringify(header_dto),
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val(),
                    'Content-Type': 'application/json'
                },
                error: function(err) {
                    console.log(err);
                },
                success: function(data) {
                    let obj = JSON.parse(data);
                    if (typeof obj.Error !== 'undefined') {
                        $('#err-message').addClass('alert-danger').html(obj.Error).show();
                        return false;
                    }
                    if (typeof obj.Success !== 'undefined') {
                        $('#err-message').html('Order ' + obj.data.id + ' was saved successfully.').removeClass('alert-danger').addClass('alert-success').show();
                        resetForm();
                    } else {
                        /* unspecified error */
                        $('#err-message').addClass('alert-danger').html('An unspecified error was encountered.').show();
                    }
                },
                type: 'POST'
            });
        });

        $('#can-button').on('click', function() {
            resetForm();
            $('#err-message').removeClass('alert-danger').removeClass('alert-success').hide();
        });

        function getToken() {
            $.ajax({
                url: '/api/1.0/get-csrf',
                error: function(err) {
                    console.log(err);
                },
                success: function(data) {
                    $('input[name=_token]').val(data);
                },
                type: 'GET'
            });
        }

        function resetForm() {
            lineno = 0;
            $('#first-name').val('');
            $('#last-name').val('');
            $('#email').val('');

            $('.item').each(function() {
                $(this).remove();
            });

            $('#sub-button-container').hide();
        }
    });

</script>

<style scoped>
    #sub-button-container {display:none;}
</style>
