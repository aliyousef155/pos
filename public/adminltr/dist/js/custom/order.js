$(document).ready(function () {
   $('.add-product-btn').on('click',function (e) {
       e.preventDefault();
       let name= $(this).data('name');
       let id= $(this).data('id');
       let price= $(this).data('price');
       let stock= $(this).data('stock');
       let html=`<tr>
                    <td>${name}</td>

                    <td><input type="number"  name="products[${id}][quantity]" id="" data-price="${price}" class="form-control input-sm product-quantity" min="1" value="1" max="${stock}"></td>
                     <td>${price}</td>
                    <td class="product-price">${price} </td>
                    <input class="product-price2" type="hidden" value="${price}" name="total_units_price[]" >
                    <td >${stock} </td>
                    <td><button class="btn btn-danger btn-sm remove-product-button" data-id="${id}"><span class="fa fa-trash"></span></button></td>
                </tr>`
       $('.order-list').append(html);
       calculate_total()
       $(this).removeClass('btn-success').addClass('btn-default disabled');
       if (price > 0){
           $('.add-order-form-btn').removeClass('disabled');
       }else {
           $('.add-order-form-btn').addClass('disabled');
       }
   })// end of add-product-btn function




    $('body').on('click','.disabled',function (e) {
        e.preventDefault();

    }); // end of disabled btn
    $('body').on('click','.remove-product-button',function (e) {
        e.preventDefault();
        let id=$(this).data('id');
        $('#product-'+id).removeClass('btn-default disabled').addClass('btn-success');
        $(this).closest('tr').remove();
        calculate_total()


    })// end of remove product button
    $('body').on('keyup change','.product-quantity',function () {
        let quantity=parseInt($(this).val());
        let unitPrice=$(this).data('price');
        $(this).closest('tr').find('.product-price').html(quantity * unitPrice);
        $(this).closest('tr').find('.product-price2').html(quantity * unitPrice);
        calculate_total()

    })//end of quantity

})// end of ready

//calculate the total price
function calculate_total() {
    let price=0;
    $('.order-list .product-price').each(function (index) {
    price+=parseInt($(this).html());
    });//end of product price
        $('.total-price').html(price);
    if (price > 0){
        $('.add-order-form-btn').removeClass('disabled');
    }else {
        $('.add-order-form-btn').addClass('disabled');
    }
}//end of calculate

//show the order to print
$('.order-product').on('click',function (e) {
    e.preventDefault();
    let url=$(this).data('url');
    let method=$(this).data('method');
    $.ajax({
        url:url,
        method:method,
        success:function (data) {
            $('#order-product-list').empty();

            $('#order-product-list').append(data);
        }
    })
})//end of show product
