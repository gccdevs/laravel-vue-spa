@extends('layouts.backend')

@section('content')
    <section class="hero is-fullheight" style="background-color: #717171;">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-white">Reset Password</h3>
                    <div class="box" style="border: 1px solid #4b5fe2;">
                        <figure class="avatar">
                            <img src="https://placehold.it/128x128" style="border-radius: 50%;">
                        </figure>
                        <form class="form-horizontal" method="POST" action="{{  route('password.email') }}">
                            {{ csrf_field() }}
                            <div class="field">
                                <div class="control">
                                    <div class="field{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input name="email" class="input no-shadow" type="email" value="{{ old('email') }}" placeholder="Your Email" autofocus="">
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <p class="text-danger title is-6" style="color: red;">{{ $errors->first('email') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if (session('status'))
                                <div class="is-small is-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <button type="submit" class="button is-fullwidth is-outlined is-rounded" style="color: white;background-color: #4b5fe2;">
                                Send Password Reset Link
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
