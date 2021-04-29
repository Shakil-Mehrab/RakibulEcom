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
            @if($column!='thumbnail' && $column!='short_description' && $column!='description')
            <div class="form-group{{ $errors->has($column) ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="{{$column}}" class="control-label">{{ucfirst($column)}}</label>
                <input type="text" class="form-control" name="{{$column}}" id="{{$column}}" placeholder="{{$column}}" value="{{Request::old($column)}}">
                @if ($errors->has($column))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first($column) }}</strong>
                </span>
                @endif
            </div>
            @endif
            
            @if($column=='short_description')
            <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 8;">
                <label for="short_description" class="control-label">Short Description</label>
                <textarea type="text" class="form-control" name="short_description" id="short_description" placeholder="Short Description" cols="30" rows="6">{{Request::old('short_description')}}</textarea>
                @if ($errors->has('short_description'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('short_description') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='description')
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 9;">
                <label for="description" class="control-label">Description</label>
                <textarea type="text" class="form-control" name="description" id="description" placeholder="Description" cols="30" rows="6">{{Request::old('description')}}</textarea>
                @if ($errors->has('description'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='thumbnail')
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order: 12;">
                <label for="image" class="control-label">Thumbnail</label>
                <input type="file" class="form-control" name="image" id="image">
                @if ($errors->has('image'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('image') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @empty
            @endforelse

            @if($model=='product')
            @include('layouts.product.partial_edit')
            @endif

            @if($model=='category')
            @include('layouts.category.partial_edit')
            @endif

            @if($model=='region')
            @include('layouts.region.partial_edit')
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
    <script>
        tinymce.init({
            selector: 'textarea'
        });

    </script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
        $("#parent_id").select2({
            
        })
    </script>
@endsection