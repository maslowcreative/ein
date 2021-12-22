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
          <button type="button" class="btn-close"  v-on:click="closePopup()"></button>
        </div>
        <form @submit.prevent="createUser" method="POST">
          <div class="modal-body addUser">
            <div class="row">
              <div class="col-md-5">
                <ul class="stepList mb-5 mb-md-0">
                  <li>
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(1)"
                      v-bind:class="step === 1 ? 'active' : ''"
                    >
                      <div class="step-number">1</div>
                      <div class="step-text">
                        <h6>
                          Choose User Type
                        </h6>
                        Provider, Participant or Representative
                      </div>
                    </a>
                  </li>
                  <li>
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(2)"
                      v-bind:class="step === 2 ? 'active' : ''"
                    >
                      <div class="step-number">2</div>
                      <div class="step-text">
                        <h6>
                          Personal Information
                        </h6>
                        Enter your user’s personal information
                      </div>
                    </a>
                  </li>
                  <li>
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(3)"
                      v-bind:class="step === 3 ? 'active' : ''"
                    >
                      <div class="step-number">3</div>
                      <div class="step-text">
                        <h6>
                          Contact Information
                        </h6>
                        Enter User’s Contact information
                      </div>
                    </a>
                  </li>
                  <li v-if="form.role_id != 3">
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(4)"
                      v-bind:class="step === 4 ? 'active' : ''"
                    >
                      <div class="step-number">4</div>
                      <div class="step-text">
                        <h6>
                          NDIS Information
                        </h6>
                        Provide information related to NDIS
                      </div>
                    </a>
                  </li>
                  <li v-if="form.role_id != 3 && form.role_id != 4">
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(5)"
                      v-bind:class="step === 5 ? 'active' : ''"
                    >
                      <div class="step-number">5</div>
                      <div class="step-text">
                        <h6>
                          Login Information
                        </h6>
                        Set-up a password for your new user
                      </div>
                    </a>
                  </li>
                  <li v-if="form.role_id == 3">
                    <a
                      class="title d-inline-flex align-items-center"
                      href="javascript:void(0)"
                      v-on:click="current(4)"
                      v-bind:class="step === 4 ? 'active' : ''"
                    >
                      <div class="step-number">4</div>
                      <div class="step-text">
                        <h6>
                          Login Information
                        </h6>
                        Set-up a password for your new user
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="col-md-7">
                <!-- Step 1 Common-->
                <div class="step1 mw420 mx-auto" v-show="step === 1">
                  <h6 class="mb-3 mb-md-5">Choose your User Type</h6>
                  <div class="d-grid userType">
                    <div>
                      <input
                        type="radio"
                        name="user-type"
                        class="btn-check"
                        checked
                        id="btn-check-1"
                        v-model="form.role_id"
                        value="2"
                        autocomplete="off"
                      />
                      <label class="btn btn-light d-block btn-lg" for="btn-check-1">Provider</label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="user-type"
                        class="btn-check"
                        id="btn-check-2"
                        v-model="form.role_id"
                        value="4"
                        autocomplete="off"
                      />
                      <label class="btn btn-light d-block btn-lg" for="btn-check-2">Participant</label>
                    </div>
                    <div>
                      <input
                        type="radio"
                        name="user-type"
                        class="btn-check"
                        id="btn-check-3"
                        v-model="form.role_id"
                        value="3"
                        autocomplete="off"
                      />
                      <label class="btn btn-light d-block btn-lg" for="btn-check-3">Representative</label>
                    </div>
                    <div class="invalid-msg" v-if="form.errors.has('role_id')" v-html="form.errors.get('role_id')" />
                  </div>
                </div>

                <!-- Step 2 Provider-->
                <div class="step2" v-show="step === 2 && form.role_id == 2">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Full Name</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.name"
                          placeholder="The Name of the Provider"
                        />
                        <div class="invalid-msg" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                            <div class="dropdownWrap">
                                <label for="linkAParticipant" class="form-label">Link a Participant</label>
                                <input
                                    type="text"
                                    autocomplete="off"
                                    class="form-control"
                                    id="linkAParticipant"
                                    placeholder="Participant’s Name"
                                    v-model="participantSerachName"
                                />
                                <div
                                    class="dropdownSec scroll-y"
                                    style="--box-height:154px"
                                    v-if="participantSerachResult.length > 0"
                                >
                                    <div
                                        v-for="participant in participantSerachResult"
                                        :key="participant.id"
                                        v-on:click="selectItem(participant.id, 'participant')"
                                        class="bg-light d-flex align-items-center p-3 participant-card"
                                    >
                                        <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                        <div class="participant-name">
                                            <h6>{{ participant.name }}</h6>
                                            <span class="text-primary">Participant</span>
                                        </div>
                                        <div class="ms-auto">
                                            <button
                                                class="btn btn-link p-0 participant-remove"
                                                type="button"
                                                v-on:click="removeItem(participant.id, 'participant')"
                                            >
                                                <ion-icon name="remove-circle-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 scroll-y" style="--box-height:154px">
                                <div
                                    class="bg-light d-flex align-items-center p-3 participant-card"
                                    v-for="participant in participantSelected"
                                >
                                    <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                    <div class="participant-name">
                                        <h6>{{ participant.name }}</h6>
                                        <span class="text-primary">Participant</span>
                                    </div>
                                    <div class="ms-auto">
                                        <button
                                            class="btn btn-link p-0 participant-remove"
                                            type="button"
                                            v-on:click="removeItem(participant.id, 'participant')"
                                        >
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>

                <!-- Step 2 Participant-->
                <div class="step2" v-show="step === 2 && form.role_id == 4">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Full Name</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.name"
                          placeholder="The Name of the Participant"
                        />
                        <div class="invalid-msg" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Date of Birth</label>
                        <input
                          type="date"
                          v-model="form.participant.dob"
                          class="form-control"
                          placeholder="01/01/1999"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.dob')"
                          v-html="form.errors.get('participant.dob')"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label for="ndisNumber" class="form-label">NDIS Number</label>
                        <input
                          type="tel"
                          class="form-control"
                          v-model="form.participant.ndis_number"
                          id="ndisNumber"
                          placeholder="16515656115615656"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.ndis_number')"
                          v-html="form.errors.get('participant.ndis_number')"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <div class="dropdownWrap">
                          <label for="linkAParticipant" class="form-label">Link a Representative</label>
                          <input
                            type="text"
                            class="form-control"
                            autocomplete="off"
                            id="linkARepresentative"
                            placeholder="Representative’s Name"
                            v-model="representativeSerachName"
                          />
                          <div
                            v-if="representativeSerachResult.length > 0"
                            class="dropdownSec scroll-y"
                            style="--box-height:154px"
                          >
                            <div
                              class="bg-light d-flex align-items-center p-3 participant-card"
                              v-for="representative in representativeSerachResult"
                              :key="representative.id"
                              v-on:click="selectItem(representative.id, 'representative')"
                            >
                              <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                              <div class="participant-name">
                                <h6>{{ representative.name }}</h6>
                                <span class="text-primary">Representative</span>
                              </div>
                              <div class="ms-auto">

                                <button
                                  class="btn btn-link p-0 participant-remove"
                                  type="button"
                                  v-on:click="removeItem(representative.id, 'representative')"
                                >
                                  <ion-icon name="remove-circle-outline"></ion-icon>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="mt-2">
                          <div
                            class="bg-light d-flex align-items-center p-3 participant-card"
                            v-if="representativeSelected"
                          >
                            <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                            <div class="participant-name">
                              <h6>{{ representativeSelected.name }}</h6>
                              <span class="text-primary">Representative</span>
                            </div>
                            <div class="ms-auto">
                              <button
                                class="btn btn-link p-0 participant-remove"
                                type="button"
                                v-on:click="removeItem(representativeSelected.id, 'representative')"
                              >
                                <ion-icon name="remove-circle-outline"></ion-icon>
                              </button>
                            </div>
                          </div>

                          <div
                            class="invalid-msg"
                            v-if="form.errors.has('participant.representative_id')"
                            v-html="form.errors.get('participant.representative_id')"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <div class="dropdownWrap">
                          <label for="linkAProvider" class="form-label">Link a Provider</label>
                          <input
                            type="text"
                            class="form-control"
                            autocomplete="off"
                            id="linkAProvider"
                            placeholder="Provider’s Name"
                            v-model="providerSerachName"
                          />
                          <div
                            class="dropdownSec scroll-y"
                            style="--box-height:154px"
                            v-if="providerSerachResult.length > 0"
                          >
                            <div
                              v-for="provider in providerSerachResult"
                              :key="provider.id"
                              v-on:click="selectItem(provider.id, 'provider')"
                              class="bg-light d-flex align-items-center p-3 participant-card"
                            >
                              <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                              <div class="participant-name">
                                <h6>{{ provider.name }}</h6>
                                <span class="text-primary">Provider</span>
                              </div>
                              <div class="ms-auto">
                                <button
                                  class="btn btn-link p-0 participant-remove"
                                  type="button"
                                  v-on:click="removeItem(provider.id, 'provider')"
                                >
                                  <ion-icon name="remove-circle-outline"></ion-icon>
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="mt-2 scroll-y" style="--box-height:154px">
                          <div
                            class="bg-light d-flex align-items-center p-3 participant-card"
                            v-for="provider in providerSelected"
                          >
                            <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                            <div class="participant-name">
                              <h6>{{ provider.name }}</h6>
                              <span class="text-primary">Provider</span>
                            </div>
                            <div class="ms-auto">
                              <button
                                class="btn btn-link p-0 participant-remove"
                                type="button"
                                v-on:click="removeItem(provider.id, 'provider')"
                              >
                                <ion-icon name="remove-circle-outline"></ion-icon>
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Step 2 Representative-->
                <div class="step2" v-show="step === 2 && form.role_id == 3">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label class="form-label">Full Name</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.name"
                          placeholder="The Name of the Representative"
                        />
                        <div class="invalid-msg" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                            <div class="dropdownWrap">
                                <label for="linkAParticipant2" class="form-label">Link a Participant</label>
                                <input
                                    type="text"
                                    autocomplete="off"
                                    class="form-control"
                                    id="linkAParticipant2"
                                    placeholder="Participant’s Name"
                                    v-model="participantSerachName"
                                />
                                <div
                                    class="dropdownSec scroll-y"
                                    style="--box-height:154px"
                                    v-if="participantSerachResult.length > 0"
                                >
                                    <div
                                        v-for="participant in participantSerachResult"
                                        :key="participant.id"
                                        v-on:click="selectItem(participant.id, 'participant')"
                                        class="bg-light d-flex align-items-center p-3 participant-card"
                                    >
                                        <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                        <div class="participant-name">
                                            <h6>{{ participant.name }}</h6>
                                            <span class="text-primary">Participant</span>
                                        </div>
                                        <div class="ms-auto">
                                            <button
                                                class="btn btn-link p-0 participant-remove"
                                                type="button"
                                                v-on:click="removeItem(participant.id, 'participant')"
                                            >
                                                <ion-icon name="remove-circle-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 scroll-y" style="--box-height:154px">
                                <div
                                    class="bg-light d-flex align-items-center p-3 participant-card"
                                    v-for="participant in participantSelected"
                                >
                                    <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                    <div class="participant-name">
                                        <h6>{{ participant.name }}</h6>
                                        <span class="text-primary">Participant</span>
                                    </div>
                                    <div class="ms-auto">
                                        <button
                                            class="btn btn-link p-0 participant-remove"
                                            type="button"
                                            v-on:click="removeItem(participant.id, 'participant')"
                                        >
                                            <ion-icon name="remove-circle-outline"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>

                <!-- Step 3-->
                <div class="step3 mw290 mx-auto" v-show="step === 3">
                  <div class="mb-4">
                    <label for="homeAddress" class="form-label fw-bold">Home Address</label>
                    <textarea
                      cols="30"
                      rows="2"
                      class="form-control"
                      id="homeAddress"
                      v-model="form.address"
                      placeholder="Home Address 13, 10000 State, Country."
                    ></textarea>
                    <div class="invalid-msg" v-if="form.errors.has('address')" v-html="form.errors.get('address')" />
                  </div>
                  <div class="mb-4" v-if="form.role_id == 4">
                        <label for="state" class="form-label fw-bold">State</label>
                        <select class="form-control" id="state" v-model="form.state">
                            <option value="">Select a state</option>
                            <option value="ACT">Australian Capital Territory</option>
                            <option value="NSW">New South Wales</option>
                            <option value="NT">Northern Territory</option>
                            <option value="QLD">Queensland</option>
                            <option value="SA">South Australia</option>
                            <option value="TAS">Tasmania</option>
                            <option value="VIC">Victoria</option>
                            <option value="WA">Western Australia</option>
                        </select>
                        <div class="invalid-msg" v-if="form.errors.has('state')" v-html="form.errors.get('state')" />
                    </div>
                  <div class="mb-4" v-if="form.role_id != 4">
                    <label class="form-label fw-bold">E-mail Address</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="form.email"
                      placeholder="providersemail@gmail.com"
                    />
                    <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                  </div>
                  <div class="mb-4">
                    <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                    <input
                      type="tel"
                      class="form-control"
                      id="phoneNumber"
                      v-model="form.phone"
                      placeholder="0000000000"
                    />
                    <div class="invalid-msg" v-if="form.errors.has('phone')" v-html="form.errors.get('phone')" />
                  </div>
                </div>

                <!-- Step 4 Provider-->
                <div class="step4 mw290 mx-auto" v-show="step === 4 && form.role_id == 2">
                  <div>
                    <div class="mb-4">
                      <label for="abnNumber" class="form-label fw-bold">ABN</label>
                      <input
                        type="text"
                        class="form-control"
                        id="abnNumber"
                        v-model="form.provider.abn"
                        placeholder="00000000000000000000"
                      />
                      <div
                        class="invalid-msg"
                        v-if="form.errors.has('provider.abn')"
                        v-html="form.errors.get('provider.abn')"
                      />
                    </div>
                    <div class="mb-4">
                      <label  class="form-label fw-bold">Specific Item Numbers</label>
                        <multiselect
                            v-model="servicesItemsSelected"
                            placeholder="Search or add item"
                            label="support_item_number" track-by="support_item_number"
                            :options="servicesItemsResult"
                            :multiple="true"
                            :taggable="true"
                            :searchable="true"
                            :loading="loader"
                            :internal-search="false"
                            :clear-on-select="false"
                            :close-on-select="false"
                            :options-limit="50" :limit="15"
                            @search-change="asyncFindItemNumber"
                            >
                        </multiselect>
                    </div>
                  </div>
                </div>

                <!-- Step 4 Participant-->
                <div class="step4 mx-auto" v-show="step === 4 && form.role_id == 4" v-if="form.role_id != 3">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-4">
                          <label for="ndisPlanFile" class="form-label">NDIS File</label>
                          <div class="input-group-overlay">
