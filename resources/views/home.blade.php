@extends('layouts.app')

@section('content')
<main class="main px-5">
  <div class="container-fluid">
    <h1>{{ __('Dashboard') }}</h1>
    {{-- Quick Options Section --}}
    <div class="qo-section bg-primary p-5 text-white">
      <h4 class="fw-blod">Quick Options</h4>
      <p>Choose one of the quick options for easier navigation</p>

      <div class="grid options-grid">
        <div class="bg-white option-item">
          <a href="#">
            <ion-icon name="person-add-outline"></ion-icon> Add New User
          </a>
        </div>
        <div class="bg-white option-item">
          <a href="#">
            <span>
              <ion-icon name="person-add-outline"></ion-icon>
              <ion-icon name="cog-outline"></ion-icon>
            </span> Add New Admin
          </a>
        </div>
        <div class="bg-white option-item"><a href="#">
            <ion-icon name="push-outline"></ion-icon> Bulk Upload
          </a></div>
        <div class="bg-white option-item"><a href="#">
            <ion-icon name="push-outline" class="flip-v"></ion-icon>Bulk Download
          </a></div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Invoices/Claims</h5>
                <small class="text-primary">9999 Invoices/Claims</small>
              </div>
              <div>
                <button class="btn btn-primary">All Claims</button>
                <button class="btn btn-light">Pending Approval</button>
                <button class="btn btn-light btn-icon">
                  <ion-icon name="funnel-outline"></ion-icon>
                </button>
              </div>
            </div>
            <div>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Claim Number</th>
                    <th scope="col">Status</th>
                    <th scope="col">Details</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
                    <td>
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
                      <div class="d-flex flex-nowrap justify-content-around">
                        <button class="btn btn-link p-0">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
                    <td>
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
                      <div class="d-flex flex-nowrap justify-content-around">
                        <button class="btn btn-link p-0">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
                    <td>
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
                      <div class="d-flex flex-nowrap justify-content-around">
                        <button class="btn btn-link p-0">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
                    <td>
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
                      <div class="d-flex flex-nowrap justify-content-around">
                        <button class="btn btn-link p-0">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
                    <td>
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
                      <div class="d-flex flex-nowrap justify-content-around">
                        <button class="btn btn-link p-0">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="text-end">
                <button class="btn btn-primary">Download Selected</button>
                <button class="btn btn-light">Upload Selected</button>
              </div>
              <div class="mt-4">
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Users</h5>
                <small class="text-primary">9999 Active Users</small>
              </div>
              <div>
                <button class="btn btn-primary btn-icon">
                  <ion-icon name="add-outline"></ion-icon> Add New User
                </button>
                <button class="btn btn-light btn-icon">
                  <ion-icon name="funnel-outline"></ion-icon>
                </button>
                <button class="btn btn-light btn-icon">
                  <ion-icon name="search-outline"></ion-icon>
                </button>
              </div>
            </div>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col">Claim Number</th>
                  <th scope="col">Status</th>
                  <th scope="col">Details</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                    </div>
                  </td>
                  <td>
                    <div>
                      Claim #12131
                      <span>Provider’s Name</span>
                    </div>
                  </td>
                  <td>
                    Claim Status
                  </td>
                  <td><button class="btn btn-light">View more</button></td>
                  <td>
                    <div class="d-flex flex-nowrap justify-content-around">
                      <button class="btn btn-link p-0">
                        <ion-icon name="create-outline"></ion-icon>
                      </button>
                      <button class="btn btn-link p-0">
                        <ion-icon name="trash-outline"></ion-icon>
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Sub-Admins</h5>
                <small class="text-primary">99999 Sub-admins</small>
              </div>
              <div>
                <button class="btn btn-primary btn-icon">
                  <ion-icon name="add-outline"></ion-icon> Sub-Admins
                </button>
                <button class="btn btn-light btn-icon">
                  <ion-icon name="search-outline"></ion-icon>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>
@endsection