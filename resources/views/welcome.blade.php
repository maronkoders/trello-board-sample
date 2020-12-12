@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('login') }}">
                        @csrf
<div class="box">
<h1>Trello | Login </h1>

<input type="email" name="email" placeholder="email" onFocus="field_focus(this, 'email');" onblur="field_blur(this, 'email');" class="email" />
@error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
  
<input type="password" name="password" placeholder="**************" onFocus="field_focus(this, 'email');" onblur="field_blur(this, 'email');" class="email" />
@error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
<a href="javascript:void(0);">
    

<div >

<button type="submit" class="btn">
                                    {{ __('Login') }}
                                </button>
</div></a>
</div> 
</form>
@endsection
