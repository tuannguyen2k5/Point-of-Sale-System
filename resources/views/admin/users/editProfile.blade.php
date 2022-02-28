@extends('admin.layouts.app')
@section('title',' Profile')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$user_name->username}} Profile</h1>
            </div>
            @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div>{{session('success')}}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active"> {{$user_name->username}} Profile</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{route('admin.users.profile.update',$user_name->id)}}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="wrapper bg-white mt-sm-5 p-4">
                        <div class="d-flex align-items-start py-3 border-bottom"> <img id="blah" width="120px"
                                src="{{asset($user_name->photo)}}"
                                onerror="this.onerror=null; this.src='https://via.placeholder.com/150'"
                                alt="{{$user_name->username}}}}" />
                            <div class="pl-sm-4 pl-2" id="img-section"> <b>Profile Photo</b>
                                <p>Accepted file type .png. Less than 1MB</p>
                                <div class="row mb-3"><label for="photo" class="upload">
                                        Upload
                                    </label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('photo') is-invalid @enderror" id="photo"
                                            name="photo" type="file" onchange="readURL(this);" />
                                        @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="py-2">
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="name">Name</label>
                                    <input type="text" class="bg-light form-control" id="name" name="name"
                                        value="{{old('name', $user_name->name)}}">
                                </div>
                                <div class="col-md-6 pt-md-0 pt-3">
                                    <label for="username">User Name</label>
                                    <input type="text" class="bg-light form-control" id="username" name="username"
                                        value="{{old('username', $user_name->username)}}">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="email">Email Address</label>
                                    <input type="email"
                                        class="bg-light form-control @error('email') is-invalid @enderror" id="email"
                                        name="email" value="{{old('email', $user_name->email)}}">
                                </div>
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                                <div class="col-md-6 pt-md-0 pt-3">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="bg-light form-control" id="phone" name="phone"
                                        value="{{old('phone', $user_name->phone)}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                </div>
                            </div>
                            <div class="row py-2">
                                <div class="col-md-6">
                                    <label for="birthday">Birthday</label>
                                    <input class="date form-control" type="date">
                                </div>
                            </div>
                            <div class="py-3 pb-4 border-bottom">
                                <button class="btn btn-primary mr-3" name="save">Save Changes</button>
                                <a class="btn border button" href="{{route('admin.users.profile')}}"
                                    name="cancel">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.date').datepicker({  
       format: 'mm-dd-yyyy'
     });  
</script>
<script type="text/javascript">
    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        } 
</script>
@stop
<style>
    input[type="file"] {
        display: none;
    }

    .upload {
        border: 1px solid #ccc;
        display: inline-block;
        padding: 6px 12px;
        cursor: pointer;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: aliceblue
    }

    h4 {
        letter-spacing: -1px;
        font-weight: 400
    }

    .img {
        width: 70px;
        height: 70px;
        border-radius: 6px;
        object-fit: cover
    }

    #img-section p,
    #deactivate p {
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
        text-align: justify
    }

    #img-section b,
    #img-section button,
    #deactivate b {
        font-size: 14px
    }

    label {
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 500;
        color: #777;
        padding-left: 3px
    }

    .form-control {
        border-radius: 10px
    }

    input[placeholder] {
        font-weight: 500
    }

    .form-control:focus {
        box-shadow: none;
        border: 1.5px solid #0779e4
    }

    select {
        display: block;
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 10px;
        height: 40px;
        padding: 5px 10px
    }

    select:focus {
        outline: none
    }

    .button {
        background-color: #fff;
        color: #0779e4
    }

    .button:hover {
        background-color: #0779e4;
        color: #fff
    }

    .btn-primary {
        background-color: #0779e4
    }

    .danger {
        background-color: #fff;
        color: #e20404;
        border: 1px solid #ddd
    }

    .danger:hover {
        background-color: #e20404;
        color: #fff
    }

    @media(max-width:576px) {
        .wrapper {
            padding: 25px 20px
        }

        #deactivate {
            line-height: 18px
        }
    }
</style>
@stop