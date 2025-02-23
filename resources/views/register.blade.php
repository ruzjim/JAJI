<?php $page = 'register'; ?>
@extends('layout.mainlayout')
@section('content')
{{-- @vite(['resources/js/test.js']) --}}
    <div class="account-content">
        <div class="login-wrapper login-new">
            <div class="login-content user-login">
                <div class="login-logo">
                    <img src="{{ URL::asset('/build/img/logo.png') }}" alt="img">
                    <a href="{{ url('index') }}" class="login-logo logo-white">
                        <img src="{{ URL::asset('/build/img/logo-white.png') }}" alt="">
                    </a>
                </div>
                {{-- <form action="signin"> --}}
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="login-userset">
                        <div class="login-userheading">
                            <h3>Registrarse</h3>
                            <h4>Crear nueva Cuenta</h4>
                        </div>
                        <div class="form-login">
                            <label>Nombre</label>
                            <div class="form-addons">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                                <img src="{{ URL::asset('/build/img/icons/user-icon.svg') }}" alt="img">
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Cédula</label>
                            <div class="form-addons">
                                <input type="text" class="form-control" name="cedula" value="{{ old('cedula') }}">
                                @if ($errors->has('cedula'))
                                    <span class="text-danger">{{ $errors->first('cedula') }}</span>
                                @endif
                                <img src="{{ URL::asset('/build/img/icons/user-icon.svg') }}" alt="img">
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Telefono</label>
                            <div class="form-addons">
                                <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}">
                                @if ($errors->has('telefono'))
                                    <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                @endif
                                <img src="{{ URL::asset('/build/img/icons/user-icon.svg') }}" alt="img">
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Correo</label>
                            <div class="form-addons">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                                <img src="{{ URL::asset('/build/img/icons/mail.svg') }}" alt="img">
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Contraseña</label>
                            <div class="pass-group">
                                <input type="password" class="pass-input" name="password" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login">
                            <label>Confirme contraseña</label>
                            <div class="pass-group">
                                <input type="password" class="pass-inputs" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="form-login authentication-check">
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="custom-control custom-checkbox justify-content-start">
                                        <div class="custom-control custom-checkbox">
                                            <label class="checkboxs ps-4 mb-0 pb-0 line-height-1">
                                                <input type="checkbox" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                                
                                                <span class="checkmarks"></span>Estoy de acuerdo con <a href="#"
                                                class="hover-a">Terminos & Politicas</a>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('terms'))
                                        <span class="text-danger">{{ $errors->first('terms') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-login">Registrarme</button>
                        </div>
                        <div class="signinform">
                            <h4>Ya tienes cuenta ? <a href="{{ url('signin') }}" class="hover-a">Iniciar Sesión</a></h4>
                        </div>
                        {{-- @dump($errors) --}}
                       
                    </div>
                </form>
            </div>
            <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                <p>Copyright &copy; 2025 JAJI</p>
            </div>
        </div>
    </div>
@endsection
