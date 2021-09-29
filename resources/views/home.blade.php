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
<script>
  import AdminList from "../js/components/dashboard/AdminList";
  import DashboardHeader from "../js/components/dashboard/DashboardHeader";
  import InvoiceClaimsList from "../js/components/dashboard/InvoiceClaimsList";
  export default {
      components: {InvoiceClaimsList, DashboardHeader, AdminList}
  }
</script>