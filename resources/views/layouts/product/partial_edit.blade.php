<div class="form-group {{ $errors->has('images') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order: 12;">
    <label for="images" class="control-label">Related Images</label>
    <input type="file" class="form-control" name="images[]" id="images" multiple>
    @if ($errors->has('images'))
    <span class="help-block">
        <strong style="color:red">{{ $errors->first('images') }}</strong>
    </span>
    @endif
</div>
<div class="form-group {{ $errors->has('size_id') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order: 3;">
    <label for="size_id" class="control-label">Select Size</label>
    <div>
        @forelse($sizes as $index=>$size)
        <input type="checkbox" class="form-checkbox" name="size_id[]" id="size_id" value="{{$size->id}}" {{$data?$data->sizes->contains($size->id)?'checked':'':''}}>
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
        <input type="checkbox" class="form-checkbox" name="category_id[]" id="category_id" value="{{$category->id}}" {{$data?$data->categories->contains($category->id)?'checked':'':''}}>
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