<!--                              <div class="input-group-prepend-overlay">-->
<!--                                <span class="input-group-text text-primary"-->
<!--                                ><ion-icon name="document-attach-outline"></ion-icon-->
<!--                                ></span>-->
<!--                              </div>-->
                              <input
                                  type="file"
                                  class="form-control"
                                  id="ndisPlanFile"
                                  placeholder="Plan File"
                                  v-on:change="onFileChange"
                                  accept="application/pdf"
                              />
                              <div
                                  class="invalid-msg"
                                  v-if="form.errors.has('participant.plan.file_name')"
                                  v-html="form.errors.get('participant.plan.file_name')"
                              />
                          </div>
                      </div>
                    </div>
<!--                    <div class="col-md-6">-->
<!--                      <div class="mb-4">-->
<!--                        <label for="ndisPlanName" class="form-label">NDIS Plan</label>-->
<!--                        <div class="input-group-overlay">-->
<!--                          <div class="input-group-prepend-overlay">-->
<!--                            <span class="input-group-text text-primary"-->
<!--                              ><ion-icon name="document-attach-outline"></ion-icon-->
<!--                            ></span>-->
<!--                          </div>-->
<!--                          <input-->
<!--                            type="text"-->
<!--                            class="form-control prepended-form-control"-->
<!--                            id="ndisPlanName"-->
<!--                            placeholder="Plan Name"-->
<!--                            v-model = "form.participant.plan.plan_name"-->
<!--                          />-->
<!--                          <div-->
<!--                                class="invalid-msg"-->
<!--                                v-if="form.errors.has('participant.plan.plan_name')"-->
<!--                                v-html="form.errors.get('participant.plan.plan_name')"-->
<!--                            />-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label  class="form-label">Types of Charges</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.participant.plan.charges_types"
                          placeholder="REPW, TRAN"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.plan.charges_types')"
                          v-html="form.errors.get('participant.plan.charges_types')"
                        />
                       </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label for="planStartDate" class="form-label">Plan Start Date</label>
                        <input
                          type="date"
                          class="form-control"
                          id="planStartDate"
                          v-model="form.participant.plan.start_date"
                          placeholder="01/01/1999"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.plan.start_date')"
                          v-html="form.errors.get('participant.plan.start_date')"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label for="planEndDate" class="form-label">Plan End Date</label>
                        <input
                          type="date"
                          class="form-control"
                          id="planEndDate"
                          v-model="form.participant.plan.end_date"
                          placeholder="01/01/1999"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.plan.end_date')"
                          v-html="form.errors.get('participant.plan.end_date')"
                        />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label for="budget" class="form-label">User’s Budget</label>
                        <input
                          type="text"
                          class="form-control"
                          v-model="form.participant.plan.budget"
                          placeholder="$180,000"
                        />
                        <div
                          class="invalid-msg"
                          v-if="form.errors.has('participant.plan.budget')"
                          v-html="form.errors.get('participant.plan.budget')"
                        />
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Step 5 Provider-->
                <div class="step5 mw290 mx-auto" v-show="step === 5 || (step === 4 && form.role_id == 3)">
                  <div class="form-check emailRequest">
                    <input  class="form-check-input" v-model="form.random_password" type="checkbox"  id="emailRequest" />

                    <label class="form-check-label" for="emailRequest">
                      Send email request for the new user to create password
                    </label>
                      <div
                          class="invalid-msg"
                          v-if="form.errors.has('random_password')"
                          v-html="form.errors.get('random_password')"
                      />
                  </div>
                  <div class="my-4">
                    <label class="form-label">Enter Password</label>
                    <input :disabled="form.random_password" type="password" v-model="form.password" class="form-control" placeholder="****************************" />
                      <div
                          class="invalid-msg"
                          v-if="form.errors.has('password')"
                          v-html="form.errors.get('password')"
                      />
                  </div>
                  <div class="mb-4">
                    <label for="confirmPassword" class="form-label">Confirm the Password</label>
                    <input
                      :disabled="form.random_password"
                      type="password"
                      v-model="form.password_confirmation"
                      class="form-control"
                      id="confirmPassword"
                      placeholder="****************************"
                    />
                      <div
                          class="invalid-msg"
                          v-if="form.errors.has('password_confirmation')"
                          v-html="form.errors.get('password_confirmation')"
                      />
                  </div>
                </div>
                <div v-show="step > 0" class="mw290 mx-auto px-4 mt-4 mt-md-5">
                  <button v-if="!lastStep" class="btn btn-primary btn-lg w-100 py-3 mb-3" @click.prevent="next()">
                    Next
                  </button>
                  <button v-if="lastStep && !loader" type="submit" class="btn btn-primary btn-lg w-100 py-3">
                    Submit
                  </button>
                  <button
                    v-else-if="lastStep && loader"
                    class="btn btn-primary btn-lg w-100 py-3"
                    type="button"
                    disabled
                  >
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
                </div>
                <div
                  v-if="step == 0"
                  class="step-6 step-final mw290 mx-auto px-4 text-center d-flex justify-content-center align-items-center flex-column"
                >
                  <ion-icon name="checkmark-circle-outline" class="final-icon"></ion-icon>
                  <h4>New User Created!</h4>
                  <button class="btn btn-primary btn-lg w-100 py-3">Back to Dashboard</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
