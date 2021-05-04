<div id="newData">

    <form action="{{url('admin/bulk/delete')}}" method="post" id="bulkDelete">
        @csrf
        <div class="bulk_option">
            <strong>Bulk Option</strong>
            <input type="text" name="model" value="{{$model}}" hidden>
            <select name="with_selected" data-model="{{$model}}" id="check_for_delete">
                <option value="">With Selected</option>
                <option value="delete">Delete</option>
            </select>
            <input type="submit" value="Submit">
            @if ($errors->has('checked_slug'))
            <span class="help-block">
                <strong style="color:red">{{ $errors->first('checked_slug') }}</strong>
            </span>
            @endif

        </div>
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" id="selectallboxes">
                    </th>
                    @foreach($columns as $column)
                    <th>{{ucfirst(str_replace('_',' ',$column))}}</th>
                    @endforeach

                    @if($model=='product')
                    <th>Category</th>
                    <th>Size</th>
                    @endif

                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @forelse($datas as $data)
                <tr class="bordered">
                    <td>
                        <input type="checkbox" name="checked_slug[]" value="{{$data->slug}}" class="selectall">
                    </td>
                    @foreach($columns as $column)
                    @if($column=='thumbnail')
                    <td>
                        <img src="{{asset($data->$column)}}" alt="No image" width="50px">
                        @if($model=='product')({{$data->productImages->count()}})@endif
                    </td>
                    @elseif($column=='user_id')
                    <td>{{$data->user_id}}</td>
                    @elseif($column=='status')
                    <td>
                        <input type="checkbox" id="toggle-demo" class="ArtStatus btn btn-success btn-sm" rel="1" data-toggle="toggle" data-on="Enabled" data-of="Disabled" data-onstyle="success" data-offstyle="danger" checked>
                        <div id="myElem" style="display:none;" class="alert alert-success">Status Enabled</div>
                    </td>
                    @else
                    <td>{{$data->$column}}</td>
                    @endif
                    @endforeach

                    @if($model=='product')
                    <td>
                        @forelse($data->categories as $category)
                        {{$category->name}} ,<br>
                        @empty
                        No Category
                        @endforelse
                    </td>
                    <td>
                        @forelse($data->sizes as $size)
                        {{$size->size}} ,
                        @empty
                        No Size
                        @endforelse
                    </td>
                    @endif

                    <td>
                        <a href="{{url('admin/edit/'.$model,$data->slug)}}" style="color:blue"><i class="fas fa-pencil-alt"></i></a>
                        <a href="{{url('admin/delete/'.$model,$data->slug)}}" class="delete" style="color:red"><i class="far fa-trash-alt"></i></a>
                        @if($model=='category'){{$data->products->count()}}@endif
                    </td>
                </tr>
                @empty
                @endforelse
            </tbody>
        </table>
        <nav aria-label="..." class="pagintion_nav {{$datas->lastPage()==1?'pagination_display':''}}">
            <ul class="pagination">
                <li class="page-item paginate_reload_prevent {{$datas->currentPage()=='1'?'disabled':''}}">
                    @php
                    $previous=$datas->currentPage()-1;
                    $next=$datas->currentPage()+1;
                    @endphp
                    <!-- @if($datas->currentPage()=='1')
                    <span class="page-link">Previous</span>
                    @else -->
                    <!-- @endif -->

                    <a class="page-link" data-id="{{$datas->currentPage()-1}}" href="{{URL::to('/admin/view/'.$model.'?page='.$previous)}}">Previous</a>
                </li>
                @for($i=1;$i<=$datas->lastPage();$i++)
                    <li class="page-item paginate_reload_prevent {{ $datas->currentPage()==$i ? 'active' : '' }}">
                        <a class="page-link" data-id="{{$i}}" href="{{URL::to('/admin/view/'.$model.'?page='.$i)}}">{{$i}}</a>
                    </li>
                    @endfor
                    <!-- <li class="page-item active" aria-current="page">
                <span class="page-link">2</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li> -->
                    <li class="page-item paginate_reload_prevent {{$datas->currentPage()==$datas->lastPage()?'disabled':''}}">
                        <!-- @if($datas->currentPage()==$datas->lastPage())
                        <span class="page-link">Next</span>
                        @else -->
                        <!-- @endif -->

                        <a class="page-link" data-id="{{$datas->currentPage()+1}}" href="{{URL::to('/admin/view/'.$model.'?page='.$next)}}">Next</a>
                    </li>
            </ul>
        </nav>
    </form>
</div>