@extends('layouts.app')
@section('content')
<div class="mt-2">
    <div class="search_head mb-2">
        <div class="search" id="dataTable">
            <span>Per Page</span>
            <select name="per-page" id="per_page">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
            <input type="search" name="search" id="search" placeholder="Search Here.....">
        </div>
    </div>
    @include('layouts.table')
</div>
@endsection