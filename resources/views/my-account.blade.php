@extends('layouts.app')

@section('content')
<main class="main my-account-page">
	<div class="container-xxl">
        <my-account :user="{{ json_encode( $user) }}" :role="{{json_encode($role)}}"></my-account>
	</div>
</main>
@endsection
