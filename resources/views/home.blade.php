@extends('layouts.app')

@section('content')
<main class="main px-xl-5">
  <div class="container-fluid">
    <dashboard-header></dashboard-header>
    <div class="row">
      <div class="col-xl-6">
        <invoice-claims-list></invoice-claims-list>
      </div>
      <div class="col-xl-6">
        <user-list></user-list>
        <admin-list></admin-list>
      </div>
    </div>
  </div>
</main>
@endsection
