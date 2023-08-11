<template>
    <div class="modal" id="adminRepReceiptPopup" tabindex="-1" aria-labelledby="invoicePopupTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content invoicePopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="invoicePopupTitle">Submit New Receipts</h4>
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
                    <form @submit.prevent="createClaim" method="POST"  enctype="multipart/form-data">
                        <div class="step1" v-show="step === 1">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" placeholder="DD/MM/YYYY" v-model="form.start_date" :max="maxDate" class="form-control" >
                                        <div class="invalid-msg" v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">End Date</label>
                                        <input type="date" v-model="form.end_date" class="form-control" :max="maxDate" placeholder="" value="DD/MM/YYYY">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <div class="dropdownWrap">
                                            <label  class="form-label">Link a Participant</label>
                                            <input
                                                type="text"
                                                class="form-control"

                                                placeholder="Participant’s Name"
                                                v-model="participantSerachName"
                                                autocomplete="off"
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
                                                    <div class="me-3"><img :src="participant.avatar_url" width="40" alt="" /></div>
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
                                                <div class="me-3"><img :src="participantSelected.avatar_url" width="40" alt="" /></div>
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
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <div class="dropdownWrap">
                                            <label  class="form-label">Link a Provider</label>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Provider’s Name"
                                                v-model="providerSerachName"
                                                autocomplete="off"
                                            />
                                            <div
                                                v-if="providerSerachResult.length > 0"
                                                class="dropdownSec scroll-y"
                                                style="--box-height:154px"
                                            >
                                                <div
                                                    class="bg-light d-flex align-items-center p-3 participant-card"
                                                    v-for="provider in providerSerachResult"
                                                    :key="provider.id"
                                                    v-on:click="selectItem(provider.id, 'provider')"
                                                >
                                                    <div class="me-3"><img :src="provider.avatar_url" width="40" alt="" /></div>
                                                    <div class="participant-name">
                                                        <h6>{{ provider.show_name }}</h6>
                                                        <span class="text-primary">Provider</span>
                                                    </div>
                                                    <div class="ms-auto">
                                                        <button
                                                            class="btn btn-link p-0 participant-remove"
                                                            v-on:click="removeItem(provider.id, 'provider')"
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
                                                v-if="providerSelected"
                                            >
                                                <div class="me-3"><img :src="providerSelected.avatar_url" width="40" alt="" /></div>
                                                <div class="participant-name">
                                                    <h6>{{ providerSelected.show_name }}</h6>
                                                    <span class="text-primary">Provider</span>
                                                </div>
                                                <div class="ms-auto">
                                                    <button
                                                        class="btn btn-link p-0 participant-remove"
                                                        v-on:click="removeItem(providerSelected.id, 'provider')"
                                                    >
                                                        <ion-icon name="remove-circle-outline"></ion-icon>
                                                    </button>
                                                </div>
                                            </div>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('provider_id')"
                                                v-html="form.errors.get('provider_id')"
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
                                                @input="itemNumberSelected"
                                                @search-change="asyncFindItemNumber"
                                            >
                                            </multiselect>
                                            <span v-if="service.item_name">
                                                {{service.item_name}}
                                            </span>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('service.'+index+'.item_number')"
                                                v-html="form.errors.get('service.'+index+'.item_number').replace('service.'+index+'.item_number','item number')"
                                            />
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label">Claim Type</label>
                                            <select class="form-select" v-model="service.claim_type"  v-on:change="processCANC(service)">
                                                <option value="">N/A</option>
                                                <option value="F2F">Face-To-Face</option>
                                                <option value="CANC">Cancellation Charges</option>
                                                <option value="REPW">Report Writing Charges</option>
                                                <option value="TRAN">Travel Charges</option>
                                                <option value="NF2F">Non-Face to Face Services</option>
                                                <option value="THLT">Telehealth</option>
                                                <option value="IRSS">Irregular SIL Supports</option>
                                            </select>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('service.'+index+'.claim_type')"
                                                v-html="form.errors.get('service.'+index+'.claim_type').replace('service.'+index+'.claim_type','claim type')"
                                            />
                                        </div>

                                        <div v-if="service.claim_type == 'CANC'" class="mb-4">
                                            <label class="form-label">Cancellation Reason</label>
                                            <select class="form-select" v-model="service.cancellation_reason">
                                                <option value="NSDH">No show due to health reason.</option>
                                                <option value="NSDF">No show due to family issues.</option>
                                                <option value="NSDT">No show due to unavailability of transport.</option>
                                                <option value="NSDO">Other.</option>
                                            </select>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('service.'+index+'.cancellation_reason')"
                                                v-html="form.errors.get('service.'+index+'.cancellation_reason').replace('service.'+index+'.cancellation_reason','cancellation reason')"
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
                                                        <label class="form-label">Units (30 mins = 0.5)</label>
                                                        <input type="text" v-model="service.hours"  class="form-control" placeholder="Enter Amount">
                                                        <div
                                                            class="invalid-msg"
                                                            v-if="form.errors.has('service.'+index+'.hours')"
                                                            v-html="form.errors.get('service.'+index+'.hours').replace('service.'+index+'.hours','hours')"
                                                        />
                                                    </div>

                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-4">
                                                        <label class="form-label">Unit Price</label>
                                                        <input type="text" v-model="service.unit_price" class="form-control" placeholder="$">
                                                        <div
                                                            class="invalid-msg"
                                                            v-if="form.errors.has('service.'+index+'.unit_price')"
                                                            v-html="form.errors.get('service.'+index+'.unit_price').replace('service.'+index+'.unit_price','unit price')"
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
                                                            v-html="form.errors.get('service.'+index+'.gst_code').replace('service.'+index+'.gst_code','gst code')"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-4">
                                                        <label class="form-label">Total</label>
                                                        <input type="text"  disabled class="form-control" :value="Math.round((service.hours * service.unit_price + Number.EPSILON) * 100) / 100" placeholder="$">
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
                            <div v-if="form.service.length > 0" class="pt-4 mt-4 border-top" style="text-align: center">
                                <span  class="w-100 py-3 "><span class="form-label">Total Cost :</span> ${{totalCost}} </span>
                            </div>
                            <div class="pt-4 mt-4 border-top">
                                <button type="button" class="btn btn-light btn-lg w-100 py-3" v-on:click="addService()">+ Add New Service</button>
                            </div>
                        </div>
                        <div class="step3" v-show="step === 3">
                            <div class="mb-4">
                                <label class="form-label">Upload Invoice</label>
                                <div class="input-group">
                                    <input type="file" ref="inputFile" v-on:change="onFileChange" class="form-control" placeholder="Invoice file name"
                                           aria-label="Invoice file name" aria-describedby="fileBtn">
                                    <div class="invalid-msg" v-if="form.errors.has('file')" v-html="form.errors.get('file')" />
                                </div>
                            </div>
                        </div>
                        <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                            <button v-if="!lastStep && !loader" class="btn btn-primary btn-lg w-100 py-3 mb-3" @click.prevent="next()">
                                Next
                            </button>
                            <button
                                v-else-if="!lastStep && loader"
                                class="btn btn-primary btn-lg w-100 py-3 mb-3"
                                type="button"
                                disabled
                            >
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Wait...
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
        maxDate : null,
        step: 1,
        lastStep: false,
        totalCost: 0,
        form: new Form({
            'start_date': null,
            'end_date': null,
            'invoice_number': null,
            'participant_id': null,
            'provider_id': null,
            'file': {},
            'service': [
                {
                    'item_number': null,
                    'claim_type': " ",
                    'hours' : null,
                    'unit_price': null,
                    'gst_code': 'P2',
                    'cancellation_reason': null,
                    'item_name': null,
                }
            ]
        }),
        participantSerachName: null,
        participantSerachResult: [],
        participantSelected: null,
        providerSerachName: null,
        providerSerachResult: [],
        providerSelected: null,
        servicesItemsResult: [],
        servicesItemsOrginal : []

    }
  },
  watch: {
      step(val, old) {
          if (val == 3) {
              this.lastStep = true
          } else {
              this.lastStep = false
          }

          if(val == 2){
              this.asyncFindItemNumber('');
          }
      },
      participantSerachName(val, old) {
          if (val) {
              this.asyncFind(val, "participant");
          } else {
              this.participantSerachResult = [];
          }
      },
      providerSerachName(val,old) {
          if (val) {
              this.asyncFind(val, "provider");
          } else {
              this.providerSerachResult = [];
          }
      },
      "form.service": {
          handler: function (val, old) {
              let totalCost = 0;
              if (val.length > 0) {
                  val.forEach(function (service) {
                      let cost = Math.round((service.hours * service.unit_price + Number.EPSILON) * 100) / 100;
                      totalCost = Math.round((totalCost + cost) * 100) / 100;
                  });
              } else {
                  totalCost = 0;
              }

              this.totalCost = Math.round((totalCost) * 100) / 100;
          },
          deep: true
      }
  },
  mounted() {
      this.$root.$on('ein-representative:create-invoice-popup', () => {
          this.form.reset();
          this.resetForm();
          this.$refs.inputFile.value=null;

          let today = new Date();
          var month = this.pad2(today.getMonth()+1);//months (0-11)
          var day = this.pad2(today.getDate());//day (1-31)
          var year= today.getFullYear();

          var formattedDate =  year+"-"+month+"-"+day;
          this.maxDate = formattedDate;
      });

      this.$root.$on('ein-provider:participant-selected-to-invoice', (participant) => {
          this.participantSelected = participant;
          this.form.participant_id = participant.id;
      });
  },
  methods: {
      pad2(n) {
          return (n < 10 ? '0' : '') + n;
      },
      current(value) {
          this.step = value;
      },
      prev() {
          this.step--;
      },
      next() {
          if (this.step < 3) {
              if(this.step == 1 || this.step == 2){

                  this.loader = true;
                  let route = this.laroute.route("ajax.claims.store.admin");
                  this.form.is_admin = true;
                  this.form.action_role = 'representative';
                  this.form
                      .post(route)
                      .then(res => {
                          if ((res.status = 201)) {

                          }
                      })
                      .catch(error => {

                      })
                      .finally(() => {

                          let servcieError = false;
                          Object.keys(this.form.errors.errors).filter(item =>  {
                              if(item.split('.') [0] == 'service'){
                                  servcieError = true;
                              }
                          });

                          if(this.step == 1 && (this.form.errors.has('start_date') || this.form.errors.has('end_date') || this.form.errors.has('invoice_number') ||   this.form.errors.has('participant_id') || this.form.errors.has('provider_id')))
                          {
                              Object.keys(this.form.errors.errors).filter(item =>  {
                                  if( !(
                                      item == 'start_date' ||
                                      item == 'end_date' ||
                                      item == 'invoice_number' ||
                                      item == 'participant_id' ||
                                      item == 'provider_id'
                                  )
                                  ){
                                      this.form.errors.clear(item);
                                  }
                              });

                              this.step = 1;

                          }
                          else if(this.step == 2 && (this.form.errors.has('start_date') || this.form.errors.has('end_date') || this.form.errors.has('invoice_number') ||   this.form.errors.has('participant_id') || this.form.errors.has('provider_id')))
                          {
                              console.log('Case2');

                              Object.keys(this.form.errors.errors).filter(item =>  {
                                  if( !(
                                      item == 'start_date' ||
                                      item == 'end_date' ||
                                      item == 'invoice_number' ||
                                      item == 'participant_id' ||
                                      item == 'provider_id'
                                  )
                                  ){
                                      this.form.errors.clear(item);
                                  }
                              });

                              this.step = 1;

                          }else if(this.step == 2 && servcieError)
                          {
                              this.form.errors.clear('file');
                              this.step = 2;
                          }
                          else {
                              console.log('Case3');
                              Object.keys(this.form.errors.errors).filter(item =>  {
                                   this.form.errors.clear(item);
                              });
                              this.step ++;
                          }

                          this.loader = false;
                      });
              }


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

          if ($role === "provider") {
              let provider = this.providerSerachResult.filter(provider => provider.id == id);
              this.providerSelected = provider[0];
              this.form.provider_id = this.providerSelected.id;
              this.providerSerachName = null;
              this.providerSerachResult = [];
          }
      },
      removeItem(id, $key) {
          if ($key === "participant") {
              this.participantSelected = null;
              this.form.participant_id = null;
          }
          if($key === "provider")
          {
              this.providerSelected = null;
              this.form.provider_id = null;
          }
      },
      resetForm(){
          this.loader = false;
          this.step= 1;
          this.lastStep= false;
          this.totalCost = 0 ;
          this.$refs.inputFile.value=null;
          this.form = new Form({
              'start_date': null,
              'end_date': null,
              'invoice_number': null,
              'participant_id': null,
              'provider_id': null,
              'file': null,
              'service': [
                  {
                      'item_number': null,
                      'claim_type': "",
                      'hours' : null,
                      'unit_price': null,
                      'gst_code': 'P2',
                      'cancellation_reason': null,
                      'item_name': null,
                  }
              ]
          });
          this.participantSerachName= null;
          this.participantSerachResult= [];
          this.participantSelected= null;
          this.servicesItemsResult= [];
          this.providerSerachName = null;
          this.providerSerachResult =[];
          this.providerSelected = null;
          this.servicesItemsOrginal = [];
      },
      createClaim() {
          this.loader = true;
          let route = this.laroute.route("ajax.claims.store.admin");
          this.form.is_admin = true;
          this.form.action_role = 'representative';
          console.log(this.form.data());
          this.form
              .post(route)
              .then(res => {
                  console.log('res',res);
                  if ((res.status = 201)) {
                      this.$root.$emit("ein-claim:created");
                      this.$toastr.s("Success", "Claim created!");
                      this.closePopup();
                  }
              })
              .catch(error => {
                  let servcieError = false;
                  Object.keys(this.form.errors.errors).filter(item =>  {
                      if(item.split('.') [0] == 'service'){
                          servcieError = true;
                      }
                  });

                  if(error.response.status == 400){
                      this.$toastr.e("Error", error.response.data.error);
                      servcieError = true;
                  }else {
                      this.$toastr.e("Error", "Some thing went wrong.");
                  }

                  if(this.form.errors.has('start_date') || this.form.errors.has('end_date') || this.form.errors.has('invoice_number') ||   this.form.errors.has('participant_id') || this.form.errors.has('provider_id'))
                  {
                      this.step = 1;
                  }else if(servcieError){
                      this.step = 2;
                  }else {
                      this.step = 3;
                  }
              })
              .finally(() => {
                  this.loader = false
              });

      },
      itemNumberSelected(query){
          let service = [];
          let servicesItemsOrginal = [];
          servicesItemsOrginal = this.servicesItemsOrginal;
          this.form.service.forEach(function (item,index){
              let cat = servicesItemsOrginal.filter(function (v){
                  return v.support_item_number == item.item_number;
              });
              if(cat.length > 0){
                  item.item_name = cat[0].support_item_name;
              }else {
                  item.item_name = null;
              }
          });
      },
      asyncFind(query, type = "participant") {
          this.loader = true;
          let data = {
              "filter[name]": query,
              "filter[roles][0]": type,
              "is_admin_claim": true,
              "participant_id" : this.participantSelected ? this.participantSelected.id : null,
              "provider_id" : this.providerSelected ? this.providerSelected.id : null
          };

          let route = this.laroute.route("ajax.users.index", data)
          axios
              .get(route)
              .then(res => {
                  if(type == "participant") {
                      this.participantSerachResult = res.data.data;
                  }
                  if(type == "provider") {
                      this.providerSerachResult = res.data.data;
                  }
              })
              .catch(error => {
                  this.$toastr.e("Error", "Some thing went wrong.")
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
                  'cancellation_reason': null,
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
              'participant_id': this.form.participant_id,
              'provider_id' : this.form.provider_id,
              'is_admin' : true
          }

          let route = this.laroute.route("ajax.services.index", data)
          axios
              .get(route)
              .then(res => {
                  var data = res.data.data.map(function (obj) {
                      return obj.support_item_number;
                  });
                  this.servicesItemsResult= data;
                  this.servicesItemsOrginal =  res.data.data;
              })
              .catch(error => {
                  if(error.response.status == 422){
                      this.$toastr.e("Error", "Please select participant & provider first.");
                  }else {
                      this.$toastr.e("Error", "Some thing went wrong.");
                  }

              })
              .finally(() => {
                  this.loader = false
              });
      },
      closePopup() {
          this.resetForm();
          $("#adminRepReceiptPopup").modal('hide');
      },

      onFileChange(e) {
          var files = e.target.files || e.dataTransfer.files;
          if (!files.length)
              return;
          this.form.file = files[0];
      },
      processCANC(service) {
          if(service.claim_type != 'CANC') {
             service.cancellation_reason = null;
          }
      }

  }
}
</script>
