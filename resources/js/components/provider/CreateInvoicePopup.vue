<template>
    <div class="modal" id="invoicePopup" tabindex="-1" aria-labelledby="invoicePopupTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content invoicePopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="invoicePopupTitle">Submit New Invoice</h4>
                    <button type="button" class="btn-close" v-on:click="closePopup()"></button>
                </div>
                <div class="modal-body invoicePopupBody">
                    <div class="v-steps d-flex justify-content-between border-bottom">
                        <div class="step-wrap">
                            <a class="step" href="javascript:void(0)"
                               v-bind:class="step === 1 ? 'active' : ''"
                               v-on:click="current(1)"
                            >
                                <div class="step-number">1</div>
                                <div class="step-text">
                                    <h6>
                                        Invoice Details
                                    </h6>
                                </div>
                            </a>
                        </div>
                        <div class="step-wrap">
                            <a class="step" href="javascript:void(0)"
                               v-bind:class="step === 2 ? 'active' : ''"
                               v-on:click="current(2)"
                            >
                                <div class="step-number">2</div>
                                <div class="step-text">
                                    <h6>
                                        Service Cost
                                    </h6>
                                </div>
                            </a>
                        </div>
                        <div class="step-wrap">
                            <a class="step" href="javascript:void(0)"
                               v-bind:class="step === 3 ? 'active' : ''"
                               v-on:click="current(3)"
                            >
                                <div class="step-number">3</div>
                                <div class="step-text">
                                    <h6>
                                        Upload Invoice
                                    </h6>
                                </div>
                            </a>
                        </div>
                    </div>
                    <form @submit.prevent="createClaim" method="POST">
                        <div class="step1" v-show="step === 1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" v-model="form.start_date" class="form-control" placeholder="DD/MM/YYYY">
                                        <div class="invalid-msg" v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">End Date</label>
                                        <input type="date" v-model="form.end_date" class="form-control" placeholder="" value="DD/MM/YYYY">
                                        <div class="invalid-msg" v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Invoice Number</label>
                                        <input type="text" v-model="form.invoice_number" class="form-control" placeholder="000000000000000">
                                        <div class="invalid-msg" v-if="form.errors.has('invoice_number')" v-html="form.errors.get('invoice_number')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <div class="dropdownWrap">
                                            <label for="linkAParticipant" class="form-label">Link a Participant</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                id="linkAParticipant"
                                                placeholder="Participant’s Name"
                                                v-model="participantSerachName"
                                            />
                                            <div
                                                v-if="participantSerachResult.length > 0"
                                                class="dropdownSec scroll-y"
                                                style="--box-height:154px"
                                            >
                                                <div
                                                    class="bg-light d-flex align-items-center p-3 participant-card"
                                                    v-for="participant in participantSerachResult"
                                                    :key="participant.id"
                                                    v-on:click="selectItem(participant.id, 'participant')"
                                                >
                                                    <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                                    <div class="participant-name">
                                                        <h6>{{ participant.name }}</h6>
                                                        <span class="text-primary">Participant</span>
                                                    </div>
                                                    <div class="ms-auto">

                                                        <button
                                                            class="btn btn-link p-0 participant-remove"
                                                            v-on:click="removeItem(participant.id, 'participant')"
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
                                                v-if="participantSelected"
                                            >
                                                <div class="me-3"><img src="/images/avatar.png" width="40" alt="" /></div>
                                                <div class="participant-name">
                                                    <h6>{{ participantSelected.name }}</h6>
                                                    <span class="text-primary">Participant</span>
                                                </div>
                                                <div class="ms-auto">
                                                    <button
                                                        class="btn btn-link p-0 participant-remove"
                                                        v-on:click="removeItem(participantSelected.id, 'participant')"
                                                    >
                                                        <ion-icon name="remove-circle-outline"></ion-icon>
                                                    </button>
                                                </div>
                                            </div>

                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('participant_id')"
                                                v-html="form.errors.get('participant_id')"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="step2" v-show="step === 2">
                            <div v-for="(service,index) in form.service">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Item Number</label>
                                            <multiselect
                                                v-model="service.item_number"
                                                placeholder="Search or add item"
                                                :options="servicesItemsResult"
                                                :multiple="false"
                                                :taggable="false"
                                                :searchable="true"
                                                :loading="loader"
                                                :internal-search="false"
                                                :clear-on-select="true"
                                                :close-on-select="true"
                                                :options-limit="50" :limit="15"
                                                @search-change="asyncFindItemNumber"
                                            >
                                            </multiselect>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('service.'+index+'.item_number')"
                                                v-html="form.errors.get('service.'+index+'.item_number')"
                                            />
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Claim Type</label>
                                            <select class="form-select" v-model="service.claim_type">
                                                <option value="">Standard Service Charges</option>
                                                <option value="CANC">Cancellation Charges</option>
                                                <option value="REPW">Report Writing Charges</option>
                                                <option value="TRAN">Travel Charges</option>
                                                <option value="NF2F">Non-Face to Face Services</option>
                                            </select>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('service.'+index+'.claim_type')"
                                                v-html="form.errors.get('service.'+index+'.claim_type')"
                                            />
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
                                                        <input type="text" v-model="service.hours"  class="form-control" placeholder="Enter Amount">
                                                        <div
                                                            class="invalid-msg"
                                                            v-if="form.errors.has('service.'+index+'.hours')"
                                                            v-html="form.errors.get('service.'+index+'.hours')"
                                                        />
                                                    </div>

                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-4">
                                                        <label class="form-label">Cost</label>
                                                        <input type="text" v-model="service.unit_price" class="form-control" placeholder="$">
                                                        <div
                                                            class="invalid-msg"
                                                            v-if="form.errors.has('service.'+index+'.unit_price')"
                                                            v-html="form.errors.get('service.'+index+'.unit_price')"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row g-3">
                                                <div class="col-8">
                                                    <div class="mb-4">
                                                        <label class="form-label">Tax Rate</label>
                                                        <select class="form-select" v-model="service.gst_code">
                                                            <option value="P1">Tax Claimable (10%)</option>
                                                            <option value="P2">GST Free</option>
                                                            <option value="P3">GST out of Scope</option>
                                                        </select>
                                                        <div
                                                            class="invalid-msg"
                                                            v-if="form.errors.has('service.'+index+'.gst_code')"
                                                            v-html="form.errors.get('service.'+index+'.gst_code')"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-4">
                                                        <label class="form-label">Total</label>
                                                        <input type="text"  disabled class="form-control" :value="service.hours * service.unit_price" placeholder="$">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-primary btn-sm" v-on:click="removeService(index)">Remove Service</button>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4 mt-4 border-top">
                                <button type="button" class="btn btn-light btn-lg w-100 py-3" v-on:click="addService()">+ Add New Service</button>
                            </div>
                        </div>
                        <div class="step3" v-show="step === 3">
                            <div class="mb-4">
                                <label class="form-label">Upload Invoice</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Invoice file name"
                                           aria-label="Invoice file name" aria-describedby="fileBtn">
                                    <button class="btn btn-light fw-bold" type="button" id="fileBtn">View File</button>
                                </div>
                            </div>
                        </div>
                        <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                            <button v-if="!lastStep" class="btn btn-primary btn-lg w-100 py-3 mb-3" @click.prevent="next()">
                                Next
                            </button>
                            <button v-if="lastStep && !loader" type="submit" class="btn btn-primary btn-lg w-100 py-3 mb-3">
                                Submit
                            </button>
                            <button
                                v-else-if="lastStep && loader"
                                class="btn btn-primary btn-lg w-100 py-3 mb-3"
                                type="button"
                                disabled
                            >
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
import 'vue-select/dist/vue-select.css';
<script>
import Form from "vform";
import Multiselect from 'vue-multiselect'
export default {
  components: { Multiselect },
  data() {
    return {
        loader: false,
        step: 1,
        lastStep: false,
        form: new Form({
            'start_date': null,
            'end_date': null,
            'invoice_number': null,
            'participant_id': null,
            'service': [
                {
                    'item_number': null,
                    'claim_type': null,
                    'hours' : null,
                    'unit_price': null,
                    'gst_code': 'P2',
                }
            ]
        }),
        participantSerachName: null,
        participantSerachResult: [],
        participantSelected: null,
        servicesItemsResult: [],

    }
  },
  watch: {
      step(val, old) {
          if (val == 3) {
              this.lastStep = true
          } else {
              this.lastStep = false
          }
      },
      participantSerachName(val, old) {
          if (val) {
              this.asyncFind(val, "participant");
          } else {
              this.participantSerachResult = [];
          }
      }
  },
  mounted() {
      this.resetForm();
      VueEvents.$on('ein-provider:participant-selected-to-invoice', (participant) => {
          this.participantSelected = participant;
          this.form.participant_id = participant.id;
          console.log('participant',participant);
      });
  },
  methods: {
      current(value) {
          this.step = value;
      },
      prev() {
          this.step--;
      },
      next() {
          if (this.step < 3) {
              this.step++
          }
      },
      selectItem(id, $role) {
          if ($role === "participant") {
              let participant = this.participantSerachResult.filter(participant => participant.id == id);
              this.participantSelected = participant[0];
              this.form.participant_id = this.participantSelected.id;
              this.participantSerachName = null;
              this.participantSerachResult = [];
          }
      },
      removeItem(id, $key) {
          if ($key === "participant") {
              this.participantSelected = null;
              this.form.participant_id = null;
          }
      },
      resetForm(){
          this.loader = false;
          this.step= 1;
          this.lastStep= false;

          this.form = new Form({
              'start_date': null,
              'end_date': null,
              'invoice_number': null,
              'participant_id': null,
              'service': [
                  {
                      'item_number': null,
                      'claim_type': null,
                      'hours' : null,
                      'unit_price': null,
                      'gst_code': 'P2',
                  }
              ]
          });
          this.participantSerachName= null;
          this.participantSerachResult= [];
          this.participantSelected= null;
          this.servicesItemsResult= [];
      },
      createClaim() {
          this.loader = true;
          let route = this.laroute.route("ajax.claims.store");
          this.form
              .post(route)
              .then(res => {
                  if ((res.status = 201)) {
                      this.resetForm();
                      this.$toastr.s("Success", "Claim created!")
                  }
              })
              .catch(error => {
                  this.$toastr.e("Error", "Some thing went wrong.")
              })
              .finally(() => {
                  this.loader = false
              });

      },
      asyncFind(query, type = "participant") {
          this.loader = true;
          let data = {
              "filter[name]": query,
              "filter[roles][0]": 'participant',
          };

          let route = this.laroute.route("ajax.users.index", data)
          axios
              .get(route)
              .then(res => {
                  this.participantSerachResult = res.data.data;
              })
              .catch(error => {
                  this.$toastr.e("Error", "Some thing went wrong.")
                  console.log(error)
              })
              .finally(() => (this.loader = false))
      },
      addService(){
          this.form.service.push(
              {
                  'item_number': null,
                  'claim_type': "",
                  'hours' : null,
                  'unit_price': null,
                  'gst_code': null,
              }
          );
      },
      removeService(pos) {
          let service = [];
          this.form.service.forEach(function (item,index){
              if(pos != index){
                  service.push(item);
              }
          });
          this.form.service = service;

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
                  var data = res.data.data.map(function (obj) {
                      return obj.support_item_number;
                  });
                  this.servicesItemsResult= data;
              })
              .catch(error => {
                  this.$toastr.e("Error", "Some thing went wrong.")
              })
              .finally(() => {
                  this.loader = false
              });
      },
      closePopup() {
          this.resetForm();
          $("#invoicePopup").modal('hide');
      }
  }
}
</script>
