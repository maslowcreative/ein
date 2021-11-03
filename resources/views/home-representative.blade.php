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
                  All Claims
                </button>
                <button class="btn btn-light">
                  Pending Approval
                </button>

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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button></td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
                          <ion-icon name="cash-outline"></ion-icon>
                        </button>
                      </div>
                    </td>
                  </tr>
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
                    <td><button class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#claimDetailPopup">View more</button>
                    </td>
                    <td>
                      <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                        <button class="btn btn-link p-0 mx-1">
                          <ion-icon name="push-outline" class="flip-v"></ion-icon>
                        </button>
                        <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                          data-bs-target="#claimPopup">
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

            {{-- Claim Popup --}}
            <div class="modal" id="claimPopup" tabindex="-1" aria-labelledby="claimPopupTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content addUserPopup">
                  <div class="modal-header">
                    <h4 class="modal-title" id="claimPopupTitle">Claim #1231231</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body addUser">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label">Amount Invoiced</label>
                          <input type="text" class="form-control" placeholder="" value="$500">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="text-primary form-label">Amount Paid</label>
                          <input type="text" class="form-control text-primary" placeholder="" value="$500">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Popup End --}}

            {{-- New Invoice Popup --}}
            <div class="modal" id="invoicePopup" tabindex="-1" aria-labelledby="invoicePopupTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content invoicePopup">
                  <div class="modal-header">
                    <h4 class="modal-title" id="invoicePopupTitle">Submit New Invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body invoicePopupBody">
                    <div class="v-steps d-flex justify-content-between border-bottom">
                      <div class="step-wrap">
                        <a class="step" href="javascript:void(0)">
                          <div class="step-number">1</div>
                          <div class="step-text">
                            <h6>
                              Invoice Details
                            </h6>
                          </div>
                        </a>
                      </div>
                      <div class="step-wrap">
                        <a class="step" href="javascript:void(0)">
                          <div class="step-number">2</div>
                          <div class="step-text">
                            <h6>
                              Service Cost
                            </h6>
                          </div>
                        </a>
                      </div>
                      <div class="step-wrap">
                        <a class="step" href="javascript:void(0)">
                          <div class="step-number">3</div>
                          <div class="step-text">
                            <h6>
                              Upload Invoice
                            </h6>
                          </div>
                        </a>
                      </div>
                    </div>
                    <div class="step1">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" placeholder="DD/MM/YYYY">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" placeholder="" value="DD/MM/YYYY">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">Invoice Number</label>
                            <input type="text" class="form-control" placeholder="000000000000000">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">Link a Participant</label>
                            <input type="text" class="form-control" placeholder="Participant Name">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="step2">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">Item Number</label>
                            <select class="form-select">
                              <option value="">Choose Item Number</option>
                              <option value="">Choose Item Number</option>
                              <option value="">Choose Item Number</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="mb-4">
                            <label class="form-label">Claim Type</label>
                            <select class="form-select">
                              <option value="">Choose Claim Type</option>
                              <option value="">Choose Claim Type</option>
                              <option value="">Choose Claim Type</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="row g-3">
                              <div class="col-8">
                                <div class="mb-4">
                                  <label class="form-label">Service Length (1h = 1)</label>
                                  <input type="text" class="form-control" placeholder="Enter Amount">
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="mb-4">
                                  <label class="form-label">Cost</label>
                                  <input type="text" class="form-control" placeholder="$">
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="row g-3">
                              <div class="col-8">
                                <div class="mb-4">
                                  <label class="form-label">Tax Rate</label>
                                  <select class="form-select">
                                    <option value="">GST Free</option>
                                    <option value="">GST Free</option>
                                    <option value="">GST Free</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-4">
                                <div class="mb-4">
                                  <label class="form-label">Total</label>
                                  <input type="text" class="form-control" placeholder="$">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="text-end">
                          <button type="button" class="btn btn-primary btn-sm">Remove Service</button>
                        </div>
                      </div>
                      <div class="pt-4 mt-4 border-top">
                        <button class="btn btn-light btn-lg w-100 py-3">+ Add New Service</button>
                      </div>
                    </div>
                    <div class="step3">
                      <div class="mb-4">
                        <label class="form-label">Upload Invoice</label>
                        <div class="input-group-overlay">
                          <div class="input-group-prepend-overlay">
                            <span class="input-group-text text-primary">
                              <ion-icon name="document-attach-outline"></ion-icon>
                            </span>
                          </div>
                          <input type="text" placeholder="Invoice file name" aria-label="Invoice file name"
                            aria-describedby="fileBtn" class="form-control prepended-form-control">
                          <div class="input-group-append-overlay">
                            <span class="input-group-text text-primary">
                              <button type="button" id="fileBtn" class="btn btn-text p-0 fw-bold text-primary">View
                                File</button>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                      <button class="btn btn-primary btn-lg w-100 py-3 mb-3">
                        Next
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Popup End --}}

            {{-- Claim Details Popup --}}
            <div class="modal" id="claimDetailPopup" tabindex="-1" aria-labelledby="claimDetailPopupTitle"
              aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content addUserPopup">
                  <div class="modal-header">
                    <h4 class="modal-title" id="claimDetailPopupTitle">Claim #1231231</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body addUser">
                    <div class="row">
                      <div class="col-xl-3">
                        <h5 class="border-bottom pb-3 mb-3">Invoice Details</h5>
                        <div class="row">
                          <div class="col-md-6 col-xl-12">
                            <div class="mb-4">
                              <label class="form-label">Start Date</label>
                              <input type="date" class="form-control" placeholder="01/01/2021">
                            </div>
                          </div>
                          <div class="col-md-6 col-xl-12">
                            <div class="mb-4">
                              <label class="form-label">End Date</label>
                              <input type="date" class="form-control" placeholder="01/01/2021">
                            </div>
                          </div>
                          <div class="col-md-6 col-xl-12">
                            <div class="mb-4">
                              <label class="form-label">Provider</label>
                              <div class="bg-light d-flex align-items-center p-3 participant-card">
                                <div class="me-3"><img src="/images/avatar.png" width="40" alt=""></div>
                                <div class="participant-name">
                                  <h6>Users Name</h6> <span class="text-primary">Provider</span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-6 col-xl-12">
                            <div class="mb-4">
                              <label class="form-label">Participant</label>
                              <div class="bg-light d-flex align-items-center p-3 participant-card">
                                <div class="me-3"><img src="/images/avatar.png" width="40" alt=""></div>
                                <div class="participant-name">
                                  <h6>Users Name</h6> <span class="text-primary">Participant</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-6">
                        <h5 class="border-bottom pb-3 mb-3">Service Cost</h5>
                        <div class="cost-div">
                          <div class="my-4">
                            <span class="badge bg-primary py-2 px-4">Service #1</span>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="mb-4">
                                <label class="form-label">Claim Type</label>
                                <input type="text" class="form-control" placeholder="Standard">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="mb-4">
                                <label class="form-label">Item Number</label>
                                <input type="text" class="form-control" placeholder="134134134134">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="row g-3">
                                <div class="col-sm-8">
                                  <div class="mb-4">
                                    <label class="form-label">Service Length (1h = 1)</label>
                                    <input type="text" class="form-control" placeholder="0.5">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-4">
                                    <label class="form-label">Cost</label>
                                    <input type="text" class="form-control" placeholder="$100">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row g-3">
                                <div class="col-sm-8">
                                  <div class="mb-4">
                                    <label class="form-label">Tax Rate</label>
                                    <input type="text" class="form-control" placeholder="GST Free">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-4">
                                    <label class="form-label">Total</label>
                                    <input type="text" class="form-control" placeholder="$100">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="cost-div">
                          <div class="my-4">
                            <span class="badge bg-primary py-2 px-4">Service #1</span>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="mb-4">
                                <label class="form-label">Claim Type</label>
                                <input type="text" class="form-control" placeholder="Standard">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="mb-4">
                                <label class="form-label">Item Number</label>
                                <input type="text" class="form-control" placeholder="134134134134">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-6">
                              <div class="row g-3">
                                <div class="col-sm-8">
                                  <div class="mb-4">
                                    <label class="form-label">Service Length (1h = 1)</label>
                                    <input type="text" class="form-control" placeholder="0.5">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-4">
                                    <label class="form-label">Cost</label>
                                    <input type="text" class="form-control" placeholder="$100">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row g-3">
                                <div class="col-sm-8">
                                  <div class="mb-4">
                                    <label class="form-label">Tax Rate</label>
                                    <input type="text" class="form-control" placeholder="GST Free">
                                  </div>
                                </div>
                                <div class="col-sm-4">
                                  <div class="mb-4">
                                    <label class="form-label">Total</label>
                                    <input type="text" class="form-control" placeholder="$100">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-xl-3">
                        <h5 class="border-bottom pb-3 mb-3">Invoice</h5>
                        <div class="mb-4 mb-md-5">
                          <label class="form-label">Upload Invoice</label>
                          <div class="input-group-overlay">
                            <div class="input-group-prepend-overlay">
                              <span class="input-group-text text-primary">
                                <ion-icon name="document-attach-outline"></ion-icon>
                              </span>
                            </div>
                            <input type="text" placeholder="Invoice file name" aria-label="Invoice file name"
                              aria-describedby="fileBtn" class="form-control prepended-form-control">
                            <div class="input-group-append-overlay">
                              <span class="input-group-text text-primary">
                                <button type="button" id="fileBtn" class="btn btn-text p-0 fw-bold text-primary">View
                                  File</button>
                              </span>
                            </div>
                          </div>
                        </div>
                        <h5 class="border-bottom pb-3 mb-3">Cancellation Reason</h5>
                        <div class="mb-4">
                          <input type="text" class="form-control" placeholder="Cancellation Reason">
                        </div>
                      </div>
                    </div>
                    <div class="text-center mt-3 mt-md-5">
                      <button class="btn btn-light btn-lg py-md-3 px-md-5 mx-2">Reject Claim</button>
                      <button class="btn btn-primary btn-lg py-md-3 px-md-5 mx-2">Accept Claim</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Popup End --}}

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
            </div>
            <div class="table-x-scroll">
              <div class="d-flex border-top pt-4">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Participant</span>
                </div>
              </div>
              <div class="d-flex border-top pt-4 mt-4">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Participant</span>
                </div>
              </div>
              <div class="d-flex border-top py-4 mt-4 border-bottom">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Participant</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card mt-4">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <div>
                <h5>Your Providers</h5>
                <small class="text-primary">9999 Providers</small>
              </div>
            </div>
            <div class="table-x-scroll">
              <div class="d-flex border-top pt-4">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Provider</span>
                </div>
              </div>
              <div class="d-flex border-top pt-4 mt-4">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Provider</span>
                </div>
              </div>
              <div class="d-flex border-top pt-4 mt-4">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Provider</span>
                </div>
              </div>
              <div class="d-flex border-top py-4 mt-4 border-bottom">
                <div class="me-4">
                  <img src="/images/avatar.png" width="50" height="50" alt="" />
                </div>
                <div class="fw-bold">
                  Users Name
                  <span class="d-block text-primary fw-normal">Provider</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
@endsection