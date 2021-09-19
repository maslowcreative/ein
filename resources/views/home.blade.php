@extends('layouts.app')

@section('content')
<main class="main px-xl-5">
  <div class="container-fluid">
    <h1 class="h2 mb-4 fw-bold pb-2">{{ __('Dashboard') }}</h1>
    {{-- Quick Options Section --}}
    <div class="qo-section bg-primary text-white">
      <h4 class="fw-bold">Quick Options</h4>
      <p>Choose one of the quick options for easier navigation</p>

      <div class="grid options-grid">
        <a href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#userModal">
          <ion-icon name="person-add-outline" class="option-item-icon"></ion-icon>
          Add New User
        </a>
        <a href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#adminModal">
          <span class="option-item-icon">
            <span class="admin-icon">
              <ion-icon name="person-add-outline" class=""></ion-icon>
              <ion-icon name="cog-outline" class="icon-cog"></ion-icon>
            </span>
          </span>
          Add New Admin
        </a>
        <a href="#" class="option-item">
          <ion-icon name="push-outline" class="option-item-icon"></ion-icon>
          Bulk Upload
        </a>
        <a href="#" class="option-item">
          <ion-icon name="push-outline" class="flip-v option-item-icon"></ion-icon>
          Bulk Download
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Invoices/Claims</h5>
                <small class="text-primary">9999 Invoices/Claims</small>
              </div>
              <div class="card-right-btns">
                <button class="btn btn-primary">
                  All Claims
                </button>
                <button class="btn btn-light position-relative">
                  Pending Approval
                  <span
                    class="position-absolute top-0 start-100 translate-middle badge badge-alrt border border-light rounded-circle bg-primary"><span
                      class="visually-hidden">unread messages</span></span>
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
                    <th scope="col"></th>
                    <th scope="col" class="not-center">Claim Number</th>
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
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
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
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
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
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
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
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <input class="form-check-input" type="checkbox" value="" aria-label="...">
                    </td>
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
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="document-attach-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4 mt-md-5 card-right-btns justify-content-end">
              <button class="btn btn-light">Download Selected</button>
              <button class="btn btn-primary">Upload Selected</button>
            </div>
            <div class="mt-4 mt-md-5">
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
        <div class="card mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Users</h5>
                <small class="text-primary">9999 Active Users</small>
              </div>
              <div class="card-right-btns">
                <button class="btn btn-primary btn-icon">
                  <ion-icon name="add-outline"></ion-icon> Add New User
                </button>
                <div class="dropdown">
                  <button class="btn btn-light btn-icon" type="button" id="userSearchDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <ion-icon name="search-outline"></ion-icon>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="userSearchDropdown">
                    <div class="py-2 px-3">
                      <div class="">
                        <label class="form-label">Search for a User</label>
                        <input type="text" class="form-control form-control-sm" placeholder="Enter Users Name">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="dropdown">
                  <button class="btn btn-light btn-icon" type="button" id="filterDropdown2" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <ion-icon name="funnel-outline"></ion-icon>
                  </button>
                  <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown2">
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
                    <th scope="col" class="not-center">User</th>
                    <th scope="col">Plan</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="not-center">
                      <div class="d-flex">
                        <div class="me-4">
                          <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                        </div>
                        <div class="fw-bold">
                          Users Name
                          <span class="d-block text-primary fw-normal">Participant</span>
                        </div>
                      </div>
                    </td>
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editPlanModal">Edit
                        Plan</button></td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="create-outline"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="trash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4 mt-md-5">
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
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Sub-Admins</h5>
                <small class="text-primary">99999 Sub-admins</small>
              </div>
              <div class="card-right-btns">
                <button class="btn btn-primary btn-icon">
                  <ion-icon name="add-outline"></ion-icon> Add New Admin
                </button>
                <button class="btn btn-light btn-icon">
                  <ion-icon name="search-outline"></ion-icon>
                </button>
              </div>
            </div>
            <div class="table-x-scroll">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" class="not-center">Sub-Admin</th>
                    <th scope="col">Enable/Disable Admin</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td class="not-center">
                      <div class="d-flex">
                        <div class="me-4">
                          <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                        </div>
                        <div class="fw-bold">
                          Sub-admin Name
                          <span class="d-block text-primary fw-normal">Participant</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-inline-block">
                        <div class="form-check form-switch">
                          <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                          <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 fs-16 mx-1">
                          <ion-icon name="options-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="mt-4 mt-md-5">
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
    </div>
  </div>


  {{-- Modal New User --}}
  <div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="userModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xxl modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div class="modal-header">
          <h4 class="modal-title" id="userModalTitle">Create a new user</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body addUser">
          <div class="row">
            <div class="col-md-5">
              <ul class="stepList">
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">1</div>
                    <div class="step-text">
                      <h6>Choose User Type</h6>Provider, Participant or Representative
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">2</div>
                    <div class="step-text">
                      <h6>Personal Information</h6>Enter your user’s personal information
                    </div>
                  </a>

                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">3</div>
                    <div class="step-text">
                      <h6>Contact Information</h6>Enter User’s Contact information
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">4</div>
                    <div class="step-text">
                      <h6>NDIS Information</h6>Provide information related to NDIS
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">5</div>
                    <div class="step-text">
                      <h6>Login Information</h6>Set-up a password for your new user
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-7">
              {{-- Step 1 --}}
              <div class="step1 mw420 mx-auto">
                <h6 class="mb-5">Choose your User Type</h6>
                <div class="d-grid userType">
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-1" autocomplete="off">
                    <label class="btn btn-light d-block btn-lg" for="btn-check-1">Provider</label>
                  </div>
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-2" autocomplete="off">
                    <label class="btn btn-light d-block btn-lg" for="btn-check-2">Participant</label>
                  </div>
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-3" autocomplete="off">
                    <label class="btn btn-light d-block btn-lg" for="btn-check-3">Representative</label>
                  </div>
                </div>
              </div>
              {{-- Step 2 --}}
              <div class="step2 d-none">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="fullName" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullName" placeholder="The Name of the Provider">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="fullName2" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullName2" placeholder="The Name of the Provider">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="linkAParticipant" class="form-label">Link a Participant</label>
                      <input type="text" class="form-control" id="linkAParticipant" placeholder="Participant’s Name">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="bg-light d-flex align-items-center p-3 participant-card">
                      <div class="me-3"><img src="/images/avatar.png" width="40" alt=""></div>
                      <div class="participant-name">
                        <h6>Users Name</h6>
                        <span class="text-primary">Participant</span>
                      </div>
                      <div class="ms-auto">
                        <button class="btn btn-link p-0 participant-remove">
                          <ion-icon name="remove-circle-outline"></ion-icon>
                        </button>
                      </div>
                    </div>
                    <div class="bg-light d-flex align-items-center p-3 participant-card">
                      <div class="me-3"><img src="/images/avatar.png" width="40" alt=""></div>
                      <div class="participant-name">
                        <h6>Users Name</h6>
                        <span class="text-primary">Participant</span>
                      </div>
                      <div class="ms-auto">
                        <button class="btn btn-link p-0 participant-remove">
                          <ion-icon name="remove-circle-outline"></ion-icon>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- Step 3 --}}
              <div class="step3 mw290 mx-auto d-none">
                <div class="mb-3">
                  <label for="homeAddress" class="form-label fw-bold">Home Address</label>
                  <textarea name="" id="" cols="30" rows="2" class="form-control" id="homeAddress"
                    placeholder="Home Address 13, 10000 State, Country."></textarea>
                </div>
                <div class="mb-3">
                  <label for="emailAddress" class="form-label fw-bold">E-mail Address</label>
                  <input type="text" class="form-control" id="emailAddress" placeholder="providersemail@gmail.com">
                </div>
                <div class="mb-3">
                  <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                  <input type="tel" class="form-control" id="phoneNumber" placeholder="0000000000">
                </div>
              </div>
              {{-- Step 4 --}}
              <div class="step4 mw290 mx-auto d-none">
                <div>
                  <div class="mb-3">
                    <label for="abnNumber" class="form-label fw-bold">ABN</label>
                    <input type="tel" class="form-control" id="abnNumber" placeholder="00000000000000000000">
                  </div>
                  <div class="mb-3">
                    <label for="specificItemNumbers" class="form-label fw-bold">Specific Item Numbers</label>
                    <textarea name="" id="" cols="30" rows="2" class="form-control" id="specificItemNumbers"
                      placeholder="000000000000, 000000 0000000000, 0000000"></textarea>
                  </div>
                </div>
              </div>
              {{-- Step 5 --}}
              <div class="step5 mw420 mx-auto d-none">
                <div class="form-check emailRequest">
                  <input class="form-check-input" type="checkbox" value="" id="emailRequest">
                  <label class="form-check-label" for="emailRequest">
                    Send email request for the new user to create password
                  </label>
                </div>
              </div>
              <div class="mw290 mx-auto px-4">
                <button class="btn btn-primary btn-lg w-100 py-3">Next</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal New Aadmin --}}

  <div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="adminModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div class="modal-header">
          <h4 class="modal-title" id="adminModalTitle">Create a new Sub-admin</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullName" placeholder="Admin Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="emailAddress" class="form-label">E-mail Address</label>
                <input type="email" class="form-control" id="emailAddress" placeholder="adminsemail@ein.net.au">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enterPassword" class="form-label">Enter Password</label>
                <input type="password" class="form-control" id="enterPassword" placeholder="*********************">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enterPassword2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="enterPassword2" placeholder="*********************">
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="fw-bold">Edit Provider Profiles</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="editOption1" checked>
                  <label class="form-check-label" for="editOption1"></label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="fw-bold">Edit Participants Profiles</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="editOption2" checked>
                  <label class="form-check-label" for="editOption2"></label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="fw-bold">Edit Representatives Profiles</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="editOption3" checked>
                  <label class="form-check-label" for="editOption3"></label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="fw-bold">Approving Claims</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="editOption4" checked>
                  <label class="form-check-label" for="editOption4"></label>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="d-flex justify-content-between align-items-center mb-4">
                <label class="fw-bold">Export / Import Documents</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="editOption5" checked>
                  <label class="form-check-label" for="editOption5"></label>
                </div>
              </div>
            </div>
            <div class="mw290 mx-auto px-4 mt-3">
              <button class="btn btn-primary btn-lg w-100 py-3">Create Sub-admin</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal New Aadmin --}}

  <div class="modal fade" id="editPlanModal" tabindex="-1" data-bs-backdrop="static"
    aria-labelledby="editPlanModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div class="modal-header">
          <h4 class="modal-title" id="editPlanModalTitle">Create a new Sub-admin</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <label for="NDISPlan" class="form-label fw-bold">NDIS Plan</label>
                <input type="text" class="form-control" id="NDISPlan" placeholder="NDIS Plan Name">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enablePlan" class="form-label fw-bold">Edit Plan</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="enablePlan">
                  <label class="form-check-label" for="enablePlan"></label>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enterPassword" class="form-label fw-bold">Start Date</label>
                <input type="date" class="form-control" id="enterPassword" placeholder="01/01/2021">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enterPassword2" class="form-label fw-bold">End Date</label>
                <input type="date" class="form-control" id="enterPassword2" placeholder="01/01/2021">
              </div>
            </div>
            <div class="col-md-12">
              <div class="text-center text-primary">
                <ion-icon name="checkmark"></ion-icon> User Plan Updated!
              </div>
            </div>
            <div class="mw290 mx-auto px-4 mt-3">
              <button class="btn btn-primary btn-lg w-100 py-3">Update Plan</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
@endsection