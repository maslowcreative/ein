<template>
  <div
    class="modal fade"
    id="userModal"
    tabindex="-1"
    data-bs-backdrop="static"
    aria-labelledby="userModalTitle"
    aria-hidden="true"
  >
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
                      <h6>Choose User Type</h6>
                      Provider, Participant or Representative
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">2</div>
                    <div class="step-text">
                      <h6>Personal Information</h6>
                      Enter your user’s personal information
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">3</div>
                    <div class="step-text">
                      <h6>Contact Information</h6>
                      Enter User’s Contact information
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">4</div>
                    <div class="step-text">
                      <h6>NDIS Information</h6>
                      Provide information related to NDIS
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">5</div>
                    <div class="step-text">
                      <h6>Login Information</h6>
                      Set-up a password for your new user
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-7">
              <!-- Step 1-->
              <div class="step1 mw420 mx-auto">
                <h6 class="mb-5">Choose your User Type</h6>
                <div class="d-grid userType">
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-1" autocomplete="off" />
                    <label class="btn btn-light d-block btn-lg" for="btn-check-1">Provider</label>
                  </div>
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-2" autocomplete="off" />
                    <label class="btn btn-light d-block btn-lg" for="btn-check-2">Participant</label>
                  </div>
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-3" autocomplete="off" />
                    <label class="btn btn-light d-block btn-lg" for="btn-check-3">Representative</label>
                  </div>
                </div>
              </div>
              <!-- Step 2-->
              <div class="step2 d-none">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="fullName" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullName" placeholder="The Name of the Provider" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="fullName2" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="fullName2" placeholder="The Name of the Provider" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="linkAParticipant" class="form-label">Link a Participant</label>
                      <input type="text" class="form-control" id="linkAParticipant" placeholder="Participant’s Name" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="bg-light d-flex align-items-center p-3 participant-card">
                      <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
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
                      <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
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
              <!-- Step 3-->
              <div class="step3 mw290 mx-auto d-none">
                <div class="mb-3">
                  <label for="homeAddress" class="form-label fw-bold">Home Address</label>
                  <textarea
                    name=""
                    id=""
                    cols="30"
                    rows="2"
                    class="form-control"
                    id="homeAddress"
                    placeholder="Home Address 13, 10000 State, Country."
                  ></textarea>
                </div>
                <div class="mb-3">
                  <label for="emailAddress" class="form-label fw-bold">E-mail Address</label>
                  <input type="text" class="form-control" id="emailAddress" placeholder="providersemail@gmail.com" />
                </div>
                <div class="mb-3">
                  <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                  <input type="tel" class="form-control" id="phoneNumber" placeholder="0000000000" />
                </div>
              </div>
              <!-- Step 4-->
              <div class="step4 mw290 mx-auto d-none">
                <div>
                  <div class="mb-3">
                    <label for="abnNumber" class="form-label fw-bold">ABN</label>
                    <input type="tel" class="form-control" id="abnNumber" placeholder="00000000000000000000" />
                  </div>
                  <div class="mb-3">
                    <label for="specificItemNumbers" class="form-label fw-bold">Specific Item Numbers</label>
                    <textarea
                      name=""
                      id=""
                      cols="30"
                      rows="2"
                      class="form-control"
                      id="specificItemNumbers"
                      placeholder="000000000000, 000000 0000000000, 0000000"
                    ></textarea>
                  </div>
                </div>
              </div>
              <!-- Step 5-->
              <div class="step5 mw420 mx-auto d-none">
                <div class="form-check emailRequest">
                  <input class="form-check-input" type="checkbox" value="" id="emailRequest" />
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
</template>

<script>
export default {
  data() {
    return {}
  },
  mounted() {},
}
</script>
