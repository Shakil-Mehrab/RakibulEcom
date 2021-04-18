@extends('layouts.app')
@section('content')
<div class="mt-2">
    <div class="edit_model_heading">
        <h5 class="text-center">{{ucfirst($model)}} Edit</h5>
    </div>
    <form action="{{url('admin/update/'.$model.'/'.$data->slug)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            @forelse($columns as $column)
            @if($column!='thumbnail' && $column!='short_description' && $column!='description' && $column!='parent_id')
            <div class="form-group{{ $errors->has($column) ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="{{$column}}" class="control-label">{{ucfirst($column)}}</label>
                <input type="text" class="form-control" name="{{$column}}" id="{{$column}}" placeholder="{{$column}}" value="{{$data->$column}}">
                @if ($errors->has($column))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first($column) }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='parent_id')
            <div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="parent_id" class="control-label">Parent</label>
                <select class="form-control" name="parent_id" id="parent_id">
                    <option value="" >Select One</option>
                    <option value="">None</option>
                    @forelse($categories as $category)
                    <option value="{{$category->id}}" {{$data->parent_id==$category->id?'selected':''}} >{{$category->name}}</option>
                    @empty
                    <option value="">No Category</option>
                    @endforelse
                </select>
            </div>
            @endif
            @if($column=='short_description')
            <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12">
                <label for="short_description" class="control-label">Short Description</label>
                <textarea type="text" class="form-control" name="short_description" id="short_description" placeholder="Short Description" cols="30" rows="6">{{$data->short_description}}</textarea>
                @if ($errors->has('short_description'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('short_description') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='description')
            <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12">
                <label for="short_description" class="control-label">Short Description</label>
                <textarea type="text" class="form-control" name="short_description" id="short_description" placeholder="Short Description" cols="30" rows="6">{{$data->short_description}}</textarea>
                @if ($errors->has('short_description'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('short_description') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='thumbnail')
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 6;">
                <label for="image" class="control-label">Choose Image</label>
                <input type="file" class="form-control" name="image" id="image">
                @if ($errors->has('image'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('image') }}</strong>
                </span>
                @endif
                <img src="{{asset($data->thumbnail)}}" alt="{{$data->name}}" width="50px">
            </div>
            @endif
            @empty
            @endforelse
            <div class="col-lg-12 col-md-12 col-sm-12 mt-2" style="order: 10;">
                <input type="submit" class="form-control btn btn-success" value="Update">
            </div>
        </div>
    </form>
</div>
@endsection