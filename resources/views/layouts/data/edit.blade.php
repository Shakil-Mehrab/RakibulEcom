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
            <div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order:3">
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
            <div class="form-group{{ $errors->has('short_description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 8;">
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
            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 9;">
                <label for="description" class="control-label">Description</label>
                <textarea type="text" class="form-control" name="description" id="description" placeholder="Description" cols="30" rows="6">{{$data->description}}</textarea>
                @if ($errors->has('description'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
            @endif
            @if($column=='thumbnail')
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 12;">
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
            @if($model=='product')
            <div class="form-group {{ $errors->has('size_id') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order: 3;">
                <label for="size_id" class="control-label">Select Size</label>
                <div>
                    @forelse($sizes as $index=>$size)
                    <input type="checkbox" class="form-checkbox" name="size_id[]" id="size_id" value="{{$size->id}}" {{$data->sizes->contains($size->id)?'checked':''}}>
                    <span>{{$size->size}}</span>
                    @empty
                    @endforelse
                </div>
                @if ($errors->has('size_id'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('size_id') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('category_id') ? ' has-error' : '' }} col-lg-12 col-md-12 col-sm-12" style="order: 4;">
                <label for="category_id" class="control-label">Select Category</label>
                <div>
                    @forelse($categories as $category)
                    <input type="checkbox" class="form-checkbox" name="category_id[]" id="category_id" value="{{$category->id}}" {{$data->categories->contains($category->id)?'checked':''}}>
                    <span>{{$category->name}}</span>
                    @empty
                    @endforelse
                </div>

                @if ($errors->has('category_id'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('category_id') }}</strong>
                </span>
                @endif
            </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 mt-2" style="order: 20;">
                <input type="submit" class="form-control btn btn-success" value="Update">
            </div>
        </div>
    </form>
</div>
@endsection