import 'vue-select/dist/vue-select.css';

<script>
import Form from "vform"
import Multiselect from 'vue-multiselect'
export default {
  components: { Multiselect },
  data() {
    return {
      loader: false,
      stepsMap: {
        2: 5,
        4: 4,
        3: 4,
      },
      step: 1,
      lastStep: false,
      form: new Form({
        role_id: 2,
        name: null,
        email: null,
        random_password: false,
        password: null,
        password_confirmation: null,
        phone: null,
        address: null,
        state: "",
        provider: {
          abn: null,
          business_name: null,
          participants: [],
          items:[],
        },
        participant: {
          dob: null,
          ndis_number: null,
          representative_id: null,
          providers: [],
          plan: {
            file_name: null,
            start_date: null,
            end_date: null,
            budget: null,
            charges_types: null,
          },
        },
        representative:{
            participants:[]
        }
      }),
      participantSerachName: null,
      participantSerachResult: [],
      participantSelected: [],

      providerSerachName: null,
      providerSerachResult: [],
      providerSelected: [],

      representativeSerachName: null,
      representativeSerachResult: [],
      representativeSelected: null,


      servicesItemsResult: [],
      servicesItemsSelected: [],
    }
  },
  mounted() {},
  watch: {
    "form.role_id": function(val, old) {
      if (val != old) {
        this.form = new Form({
          role_id: val,
          name: null,
          email: null,
          random_password: false,
          password: null,
          password_confirmation: null,
          phone: null,
          address: null,
          state: "",
          provider: {
            abn: null,
            business_name: null,
            participants: [],
            items:[]
          },
          participant: {
            dob: null,
            ndis_number: null,
            representative_id: null,
            providers: [],
            plan: {
              file_name: null,
              start_date: null,
              end_date: null,
              budget: null,
              charges_types: null,
            },
          },
          representative:{
            participants:[]
          }
        });
        this.participantSerachName = null
        this.participantSerachResult = []
        this.participantSelected = []

        this.providerSerachName = null
        this.providerSerachResult = []
        this.providerSelected = []

        this.representativeSerachName = null
        this.representativeSerachResult = []
        this.representativeSelected = null
      }
    },
    step(val, old) {
      if (val == this.stepsMap[this.form.role_id]) {
        this.lastStep = true
      } else {
        this.lastStep = false
      }
    },
    participantSerachName(val, old) {
      if (val) {
        this.asyncFind(val, "participant")
      } else {
        this.participantSerachResult = []
      }
    },
    providerSerachName(val, old) {
      if (val) {
        this.asyncFind(val, "provider")
      } else {
        this.providerSerachResult = []
      }
    },
    representativeSerachName(val, old) {
      if (val) {
        this.asyncFind(val, "representative")
      } else {
        this.representativeSerachResult = []
      }
    },
    servicesItemsSelected(val,old) {
        this.form.provider.items =  this.servicesItemsSelected.map(function(item){
            return item.support_item_number;
        });
    },
    "form.random_password": function (val,old) {
        if(val == true ){
            this.form.password = null;
            this.form.password_confirmation = null;
        }
    }
  },
  methods: {
    current(value) {
      this.step = value
    },
    prev() {
      this.step--
    },
    next() {
      if (this.step < this.stepsMap[this.form.role_id]) {
        this.step++
      }
    },
    createUser() {
      this.loader = true
      let route = this.laroute.route("ajax.users.store")
      this.form
        .post(route)
        .then(res => {
          if (res.status == 201) {
            this.resetForm(0);
            this.$root.$emit("ein-user:added")
            this.$toastr.s("Success", "Account created!");
          }
        })
        .catch(error => {
          this.$toastr.e("Error", "Some thing went wrong.")
        })
        .finally(() => {
          this.loader = false
        })
    },
    selectItem(id, $role) {
      if ($role === "participant") {
        let participant = this.participantSerachResult.filter(participant => participant.id == id)
        this.participantSerachResult = this.participantSerachResult.filter(function(item) {
          if (item.id != id) {
            return item
          }
        })
        this.participantSelected.push(participant[0])

        if(this.form.role_id == 2){
          this.form.provider.participants.push(id)
        }

        if(this.form.role_id == 3){
            this.form.representative.participants.push(id)
        }

      } else if ($role === "provider") {
        let provider = this.providerSerachResult.filter(provider => provider.id == id)
        this.providerSerachResult = this.providerSerachResult.filter(function(item) {
          if (item.id != id) {
            return item
          }
        })
        this.providerSelected.push(provider[0])
        this.form.participant.providers.push(id)
      } else if ($role === "representative") {
        let representative = this.representativeSerachResult.filter(representative => representative.id == id)
        this.representativeSelected = representative[0]
        this.form.participant.representative_id = this.representativeSelected.id
        this.representativeSerachName = null
        this.representativeSerachResult = []
      }
    },
    removeItem(id, $role) {
      if ($role === "participant") {
        this.participantSelected = this.participantSelected.filter(function(item) {
          if (item.id != id) {
            return item
          }
        })
       if(this.form.role_id == 2){
           this.form.provider.participants = this.form.provider.participants.filter(function(item) {
               if (item != id) {
                   return item
               }
           });
       }

       if(this.form.role_id == 3){
          this.form.representative.participants = this.form.representative.participants.filter(function(item) {
               if (item != id) {
                   return item
               }
           });
       }

      } else if ($role === "provider") {
        this.providerSelected = this.providerSelected.filter(function(item) {
          if (item.id != id) {
            return item
          }
        })
        this.form.participant.providers = this.form.participant.providers.filter(function(item) {
          if (item != id) {
            return item
          }
        })
      } else if ($role === "representative") {
        this.representativeSelected = null
        this.form.participant.representative_id = null
      }
    },
    asyncFind(query, role = "") {
      this.loader = true;
      let data = {
        "filter[name]": query,
        "filter[roles][0]": role,
      }

      if (role === "participant") {
        this.participantSerachResult = []
        this.participantSelected.map(function(item, index) {
          data["filter[not_in][" + index + "]"] = item.id
        })
      } else if (role === "provider") {
        this.providerSerachResult = []
        this.providerSelected.map(function(item, index) {
          data["filter[not_in][" + index + "]"] = item.id
        })
      } else if (role === "representative") {
        this.representativeSerachResult = []
        if (this.representativeSelected) {
          data["filter[not_in][0]"] = this.representativeSelected.id
        }
      }
      let route = this.laroute.route("ajax.users.index", data)
      axios
        .get(route)
        .then(res => {
          if (role === "participant") {
            this.participantSerachResult = res.data.data
          } else if (role === "provider") {
            this.providerSerachResult = res.data.data
          } else if (role === "representative") {
            this.representativeSerachResult = res.data.data
          }
        })
        .catch(error => {
          this.$toastr.e("Error", "Some thing went wrong.")
        })
        .finally(() => {
          this.loader = false
        })
    },

    asyncFindItemNumber(query) {
        this.servicesItemsResult = [];
        let data = {
            "filter[item_number]": query,
        }
        let route = this.laroute.route("ajax.services.index", data)
        axios
            .get(route)
            .then(res => {
                this.servicesItemsResult = res.data.data;
            })
            .catch(error => {
                this.$toastr.e("Error", "Some thing went wrong.")
            })
            .finally(() => {
                this.loader = false
            });
    },
    closePopup() {
      $("#userModal").modal('hide');
      this.resetForm();
   },
   resetForm(step = null) {
       this.loader = false;
       if(step !=null) {
           this.step = step;
       }  else {
           this.step = 1;
       }

       this.lastStep = false;
       this.form =  new Form({
           role_id: 2,
           name: null,
           email: null,
           random_password: false,
           password: null,
           password_confirmation: null,
           phone: null,
           address: null,
           state: "",
           provider: {
               abn: null,
               business_name: null,
               participants: [],
               items:[],
           },
           participant: {
               dob: null,
               ndis_number: null,
               representative_id: null,
               providers: [],
               plan: {

                   plan_name : null,
                   start_date: null,
                   end_date: null,
                   budget: null,
                   charges_types: null,
               },
           },
           representative:{
               participants:[]
           }
       });
       this.participantSerachName = null;
       this.participantSerachResult = [];
       this.participantSelected = [];
       this.providerSerachName = null;
       this.providerSerachResult =[];
       this.providerSelected = [];
       this.representativeSerachName = null;
       this.representativeSerachResult = [];
       this.representativeSelected = null;
       this.servicesItemsResult = [];
       this.servicesItemsSelected = [];
   },
   onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files;
      if (!files.length)
          return;

      let route = this.laroute.route("ajax.plans.upload");
      let  form = new Form({
          'file':files[0]
      });
      form
           .post(route)
           .then(res => {
               this.form.participant.plan.file_name = res.data.file_name;
            })
           .catch(error => {
               this.form.participant.plan.file_name = null;
               this.$toastr.e("Error", "Some thing went wrong while file upload.")
           })
           .finally(() => {
           });
   }



  },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
