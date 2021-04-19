<!-- @extends('layouts.app')
@section('content')

<div class="mt-2">
    <form action="{{url('admin/update/user/'.$user->slug)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="name" class="control-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Product Name" value="{{$user->name}}">
                @if ($errors->has('name'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} col-lg-6 col-md-6 col-sm-12">
                <label for="email" class="control-label">Email</email></label>
                <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{$user->email}}">
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong style="color:red">{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
                <input type="submit" class="form-control btn btn-success" value="Update">
            </div>

        </div>
    </form>

</div>
@endsection -->