<div class="media_body">
    <div class="user_image">
        <div class="user_img mr-1">
            <img src="/images/default/user.jpeg" alt="user" width="60px">
        </div>
        <h6><a href="#">Rakibul Islam</a></h6>
    </div>
    <ul class="tree_ul">
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
                Product
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul" id="product_toggle">
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/product')}}">Add Product</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/product')}}">View Product</a></li>
            </ul>
        </li>
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
            Category
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul" id="product_toggle">
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/category')}}">Add Category</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/category')}}">View Category</a></li>
            </ul>
        </li>
    </ul>
</div>