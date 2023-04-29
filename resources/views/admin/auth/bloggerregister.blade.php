@extends('layouts.loginmaster')
@section('title','Register')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v1 px-2">
                <div class="auth-inner py-2">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="javascript:void(0);" class="brand-logo">
                                <img width="250" src="{{asset(config('const.APP_LOGO'))}}" alt="">
                            </a>
                            <h4 class="card-title mb-1">Welcome to {{config('const.APP_NAME')}}! 👋</h4>
                            {{-- <p class="card-text mb-2">Please sign-in to your account</p> --}}

                            <form class="auth-login-form mt-2" id="register_form" name="register_form" action="{{route('blogger.register.post')}}" method="POST">
                                @csrf
                                @include('admin.errors.error')
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-describedby="name" tabindex="1" value="{{old('name')}}" autofocus />
                                </div>
                                
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" aria-describedby="email" tabindex="1" value="{{old('email')}}" autofocus />
                                </div>

                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password" aria-describedby="password" tabindex="1" value="{{old('password')}}" autofocus />
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                    <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter Password Confirmation" aria-describedby="password_confirmation" tabindex="1" value="{{old('password_confirmation')}}" autofocus />
                                </div>

                                <button type="submit" class="btn btn-primary btn-block submitbutton" tabindex="4">
                                    <span class="align-middle">Register</span>
                                    <span class="spinner-border spinner-border-sm ml-1 display-none loader-btn" role="status" aria-hidden="true"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('script')
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.26/moment-timezone-with-data-10-year-range.js"></script>

<!-- BEGIN: Page JS-->

<!-- END: Page JS-->
<script>
    var tz = moment.tz.guess();
    document.cookie = "headvalue=" + tz;
    $(document).ready(function() {
        $('#timezone').val(tz);
        $("#register_form").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 50
                },

                email: {
                    required: true,
                    email: true,
                    maxlength: 100
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            submitHandler: function(form) {
                $('.loader-btn').removeClass("display-none");
                $(".submitbutton").attr("type", "button");
                $('.submitbutton').prop('disabled', true);
                form.submit();
            }
        });
    });
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
@endsection