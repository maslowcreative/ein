@extends('layouts.app')

@section('content')
<main class="main">
  <div class="container-xxl">
    <dashboard-header :policy="{{json_encode(getPolicy())}}"></dashboard-header>
    <div class="row">
      <div class="col-xl-6">
        <invoice-claims-list :policy="{{json_encode(getPolicy())}}"></invoice-claims-list>
      </div>
      <div class="col-xl-6">
        <user-list :policy="{{json_encode(getPolicy())}}"></user-list>
        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('admin'))
            <admin-list></admin-list>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection
