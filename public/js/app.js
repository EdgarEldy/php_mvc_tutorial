$(function () {
    $('#cat_id').on('change', function () {
        var cat_id = $(this).val();
        //alert(cat_id);
        // $.get(url_root + '/orders/getProducts', {cat_id:cat_id}, function(data){
        //         $('#product_id').html(data);
        // });

        if (cat_id) {
            $.ajax({
                type: 'GET',
                async: true,
                url: url_root + '/orders/getProducts',
                data: 'cat_id=' + cat_id,
                success: function (data) {
                    $('#product_id').html(data);
                }
            });
        }
    });
});

$(function () {
    $('#product_id').on('change', function () {
        var product_id = $(this).val();
        $.get(url_root + '/orders/getUnitPrice', { product_id: product_id }, function (data) {
            $('#unit_price').val(data);
        });
    });
});
