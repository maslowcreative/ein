@extends('layouts.app')

@section('content')
    <password-reset token-prop="{{ $token }}"  email-prop="{{$email}}"></password-reset>
@endsection
