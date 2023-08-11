@extends('layouts.app')

@section('content')
<main class="main">
  <div class="container-xxl">
    <div class="row">
      <div class="col-xl-6">
        <provider-invoice-list></provider-invoice-list>

      </div>

      <div class="col-xl-6">
        <participant-list></participant-list>
      </div>
    </div>
  </div>
</main>
@endsection

