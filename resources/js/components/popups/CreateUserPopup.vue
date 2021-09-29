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
        <form @submit.prevent="createUser" method="POST">
            <div class="modal-body addUser">
          <div class="row">
            <div class="col-md-5">
              <ul class="stepList mb-5 mb-md-0">
                <li class="active">
                  <a class="title d-inline-flex align-items-center" href="#" v-on:click="current(1)">
                    <div class="step-number">1</div>
                    <div class="step-text">
                      <h6>Choose User Type <span v-if="step === 1"><b>(Active)</b></span></h6>
                      Provider, Participant or Representative
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#"  v-on:click="current(2)">
                    <div class="step-number">2</div>
                    <div class="step-text">
                      <h6>Personal Information <span v-if="step === 2"><b>(Active)</b></span></h6>
                      Enter your user’s personal information
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#"  v-on:click="current(3)">
                    <div class="step-number">3</div>
                    <div class="step-text">
                      <h6>Contact Information <span v-if="step === 3"><b>(Active)</b></span></h6>
                      Enter User’s Contact information
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">4</div>
                    <div class="step-text">
                      <h6>NDIS Information <span v-if="step === 4"><b>(Active)</b></span></h6>
                      Provide information related to NDIS
                    </div>
                  </a>
                </li>
                <li>
                  <a class="title d-inline-flex align-items-center" href="#">
                    <div class="step-number">5</div>
                    <div class="step-text">
                      <h6>Login Information <span v-if="step === 5"><b>(Active)</b></span></h6>
                      Set-up a password for your new user
                    </div>
                  </a>
                </li>
              </ul>
            </div>
            <div class="col-md-7">
              <!-- Step 1 Common-->
              <div class="step1 mw420 mx-auto" v-show="step === 1">
                <h6 class="mb-3 mb-md-5">Choose your User Type </h6>
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
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-2" v-model="form.role_id" value="4" autocomplete="off" />
                    <label class="btn btn-light d-block btn-lg" for="btn-check-2">Participant</label>
                  </div>
                  <div>
                    <input type="radio" name="user-type" class="btn-check" id="btn-check-3" v-model="form.role_id" value="3" autocomplete="off" />
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
                        <input type="text" class="form-control" v-model="form.name"  placeholder="The Name of the Provider" />
                        <div class="invalid-msg" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label  class="form-label">Full Name</label>
                        <input type="text" class="form-control"  placeholder="The Name of the Provider" />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-4">
                        <label for="linkAParticipant" class="form-label">Link a Participant</label>
                        <input type="text" class="form-control" id="linkAParticipant" placeholder="Participant’s Name" />
                      </div>
                    </div>
                      <div class="col-md-6">
                          <label class="typo__label">Simple select / dropdown</label>



                          <multiselect
                              v-model="value"
                              :options="options"
                              :multiple="true"
                              :close-on-select="false"
                              :clear-on-select="false"
                              :preserve-search="true"
                              :show-labels="true"
                              placeholder="Select Participants" label="name" track-by="name" :preselect-first="true">
                              <template slot="option" slot-scope="props"> <b> {{ props.option.name }} </b>
                              </template>
                              <template slot="selection" slot-scope="{ values, search, isOpen }"> <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                              <template slot="option" slot-scope="{ values, search, isOpen }"> </template>
                          </multiselect>

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
              <!-- Step 2 Participant-->
              <div class="step2" v-show="step === 2 && form.role_id == 4">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label  class="form-label">Full Name</label>
                      <input type="text" class="form-control" v-model="form.name" placeholder="The Name of the Provider" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label class="form-label">Date of Birth</label>
                      <input type="text" class="form-control"  placeholder="01/01/1999" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="uniqueIdentifier" class="form-label">Unique Identifier</label>
                      <input type="tel" class="form-control" id="uniqueIdentifier" placeholder="16515656115615656" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="representative" class="form-label">Link a Representative</label>
                      <div class="input-group-overlay">
                        <div class="input-group-prepend-overlay">
                          <span class="input-group-text text-primary"><ion-icon name="search-outline"></ion-icon></span>
                        </div>
                        <input
                          type="text"
                          class="form-control prepended-form-control"
                          id="representative"
                          placeholder="Representatives Name"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="providerName" class="form-label">Link a Provider</label>
                      <div class="input-group-overlay">
                        <div class="input-group-prepend-overlay">
                          <span class="input-group-text text-primary"><ion-icon name="search-outline"></ion-icon></span>
                        </div>
                        <input
                          type="text"
                          class="form-control prepended-form-control"
                          id="providerName"
                          placeholder="Provider Name"
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Step 3 Provider-->
              <div class="step3 mw290 mx-auto" v-show="step === 3">
                <div class="mb-3">
                  <label for="homeAddress" class="form-label fw-bold">Home Address</label>
                  <textarea
                    cols="30"
                    rows="2"
                    class="form-control"
                    id="homeAddress"
                    v-model="form.address"
                    placeholder="Home Address 13, 10000 State, Country."
                  ></textarea>
                </div>
                <div class="mb-3">
                  <label class="form-label fw-bold">E-mail Address</label>
                  <input type="text" class="form-control" v-model="form.email" placeholder="providersemail@gmail.com" />
                </div>
                <div class="mb-3">
                  <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                  <input type="tel" class="form-control" id="phoneNumber" v-model="form.phone" placeholder="0000000000" />
                </div>
              </div>

              <!-- Step 4 Provider-->
              <div class="step4 mw290 mx-auto" v-show="step === 4 && form.role_id == 2">
                <div>
                  <div class="mb-3">
                    <label for="abnNumber" class="form-label fw-bold">ABN</label>
                    <input type="text" class="form-control" id="abnNumber" v-model="form.provider.abn"  placeholder="00000000000000000000" />
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

              <!-- Step 4 Participant-->
              <div class="step4 mx-auto" v-show="step === 4 && form.role_id == 4">
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="ndisPlan" class="form-label">NDIS Plan</label>
                      <div class="input-group-overlay">
                        <div class="input-group-prepend-overlay">
                          <span class="input-group-text text-primary"
                            ><ion-icon name="document-attach-outline"></ion-icon
                          ></span>
                        </div>
                        <input
                          type="text"
                          class="form-control prepended-form-control"
                          id="ndisPlan"
                          placeholder="Upload NDIS Plan"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label  class="form-label">Date of Birth</label>
                      <input type="text" class="form-control"  placeholder="01/01/1999" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="typesofCharges" class="form-label">Types of Charges</label>
                      <input type="text" class="form-control" id="typesofCharges" placeholder="REPW, TRAN" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="planStartDate" class="form-label">Plan Start Date</label>
                      <input type="text" class="form-control" id="planStartDate" placeholder="01/01/1999" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="planEndDate" class="form-label">Plan End Date</label>
                      <input type="text" class="form-control" id="planEndDate" placeholder="01/01/1999" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-4">
                      <label for="budget" class="form-label">User’s Budget</label>
                      <input type="text" class="form-control" id="budget" placeholder="$180,000" />
                    </div>
                  </div>
                </div>
              </div>

              <!-- Step 5 Provider-->
              <div class="step5 mw290 mx-auto" v-show="step === 5">
                <div class="form-check emailRequest">
                  <input class="form-check-input" type="checkbox" value="" id="emailRequest" />
                  <label class="form-check-label" for="emailRequest">
                    Send email request for the new user to create password
                  </label>
                </div>
                <div class="my-4">
                  <label  class="form-label">Enter Password</label>
                  <input
                    type="password"
                    class="form-control"
                    placeholder="****************************"
                  />
                </div>
                <div class="mb-4">
                  <label for="confirmPassword" class="form-label">Confirm the Password</label>
                  <input
                    type="password"
                    class="form-control"
                    id="confirmPassword"
                    placeholder="****************************"
                  />
                </div>
              </div>


              <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                <button class="btn btn-primary btn-lg w-100 py-3" @click.prevent="next()">Next</button>
              </div>
              <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                <button type="submit" class="btn btn-primary btn-lg w-100 py-3">Submit</button>
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
import Form from "vform";
import Multiselect from 'vue-multiselect';
export default {
  components: { Multiselect },
  data() {
    return {
        value: [],
        options: [
            { name: 'Vue.js', language: 'JavaScript' },
            { name: 'Adonis', language: 'JavaScript' },
            { name: 'Rails', language: 'Ruby' },
            { name: 'Sinatra', language: 'Ruby' },
            { name: 'Laravel', language: 'PHP' },
            { name: 'Phoenix', language: 'Elixir' }
        ],

        loader : false,
        stepsMap: {
            2:5,
        },
        step: 1,
        form: new Form({
            role_id: 2,
            name: null,
            email: null,
            password: null,
            phone : null,
            address: null,
            provider:{
                abn: null,
                business_name: null,
            }
        })
    }
  },
  mounted() {
      this.asyncFind();
  },
  watch:{
      'form.role_id': function (val, old) {
          if(val != old) {

              this.form = new Form({
                  role_id: val,
                  name: null,
                  email: null,
                  password: null,
                  phone : null,
                  address: null,
                  provider:{
                      abn: null,
                      business_name: null,
                  }
              });
          }
      }
  },
  methods: {
    current(value){
     this.step = value;
    },
    prev() {
      this.step--
    },
    next() {
      this.step++
    },
    createUser() {
        this.loader = true;
        let route = this.laroute.route("ajax.users.store")
        this.form
            .post(route)
            .then(res => {
                if ((res.status = 201)) {
                    this.resetForm();
                        this.$toastr.s("Success","Account created!");
                }
            })
            .catch(error => {
                this.$toastr.e("Error","Some thing went wrong.");
            })
            .finally(()=>{
                this.loader = false;
            });
    },
    asyncFind (query) {
          this.isLoading = true
          let route = this.laroute.route("ajax.users.index",{filter:{
                  name:'provider'
              }});
          axios.get(route)
              .then(res => {
                  if ((res.status = 201)) {

                  }
              })
              .catch(error => {
                  this.$toastr.e("Error","Some thing went wrong.");
              })
              .finally(()=>{
                  this.loader = false;
              });

    },
  },
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


