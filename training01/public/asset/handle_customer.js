$(document).ready(function () {
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": token,
        },
    });
    $('#export_customer').on('click',function (e) {
        // e.preventDefault();
        conditions = getParamSearchCustomer();
        conditions.name =
            conditions.name !== undefined && conditions.name !== null
                ? conditions.name
                : "";
        conditions.email =
            conditions.email !== undefined && conditions.email !== null
                ? conditions.email
                : "";
        conditions.address =
            conditions.address !== undefined && conditions.address !== null
                ? conditions.address
                : "";
        conditions.is_active =
            conditions.is_active !== undefined && conditions.is_active !== null
                ? conditions.is_active
                : "";
        newUrl = `/customers/export?c_name=${conditions.name}&c_email=${conditions.email}&c_address=${conditions.address}&c_is_active=${conditions.is_active}`;
        $('#export_customer').attr('href',newUrl);
        console.log($('#export_customer').attr('href'));

    });
    function clearFormCustomers() {
        $("#c_name").val('');
        $("#c_email").val('');
        $("#c_tel_num").val('');
        $("#c_address").val('');
        $("#c_is_active").prop('checked', true);
    }

    function loadParamToInputSearch() {
        param = new URLSearchParams(window.location.search);
        const page = param.get("page");
        const name = param.get( 'c_name' ) ;
        const c_email = param.get( 'c_email' ) ;
        const c_address = param.get( 'c_address' ) ;
        const c_is_active = param.get("c_is_active");
        $("#s-name").val(name);
        $("#s-email").val(c_email);
        $("#s-address").val(c_address);
        $("#s-is_active").val(c_is_active).change();
        // $("page").val(page);
    }
    loadParamToInputSearch();
    function getParamSearchCustomer() {
        return {
            name: ($("#s-name").val() !==undefined && $("#s-name").val() !== null) ? $("#s-name").val() : '',
            email: ($("#s-email").val() !==undefined && $("#s-email").val() !== null) ? $("#s-email").val() : '',
            address: ($("#s-address").val() !==undefined && $("#s-address").val() !== null) ? $("#s-address").val() : '',
            is_active: ($("#s-is_active").val() !== undefined && $("#s-is_active").val()) !== null ? $("#s-is_active").val() : '',
        };
    }

    function clearValidateCustomerForm() {
        $("#c_name").removeClass("is-invalid");
        $("#c_email").removeClass("is-invalid");
        $("#c_address").removeClass("is-invalid");
        $("#c_tel_num").removeClass("is-invalid");
        $("#u-group").removeClass("is-invalid");
        $(".message-error").text("");
    }

    function LoadTableCustomer(url) {
        param = new URLSearchParams(window.location.search);
        var page = param.get("page");
        page = page!= null ? page : 1;
        conditions = getParamSearchCustomer();
        conditions.is_active =
            conditions.is_active !== undefined && conditions.is_active !== null
                ? conditions.is_active
                : "";
        urlWithParam = `/customers?page=${page}&c_name=${conditions.name}&c_email=${conditions.email}&c_address=${conditions.address}&c_is_active=${conditions.is_active}`;
        if (url != null) {
            history.replaceState(null, null, url);
        } else {
            history.replaceState(null, null, urlWithParam);
        }
        $.ajax({
            url: url || urlWithParam,
            method: "GET",
            dataType: "json",
            data: {
                c_name: conditions.name,
                c_email: conditions.email,
                c_address: conditions.address,
                c_is_active: conditions.is_active,
            },
            success: function (data) {
                $("#table-customer").empty();
                $("#table-customer").append(data.html);
                $("#pagi").empty();
                $("#pagi").append(data.pagination);
            },
            error: function () {},
        });
    }
    //when click search
    $(document).on("click", ".c_search", function (event) {
        event.preventDefault();
        conditions = getParamSearchCustomer();
        urlWithParam = `/customers?c_name=${conditions.name}&c_email=${conditions.email}&c_address=${conditions.address}&c_is_active=${conditions.is_active}`;
        LoadTableCustomer(urlWithParam);
    });
    //when click clear search
    $(".clear-search").on("click", function (event) {
        event.preventDefault();
        $("#s-name").val(""),
            $("#s-email").val(""),
            $("#s-address").val(""),
            $("#s-is_active").val("").change(),
            LoadTableCustomer("/customers");
    });
    //when click pagination item
    $(document).on("click", ".pagination a", function (event) {
        event.preventDefault();
        const myurl = $(this).attr("href");
        conditions = getParamSearchCustomer();
        newUrl = `${myurl}&c_name=${conditions.name}&c_email=${conditions.email}&c_address=${conditions.address}&c_is_active=${conditions.is_active}`;
        var page = $(this).attr("href").split("page=")[1];
        $(this).attr("href", newUrl);
        LoadTableCustomer(newUrl);
    });
    //when click save
    $("#c_save").on("click", function () {
        let id = $("#c_id").val();
        let name = $("#c_name").val();
        let email = $("#c_email").val();
        let tel_num = $("#c_tel_num").val();
        let address = $("#c_address").val();
        let is_active = ($("#c_is_active:checked").val()!=undefined) ? $("#c_is_active:checked").val() : 0;
        $.ajax({
            url: "/customers/create",
            method: "post",
            dataType: "json",
            data: {
                customer_name: name,
                email: email,
                address: address,
                tel_num: tel_num,
                is_active: is_active,
            },
            success: function (response) {
                clearValidateCustomerRow(id);
                console.log(response);
                if (!response.success && response.Errors != null) {
                    if (response.Errors.hasOwnProperty("customer_name")) {
                        $(".message-error.c_name").text(
                            response.Errors.customer_name[0]
                        );
                        $("#c_name").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("email")) {
                        $(".message-error.c_email").text(
                            response.Errors.email[0]
                        );
                        $("#c_email").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("tel_num")) {
                        $(".message-error.c_tel_num").text(
                            response.Errors.tel_num[0]
                        );
                        $("#c_tel_num").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("address")) {
                        $("#c_address").addClass("is-invalid");
                        $(".message-error.c_address").text(
                            response.Errors.address[0]
                        );
                    }                   
                }
                if (response.success) {
                    clearValidateCustomerForm();
                    $('#c_close').click();
                    LoadTableCustomer('/customers');
                }
            },
            error: function () {},
        });
    });
    $(document).on('click', '.c_edit', function() {
        $(this).addClass('hidden');
        const c_id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const telNum = $(this).data('tel_num');
        const address =$(this).data('address');
        $('#c_name_' + c_id).html('<input class="form-control" type="text" id="edit_c_name_' + c_id + '" value="' + name + '"><div class="message-error c_name_'+c_id+' text-danger mt-1"></div>');
        $('#c_email_' + c_id).html('<input class="form-control" type="email" id="edit_c_email_' + c_id + '" value="' + email + '"><div class="message-error c_email_'+c_id+' text-danger mt-1"></div>');
        $('#c_tel_num_' + c_id).html('<input class="form-control" type="tel" id="edit_c_tel_num_' + c_id + '" value="' + telNum + '"><div class="message-error c_tel_num_'+c_id+' text-danger mt-1"></div>');
        $('#c_address_' + c_id).html('<input class="form-control" type="text" id="edit_c_address_' + c_id + '" value="' + address + '"><div class="message-error c_address_'+c_id+' text-danger mt-1"></div>');
        $('#c_cancel_edit_'+ c_id).removeClass('hidden');
        $('#c_save_edit_'+ c_id).removeClass('hidden');
        
    });
    function getValueInRowCustomer(id){
        let name=$('#edit_c_name_' + id).val();
        let email=$('#edit_c_email_' + id).val();
        let tel_num=$('#edit_c_tel_num_' + id).val();
        let address=$('#edit_c_address_' + id).val();
       return data={
        id: id,
        name:name,
        email:email,
        tel_num:tel_num,
        address:address
       }

    }
    function clearValidateCustomerRow(id) {
        $("#edit_c_name_" + id).removeClass("is-invalid");
        $("#edit_c_email_" + id).removeClass("is-invalid");
        $("#edit_c_tel_num_" + id).removeClass("is-invalid");
        $("#edit_c_address_" + id).removeClass("is-invalid");
        $(".message-error.c_name_" + id).text("");
        $(".message-error.c_email_" + id).text("");
        $(".message-error.c_tel_num_" + id).text("");
        $(".message-error.c_address_" + id).text("");
    }
    // when click save in row
    $(document).on('click','.c_save_edit',function() {
        var c_id = $(this).data('id');
        $('#c_edit'+c_id).toggleClass('hidden');
        let name=$('#edit_c_name_' + c_id).val();
        let email=$('#edit_c_email_' + c_id).val();
        let tel_num=$('#edit_c_tel_num_' + c_id).val();
        let address=$('#edit_c_address_' + c_id).val();
        $.ajax({
            url:'/customers/update',
            method: "PUT",
            data: { customer_id: c_id,
                customer_name: name,
                email: email,
                tel_num: tel_num,
                address: address
            },
            success: function(response) {
                clearValidateCustomerRow(c_id);
                if (!response.success && response.Errors != null) {
                    if (response.Errors.hasOwnProperty("customer_name")) {
                        $(".message-error.c_name_"+c_id).text(
                            response.Errors.customer_name[0]
                        );
                        $("#edit_c_name_" + c_id).addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("email")) {
                        $(".message-error.c_email_"+c_id).text(
                            response.Errors.email[0]
                        );
                        $("#edit_c_email_" + c_id).addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("tel_num")) {
                        $(".message-error.c_tel_num_"+c_id).text(
                            response.Errors.tel_num[0]
                        );
                        $("#edit_c_tel_num_" + c_id).addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("address")) {
                        $("#edit_c_address_" + c_id).addClass("is-invalid");
                        $(".message-error.c_address_"+c_id).text(
                            response.Errors.address[0]
                        );
                    }                   
                }
                if(response.success) {
                    $('#c_edit'+c_id).removeClass('hidden');
                    LoadTableCustomer()
                }
            },
            error: function () {},
        })

    });
    //when click cancel in row
    $(document).on("click",'.c_cancel_edit', function(){
        var c_id = $(this).data('id');
        const data = getValueInRowCustomer(c_id);
        $('#c_name_' + c_id).text(data.name);
        $('#c_email_' + c_id).text(data.email);
        $('#c_tel_num_' + c_id).text(data.tel_num);
        $('#c_address_' + c_id).text(data.address);
        $(this).addClass('hidden');
        $('#c_save_edit_'+ c_id).addClass('hidden');
        $('#c_edit'+c_id).removeClass('hidden');
    });
    //when submit form sreach
    $(document).on('submit','#form-search-customer', function(e){
        e.preventDefault();
        $('.c_search').click();
    })
    //when click create customer/ open form
    $(document).on('click','.create', function(e){
        e.preventDefault();
        clearFormCustomers()
        clearValidateCustomerForm();
    });
    //import customer
    $('.import').click(function(e) {
        e.preventDefault();
        $('#formFile').click();
        $('#formFile').change(function() {
            // console.log( $("#formFile").prop("files")[0]);
            $('#importCustomer').submit();
        });
    });

});
