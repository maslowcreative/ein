@extends('layouts.app')

@section('content')
<main class="main">
  <div class="container-xxl">
    <div class="row">
      <div class="col-xl-6">
       <representative-invoice-list></representative-invoice-list>
      </div>

      <div class="col-xl-6">
        <representative-participant-list></representative-participant-list>
        <representative-provider-list></representative-provider-list>
      </div>
    </div>
  </div>
</main>
@endsection
