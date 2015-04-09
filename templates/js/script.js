$( document ).ready(function() {
    $('.deleteFromCart').on('click', function(){
       var id = parseInt($(this).parent().parent().find('.deleteFromCart').attr('name'));
        deleteBookFromCart(id);
    });

$('.down').on('click', function(){
    var book_id = parseInt($(this).parent().parent().find('.book_id').attr('name'));
    var total = $('.totalSum').html();
    var q = parseInt($(this).parent().parent().find('.quantity').text())-1;
    var price = parseFloat($(this).parent().parent().find('.price').text());
    var quant;
    if(1 > q)
    {
        quant = 1;
        q = 1;
        oneBook = price;
        total = total
    }
    else
    {
        quant =  q;
        oneBook = price / (quant + 1);
        total = total-oneBook;
        total = Math.round(total * 100) / 100;
        $('.totalSum').html(total);
    }
    var sum = oneBook*q;

    var newQ = $(this).parent().parent().find('.quantity').html(quant);

    $(this).parent().parent().find('.price').html(sum.toFixed(2));
    quantity(book_id, q);

});

$('.up').on('click', function(){
    var book_id = parseInt($(this).parent().parent().find('.book_id').attr('name'));
    var q = parseInt($(this).parent().parent().find('.quantity').text())+1;
    var total = parseFloat($('.totalSum').html());
    var newQ = $(this).parent().parent().find('.quantity').html(q);
    var price = parseFloat($(this).parent().parent().find('.price').html());
    var quant = q;
    var oneBook = price / (quant -1);
    oneBook = Math.round(oneBook * 100) / 100;
    var sum = oneBook*q;
    total = total+oneBook;
    total = Math.round(total * 100) / 100;
    $('.totalSum').html(total);

    var newQ = $(this).parent().parent().find('.quantity').html(quant);
    $(this).parent().parent().find('.price').html(sum.toFixed(2));
    quantity(book_id, q);


});

function quantity(book_id, newQ)
{

    //console.log(newQ);
    $.ajax({
        url: '/Ajax/addQuantity/id/'+book_id+'/quantity/'+newQ+'/',
        method: 'GET'
    });
}

    function deleteBookFromCart(id)
    {
        $.ajax({
            url: '/Ajax/delete/id/'+id+'/',
            method: 'GET'
        }).then(function(){
            document.location.href = '/Cart/index/';
        });
    }
});

