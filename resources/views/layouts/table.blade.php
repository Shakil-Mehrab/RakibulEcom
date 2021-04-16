<h6 class="total_data_rows" >Product Table ({{$datas->total()}})</h6>

<div id="newData">

    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                @foreach($columns as $column)
                <th>{{ $column }}</th>
                @endforeach
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($datas as $data)
            <tr class="bordered">
                @foreach($columns as $column)
                @if($column!='thumbnail')
                <td>{{$data->$column}}</td>
                @else
                <td><img src="{{asset($data->$column)}}" alt="No image" width="50px"></td>
                @endif
                @endforeach
                <td>
                    <a href="{{url('admin/edit/product',$data->slug)}}" style="color:blue"><i class="fas fa-pencil-alt"></i></a>
                    <a href="{{url('admin/delete/product',$data->slug)}}" class="delete" style="color:red"><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    <nav aria-label="..." class="pagintion_nav">
        <ul class="pagination">
            <li class="page-item paginate_reload_prevent">
                @if($datas->currentPage()=='1')
                <span class="page-link">Previous</span>
                @else
                <a class="page-link" data-id="{{$datas->currentPage()-1}}" href="#">Previous</a>
                @endif
            </li>
            @for($i=1;$i<=$datas->lastPage();$i++)
                <li class="page-item paginate_reload_prevent {{ $datas->currentPage()==$i ? 'active' : '' }}" >
                    <a class="page-link" data-id="{{$i}}" href="#">{{$i}}</a>
                </li>
                @endfor
                <!-- <li class="page-item active" aria-current="page">
                <span class="page-link">2</span>
            </li>
            <li class="page-item"><a class="page-link" href="#">3</a></li> -->
                <li class="page-item paginate_reload_prevent">
                    @if($datas->currentPage()==$datas->lastPage())
                    <span class="page-link">Next</span>
                    @else
                    <a class="page-link" data-id="{{$datas->currentPage()+1}}" href="#">Next</a>
                    @endif
                </li>
        </ul>
    </nav>
</div>