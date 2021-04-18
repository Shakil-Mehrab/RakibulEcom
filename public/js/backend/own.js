// function product_show_hide() {
//     var click = document.getElementById('product_toggle');
//     if (click.style.display == "none") {
//         click.style.display = "block";
//     } else {
//         click.style.display = "none";
//     }
// }
// function category_show_hide() {
//     var click = document.getElementById('category_toggle');
//     if (click.style.display == "none") {
//         click.style.display = "block";
//     } else {
//         click.style.display = "none";
//     }
// }

    $('#newData').on('click', '.paginate_reload_prevent a', function() {
        var page = $(this).data('id');
        console.log(page)
        if (page) {
            $.get("{{URL::to('/admin/view/product?page=')}}" + page, function(data) {
                $('#newData').empty().append(data);
            });
        }
    });

    $('#newData').on('click', '.delete', function(e) {
        e.preventDefault();
        var link = $(this).attr("href");
        console.log(link)
        bootbox.confirm("Are you sure to delete", function(confirmed) {
            if (confirmed) {
                $.get(link,function(data){
                // window.location.href = link;
            $('#newData').empty().append(data);

                const Toast = Swal.mixin({
                  toast: true,
                  position: 'bottom-end',
                  showConfirmButton: false,
                  timer: 3000,
                })
                if($.isEmptyObject(data.error)){
                    Toast.fire({
                        icon: 'success',
                        title: 'Product Deleted Successfully!'
                    })
                }else{
                    Toast.fire({
                        icon: 'error',
                        title: 'Product Not Deleted!'
                    })
                }
            });
            };
        });
    });
