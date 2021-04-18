@extends('layouts.app')
@section('content')
<div class="mt-2">
    <div class="search_head mb-2">
    <h6 class="total_data_rows" >{{ucfirst($model)}} Table ({{$datas->total()}})</h6>
        <div class="search" id="dataTable">


            <span>Per Page</span>
            <select name="per-page" data-model="{{$model}}" id="per_page">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input type="search" name="search" data-model="{{$model}}" id="search" placeholder="Search Here.....">
        </div>
    </div>
    @include('layouts.data.table')
</div>
@endsection