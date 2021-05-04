@extends('layouts.app')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="mt-2">
    <div class="edit_model_heading">
        <h5 class="text-center">{{ucfirst($model)}} Create</h5>
    </div>
    <form action="{{url('admin/store/'.$model)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @forelse($columns as $column)
            
            <div class="form-group{{ $errors->has($column) ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="{{$column}}" class="control-label">{{ucfirst(str_replace('_',' ',$column))}}</label>
                <input type="text" class="form-control" name="{{$column}}" id="{{$column}}" placeholder="{{ucfirst(str_replace('_',' ',$column))}}" value="{{Request::old($column)}}">
                @if ($errors->has($column))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first($column) }}</strong>
                </span>
                @endif
            </div>
            @empty
            @endforelse

            @if($model=='product')
            @include('layouts.data.thumbnail')
            @include('layouts.product.partial')
            @endif
            @if($model=='user')
            @include('layouts.data.thumbnail')
            @endif

            @if($model=='category')
            @include('layouts.category.partial')
            @endif

            @if($model=='region')
            @include('layouts.region.partial')
            @endif
            @if($model=='address')
            @include('layouts.address.partial')
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 mt-2" style="order: 20;">
                <input type="submit" class="form-control btn btn-success" value="Submit">
            </div>
        </div>
    </form>
</div>
@endsection
@section('js')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        tinymce.init({
            selector: 'textarea'
        });
        $("#parent_id").select2({
            placeholder:"Select One",
            allowClear:true
        })
        $("#division_id").select2({
            placeholder:"Select One",
            allowClear:true
        })
        $("#district_id").select2({
            placeholder:"Select a Country",
            allowClear:true
        })
        $("#checking_place_id").select2({
            placeholder:"Select a District",
            allowClear:true
        })
    </script>
@endsection