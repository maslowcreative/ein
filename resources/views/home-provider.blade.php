@extends('layouts.app')

@section('content')
<main class="main">
  <div class="container-xxl">
    <div class="row">
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Invoices/Claims</h5>
                <small class="text-primary">9999 Submitted Invoices/Claims </small>
              </div>
              <div class="card-right-btns">
                <button class="btn btn-primary">
                  + New Invoice
                </button>
                <div class="dropdown">
                  <button class="btn btn-light btn-icon" type="button" id="filterDropdown1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <ion-icon name="funnel-outline"></ion-icon>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown1">
                    <div class="py-2 px-3">
                      <div class="mb-3">
                        <label class="form-label">Claim Status</label>
                        <select class="form-select form-select-sm">
                          <option selected>All</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="">
                        <label class="form-label">Claim Status</label>
                        <select class="form-select form-select-sm">
                          <option selected>All</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-x-scroll">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="not-center">Claim Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">Details</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="not-center">
                      <div class="fw-bold">
                        Claim #12131
                        <span class="d-block text-primary fw-normal">Provider’s Name</span>
                      </div>
                    </td>
                    <td>
                      Claim Status
                    </td>
                    <td><button class="btn btn-light btn-sm">View more</button></td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="mt-3 mt-md-4">
              <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">...</a></li>
                  <li class="page-item"><a class="page-link" href="#">100</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Linked Participants</h5>
                <small class="text-primary">9999 Participants</small>
              </div>
              <div class="card-right-btns">
                <div class="dropdown">
                  <button class="btn btn-light btn-icon" type="button" id="userSearchDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <ion-icon name="search-outline"></ion-icon>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="userSearchDropdown">
                    <div class="py-2 px-3">
                      <div class="">
                        <label class="form-label">Search for a User</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Users Name" />
                      </div>
                    </div>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="btn btn-light btn-icon" type="button" id="filterDropdown1" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <ion-icon name="funnel-outline"></ion-icon>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown1">
                    <div class="py-2 px-3">
                      <div class="mb-3">
                        <label class="form-label">Claim Status</label>
                        <select class="form-select form-select-sm">
                          <option selected>All</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                      <div class="">
                        <label class="form-label">Claim Status</label>
                        <select class="form-select form-select-sm">
                          <option selected>All</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="table-x-scroll">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="not-center">Participants Name</th>
                    <th scope="col"></th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="not-center">
                      <div class="d-flex">
                        <div class="me-4">
                          <img src="/images/avatar.png" width="50" height="50" alt="" />
                        </div>
                        <div class="fw-bold">
                          Users Name
                          <span class="d-block text-primary fw-normal">Participant</span>
                        </div>
                      </div>
                      <div>
                        <div class="d-flex">
                          <div class="me-4">
                            <img src="/images/avatar.png" width="50" height="50" alt="" />
                          </div>
                          <div class="fw-bold">
                            Users Name
                            <span class="d-block text-primary fw-normal">Participant</span>
                          </div>
                        </div>
                      </div>
                    </td>
                    <td>
                      <button class="btn btn-primary btn-sm">New Invoice</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 fs-16 mx-1 hover-danger">
                          <ion-icon name="remove-circle-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection