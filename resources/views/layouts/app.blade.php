<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hatirpal') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Styles -->
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
    <script src="https://kit.fontawesome.com/bb2f33706c.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/backend/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/backend/nav_left_navigation.css')}}">
    
</head>

<body>
    <div id="app">
        @include('layouts.includes.nav')
        <div class="container-fluid">
            <div class="row" >
                <div class="col-lg-2 col-md-3 col-sm-4 left_navigation" style="margin-top: 55px;">
                    @include('layouts.includes.leftNavigation')
                </div>
                <div class="col-lg-10 col-md-9 col-sm-8 main_content" style="margin-top: 55px;height:600px;overflow:scroll;">
                    @include('message.alert')
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="">
            <div class="text-center copyright">
                All Rights reserver by &copy; Admin
            </div>
        </footer>
    </div>
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script type="text/javascript"
        src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script type="text/javascript">
        $(function() {
            $('#dataTable').on('change', '#per_page', function() {
                var model = $(this).data('model');
                var per_page = $(this).val();
                console.log(model)
                if (per_page) {
                    $.get("{{URL::to('/admin/view')}}"+'/'+model+'?per-page=' + per_page, function(data) {
                        $('#newData').html(data);
                    });
                }
            });
        });
        $(function() {
            $('#dataTable').on('keyup', '#search', function() {
                var model=$(this).data('model');
                var query = $(this).val();
                console.log(model)
                console.log(query)
                $.get("{{URL::to('/admin/search')}}"+'/'+model+'?query=' + query, function(data) {
                    $('#newData').empty().append(data);
                });
            });
        });
        $(function() {
            $('#newData').on('click', '.paginate_reload_prevent a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                console.log(url)
                if (url) {
                    $.get(url, function(data) {
                        $('#newData').empty().append(data);
                    });
                }
            });
        });
        $(function() {
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
                                title: 'Deleted Successfully!'
                            })
                        }else{
                            Toast.fire({
                                icon: 'error',
                                title: 'Not Deleted!'
                            })
                        }
                    });
                    };
                });
            });
        });
    </script>
    @yield('js')
</body>

</html>
