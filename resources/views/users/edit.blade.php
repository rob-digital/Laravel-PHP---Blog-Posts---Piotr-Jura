@extends('layout')

@section('content')
    <form method="post"
        enctype="multipart/form-data"
        action="{{ route('users.update', ['user' => $user->id]) }}"
        class="form-horizontal">

        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-4">
                <img src="{{ $user->image ? $user->image->url() : '' }}"
                    class="img-tumbnail avatar">

                <div class="card mt-4">
                    <div class="card-body">
                        <h6>Upload a different photo</h6>
                        <input type="file" name="avatar" value="Go" class="form-control-file"/>
                    </div>
                </div>

            </div>

            <div class="col-8">

                <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" value="" class="form-control" name="name">
                </div>

                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-primary">
                </div>

                <x-errors></x-errors>
            </div>
        </div>
    </form>
@endsection
