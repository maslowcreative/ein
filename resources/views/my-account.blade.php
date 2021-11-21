@extends('layouts.app')

@section('content')
<main class="main my-account-page">
	<div class="container-xxl">
		<my-account :user="{{ json_encode( \Illuminate\Support\Facades\Auth::user()) }}"></my-account>
	</div>
</main>
@endsection
