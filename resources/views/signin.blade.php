<?php $page = 'signin'; ?>
@extends('layout.mainlayout')
@section('content')
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="container">
                <div class="login-content user-login">
                    <div class="login-logo">
                        <img src="{{ URL::asset('/build/img/logo.png') }}" alt="img">
                        <a href="{{ url('index') }}" class="login-logo logo-white">
                            <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
                        </a>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="login-userset">
                            <div class="login-userheading">
                                <h3>Iniciar</h3>
                                <h4>Accede al sistema usando tu correo y contraseña.</h4>
                            </div>
                            <div class="form-login">
                                <label class="form-label">Correo electrónico</label>
                                <div class="form-addons">
                                    {{-- <input type="text" name="email" class="form-control"  value="{{ old('email') }}" required> --}}
                                    <input type="text" name="email" class="form-control"  value="a@a.com" required>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                    <img src="{{ URL::asset('/build/img/icons/mail.svg') }}" alt="img">
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Contraseña</label>
                                <div class="pass-group">
                                    {{-- <input type="password" name="password" class="pass-input" required> --}}
                                    <input type="password" name="password" class="pass-input" value="123456" required>
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-login authentication-check">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                <input type="checkbox" name="remember">
                                                <span class="checkmarks"></span>Recordarme
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        <a class="forgot-link" href="{{ url('forgot-password') }}">¿Olvidaste la contraseña?</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-login">
                                <button class="btn btn-login" type="submit">Iniciar</button>
                            </div>
                            <div class="signinform">
                                <h4>¿Eres nuevo?<a href="{{ url('register') }}" class="hover-a"> Crea una cuenta</a></h4>
                            </div>
                            {{-- <div class="form-setlogin or-text">
                                        <h4>O</h4>
                                    </div>
                                    <div class="form-sociallink">
                                        <ul class="d-flex">
                                            <li>
                                                <a href="javascript:void(0);" class="facebook-logo">
                                                    <img src="{{ URL::asset('/build/img/icons/facebook-logo.svg') }}"
                                                        alt="Facebook">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <img src="{{ URL::asset('/build/img/icons/google.png') }}" alt="Google">
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);" class="apple-logo">
                                                    <img src="{{ URL::asset('/build/img/icons/apple-logo.svg') }}" alt="Apple">
                                                </a>
                                            </li>
                                        </ul>
                                    </div> --}}
                        </div>
                    </form>
                    
                   

                </div>
                <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                    <p>Copyright &copy; 2025 JAJI</p>
                </div>
            </div>
        </div>
    </div>
@endsection
