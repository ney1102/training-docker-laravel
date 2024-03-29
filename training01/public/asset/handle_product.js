let editor; // Biến toàn cục để lưu trữ thể hiện của trình soạn thảo
$(document).ready(function () {
    $('#description').summernote({
        placeholder: 'Mô tả sản phẩm',
        height: 200,
        toolbar: [
          // [groupName, [list of button]]
          ['view', ['codeview']],
          ['style', ['bold', 'italic', 'underline']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ]
      });
    //set data
    // $('#description').summernote('code', markupStr);
    //get data
    // $('#description').summernote('code');
    
   
    const token = $('meta[name="csrf-token"]').attr("content");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": token,
        },
    });
    

    function showBtnDeleteImg(){

    }
    function loadParamToInputSearch() {
        param = new URLSearchParams(window.location.search);
        const page = param.get("page");
        const name = param.get( 'name' ) ;
        const price_from = param.get( 'price_from' ) ;
        const price_to = param.get( 'price_to' ) ;
        const is_sales = param.get("is_sales");
        $("#s_name").val(name);
        $("#s_from").val(price_from);
        $("#s_to").val(price_to);
        $("#s_is_sales").val(is_sales).change();
        // $("page").val(page);
    }
    loadParamToInputSearch();
    function hoverLoadImg(){
            $(".td_product_name").hover(function () {
                $(this).find("img.rounded").removeClass('hidden');
              },function () {
                let url = $(this).data('urlImg')
              $(this).find("img.rounded").addClass('hidden');
          },);

        //   $(".td_product_name").mouseleave();
    }
    hoverLoadImg();
    function getParamSearchProduct() {
        let name = $("#s_name").val();
        let is_sales = $("#s_is_sales").val();
        let price_from = $("#s_from").val();
        let price_to = $("#s_to").val();
        return (data = {
            name: name,
            is_sales: is_sales,
            price_from: price_from,
            price_to: price_to,
        });
    }
    function getValueInputProductForm() {
        let id = $("#p_id").val();
        let name = $("#p_name").val();
        let price = $("#p_price").val();
        let is_sales = $("#p_is_sales").val();
        // let description = $("#description").val();
        let description = $('#description').summernote('code');
        return (data = {
            id: id,
            name: name,
            price: price,
            is_sales: is_sales,
            description: description,
            //image
        });
    }

    function clearValueInputForm() {
        $("#p_id").val("");
        $("#p_name").val("");
        $("#p_price").val("");
        $("#p_is_sales").val("").change();
        // $("#description").val("");
        $("#description").summernote('code','')
        $('#product_image').val("");
        $('#show_img').empty();
        $('#notification_alert_modal').empty();
    }
    function clearParamSearchProduct() {
        $("#s_name").val("");
        $("#s_is_sales").val("").change();
        $("#s_from").val("");
        $("#s_to").val("");
    }
    function clearValidateProductForm() {
        $(".message-error.p_is_sales").text("");
        $("#p_is_sales").removeClass("is-invalid");
        $(".message-error.p_price").text("");
        $("#p_price").removeClass("is-invalid");
        $(".message-error.p_name").text("");
        $("#p_name").removeClass("is-invalid");
        $(".message-error.p_product_image").text("");
        $("#product_image").removeClass("is-invalid");
    }

    function LoadValueProductToForm(
        id,
        name,
        price,
        is_sales,
        description,
        imageurl
    ) {
        $("#p_id").val(id);
        $("#p_name").val(name);
        $("#p_price").val(price);
        $("#p_is_sales").val(is_sales).change();
        $('#description').summernote('code',description) ;
        // $("#show_img").attr("src", imageurl);
    }
    function LoadTableProduct(url) {
        var conditions = getParamSearchProduct();
        param = new URLSearchParams(window.location.search);
        var page = param.get("page");
        page = page != null ? page : 1;
        currentUrl = window.location.href;
        conditions.is_sales =
            conditions.is_sales !== undefined && conditions.is_sales !== null
                ? conditions.is_sales
                : "";
        urlWithParam = `/products?page=${page}&name=${conditions.name}&is_sales=${conditions.is_sales}&price_from=${conditions.price_from}&price_to=${conditions.price_to}`;
        if (url != null) {
            history.pushState(null, null, url);
        } else {
            history.pushState(null, null, urlWithParam);
        }
        $.ajax({
            url: url || urlWithParam,
            method: "GET",
            dataType: "json",
            data: {
                s_name: conditions.name,
                s_is_sales: conditions.is_active,
                s_form: conditions.price_from,
                s_to: conditions.price_to,
            },
            success: function (data) {
                $("#table_component").empty();
                $("#table_component").append(data.html);
                $("#pagi").empty();
                $("#pagi").append(data.pagination);
            },
            error: function () {},
        });
    }
    function getImageProductById(id) {
        if (id!=0) {
            $.ajax({
                url: "/products/get-img",
                method: "get",
                data: { id: id },
                dataType: "json",
                success: function (response) {
                    $("#show_img").empty();
                    $("#show_img").append(response.img);
                },
            });
        }
    }
    $(document).on("click", ".p_edit", function (e) {
        e.preventDefault();
        clearValidateProductForm();
        clearValueInputForm();
        const id = $(this).data("id");
        const name = $(this).data("name");
        // const description = $(this).data("description");
        const description =$(this).data("description");
        const price = $(this).data("price");
        const is_sales = $(this).data("is_sales");
        let image = $(this).data("img");
        $('#delete-img').removeClass('hidden');   
        LoadValueProductToForm(id, name, price, is_sales, description, image);
        getImageProductById(id);
        // if(id!=0||id!=null){
        // }
    });
    //when click srearch
    $(document).on("click", ".p_search", function (e) {
        e.preventDefault();
        conditions = getParamSearchProduct();
        conditions.name =
            conditions.name !== undefined && conditions.name !== null
                ? conditions.name
                : "";
        conditions.price_from =
            conditions.price_from !== undefined &&
            conditions.price_from !== null
                ? conditions.price_from
                : "";
        conditions.price_to =
            conditions.price_to !== undefined && conditions.address !== null
                ? conditions.price_to
                : "";
        conditions.is_sales =
            conditions.is_sales !== undefined && conditions.is_sales !== null
                ? conditions.is_sales
                : "";
        newUrl = `/products?name=${conditions.name}&price_from=${conditions.price_from}&price_to=${conditions.price_to}&is_sales=${conditions.is_sales}`;

        LoadTableProduct(newUrl);
    });
    // when click clear search
    $(document).on("click", ".p_clear_search", function (e) {
        e.preventDefault();
        clearParamSearchProduct();
        LoadTableProduct("/products");
    });
    //when click pagination item
    $(document).on("click", ".pagination a", function (event) {
        event.preventDefault();
        const myurl = $(this).attr("href");
        conditions = getParamSearchProduct();
        conditions.name =
            conditions.name !== undefined && conditions.name !== null
                ? conditions.name
                : "";
        conditions.price_from =
            conditions.price_from !== undefined &&
            conditions.price_from !== null
                ? conditions.price_from
                : "";
        conditions.price_to =
            conditions.price_to !== undefined && conditions.address !== null
                ? conditions.price_to
                : "";
        conditions.is_sales =
            conditions.is_sales !== undefined && conditions.is_sales !== null
                ? conditions.is_sales
                : "";
        newUrl = `${myurl}&name=${conditions.name}&price_from=${conditions.price_from}&price_to=${conditions.price_to}&is_sales=${conditions.is_sales}`;
        var page = $(this).attr("href").split("page=")[1];
        $(this).attr("href", newUrl);
        LoadTableProduct(newUrl);
    });
    //when click create a new product
    $(document).on("click", ".create", function (e) {
        clearValidateProductForm();
        clearValueInputForm();
        $('#delete-img').addClass('hidden');        
        
    });
    //when click delete product
    $(document).on("click", ".p_delete", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        var arlert = `
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024"><path fill="#4db051" d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z"/></svg>                <strong>OK! </strong> Xóa sản phẩm thành công
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close"
                ></button>
            </div>
        `;
        if (confirm("Bạn có muốn xóa sản phẩm này không?")) {
            $.ajax({
                url: "/products/delete",
                method: "DELETE",
                dataType: "json",
                data: {
                    id: id,
                },
                success: function (response) {
                    if (response.success) {
                        LoadTableProduct();
                        $("#notification_alert").append(arlert);
                    }
                },
            });
        }
    });
    //when click save product
    $(document).on("click", ".p_save_product", function (e) {
        var product = getValueInputProductForm();
        let product_image = $("#product_image").prop("files")[0];
        // console.log(product.description);
        // $("#form-product").submit();
        var data = new FormData();
        data.append('id',product.id);
        data.append("product_name", product.name);
        data.append("description", product.description);
        data.append("product_price", product.price);
        data.append("is_sales", (product.is_sales!=null) ? product.is_sales : '');
        data.append("product_image", product_image !== undefined && product_image!==null ? product_image : '');
        $.ajax({
            url: "/products/save",
            method: "POST",
            dataType: "json",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                clearValidateProductForm();
                if (!response.success && response.Errors != null) {
                    if (response.Errors.hasOwnProperty("product_name")) {
                        $(".message-error.p_name").text(
                            response.Errors.product_name[0]
                        );
                        $("#p_name").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("product_price")) {
                        $(".message-error.p_price").text(
                            response.Errors.product_price[0]
                        );
                        $("#p_price").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("is_sales")) {
                        $(".message-error.p_is_sales").text(
                            response.Errors.is_sales[0]
                        );
                        $("#p_is_sales").addClass("is-invalid");
                    }
                    if (response.Errors.hasOwnProperty("product_image")) {
                        $(".message-error.p_product_image").text(
                            response.Errors.product_image[0]
                        );
                        $("#product_image").addClass("is-invalid");
                    }
                }
                if (response.success) {
                    $("#p_close").click();
                    var arlert = `
                    <div class="alert alert-${response.type} alert-dismissible fade show" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
                            <path fill="#4db051" d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z"/>
                        </svg>
                        <strong>OK! </strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    $("#notification_alert").append(arlert);
                    clearValidateProductForm();
                    clearValueInputForm();
                    if (product.id != 0 || product.id != ''){
                        LoadTableProduct();
                    }
                    else {
                        clearParamSearchProduct();
                        LoadTableProduct('/products');
                    }
                }
            },
        });
    });
    $(document).on("submit", "#form-product", function (e) {
        e.preventDefault();
        // var data = new FormData(this);
    });
    //when click delete image
    $(document).on("click", "#delete-img", function (e) {
        let id = $('#p_id').val();
        $.ajax({
            url: "/products/delete-image",
            data: { id: id },
            method: "DELETE",
            dataType: "json",
            success: function (response) {
                $
                message = `<div class="alert alert-${response.type} alert-dismissible fade show" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 1024 1024">
                            <path fill="#4db051" d="M512 64a448 448 0 1 1 0 896a448 448 0 0 1 0-896m-55.808 536.384l-99.52-99.584a38.4 38.4 0 1 0-54.336 54.336l126.72 126.72a38.27 38.27 0 0 0 54.336 0l262.4-262.464a38.4 38.4 0 1 0-54.272-54.336z"/>
                        </svg>
                        <strong>OK! </strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                if (!response.success) {
                    $('#notification_alert_modal').append(message)
                }
                else {
                    $('#notification_alert_modal').append(message);
                    $('#show_img').empty();
                }
            },
        });
    });
    // when submit search
    $(document).on('submit','#form-search-user',function (e) {
        e.preventDefault();        
    })
});
