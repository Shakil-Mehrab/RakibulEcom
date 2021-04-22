<div class="media_body">
    <div class="user_image">
        <div class="user_img mr-1">
            <img src="{{asset(auth()->user()->thumbnail)}}" alt="user" width="60px">
        </div>
        <h6><a href="#">Rakibul Islam</a></h6>
    </div>
    <ul class="tree_ul">
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
                Product
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul">
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/product')}}">Add Product</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/product')}}">View Product</a></li>
            </ul>
        </li>
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
            Category
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul">
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/category')}}">Add Category</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/category')}}">View Category</a></li>
            </ul>
        </li>
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
            User
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul">
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/user')}}">View User</a></li>
            </ul>
        </li>
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
            Region
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul">
            <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/region')}}">Add Region</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/region')}}">View Region</a></li>
            </ul>
        </li>
        </li>
        <li class="tree_li mb-2">
            <a class="change_color_to_dark_white" href="#" style="position: relative;" onclick="product_show_hide()">
            Contact
                <i class="fas fa-chevron-right"></i>
            </a>
            <ul class="tree_li_ul">
            <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/create/contact')}}">Add Contact</a></li>
                <li class="tree_li_ul_li"><a class="change_color_to_dark_white" href="{{url('admin/view/contact')}}">View Contact</a></li>
            </ul>
        </li>
    </ul>
</div>