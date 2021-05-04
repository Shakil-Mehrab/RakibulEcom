<div class="form-group {{ $errors->has('parent_id') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12" style="order:3">
    <label for="parent_id" class="control-label">Parent</label>
    <select class="form-control" name="parent_id" id="parent_id">
        <option></option>
        <option value="">None</option>
        @forelse($categories as $category)
        <option value="{{$category->id}}" {{$data?$data->parent_id==$category->id?'selected':'':''}}>{{$category->name}}</option>
        @empty
        <option value="">No Category</option>
        @endforelse
    </select>
</div>