<template>
    <div class="modal" id="claimDetailPopup" tabindex="-1" aria-labelledby="claimDetailPopupTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"  >
            <div class="modal-content addUserPopup" v-if="claim">
                <div class="modal-header">
                    <h4 class="modal-title" id="claimDetailPopupTitle">Claim #{{claim.items[0] ? claim.items[0].claim_reference : ''}}</h4>
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
                                        <input disabled type="date" :value="claim.start_date" class="form-control" placeholder="01/01/2021">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-12">
                                    <div class="mb-4">
                                        <label class="form-label">End Date</label>
                                        <input type="date" disabled :value="claim.end_date"  class="form-control" placeholder="01/01/2021">
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-12">
                                    <div class="mb-4">
                                        <label class="form-label">Provider</label>
                                        <div class="bg-light d-flex align-items-center p-3 participant-card">
                                            <div class="me-3"><img :src="claim.provider.user.avatar_url" width="40" alt=""></div>
                                            <div class="participant-name">
<!--                                                <h6 v-if="role == 'admin' || role == 'sub-admin'">{{claim.provider.user.name}}</h6>-->
                                                <h6 >{{claim.provider.user.show_name}}</h6>
                                                <span class="text-primary">Provider</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-12">
                                    <div class="mb-4">
                                        <label class="form-label">Participant</label>
                                        <div class="bg-light d-flex align-items-center p-3 participant-card">
                                            <div class="me-3"><img :src="claim.participant.user.avatar_url" width="40" alt=""></div>
                                            <div class="participant-name">
                                                <h6>{{claim.participant.user.name}}</h6> <span class="text-primary">Participant</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <h5 class="border-bottom pb-3 mb-3">Service Cost</h5>
                            <div class="cost-div" >
                                <div class="my-4">
<!--                                    <span class="badge bg-primary py-2 px-4">Service #{{index+1}}</span>-->
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Claim Type</label>
                                            <select :disabled="isEditable"   class="form-select" v-model="form.claim_type" >
                                                <option value="" >N/A</option>
                                                <option value="F2F">Face-To-Face</option>
                                                <option value="CANC">Cancellation Charges</option>
                                                <option value="REPW">Report Writing Charges</option>
                                                <option value="TRAN">Travel Charges</option>
                                                <option value="NF2F">Non-Face to Face Services</option>
                                                <option value="THLT">Telehealth</option>
                                                <option value="IRSS">Irregular SIL Supports</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Item Number</label>
                                            <input disabled type="text" :value="form.item_number" class="form-control" placeholder="134134134134">
                                            <span >
                                                {{itemName}}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="form.claim_type == 'CANC'">
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <label class="form-label">Cancellation Reason</label>
                                            <select :disabled="isEditable" class="form-select" v-model="form.cancellation_reason">
                                                <option value="NSDH">No show due to health reason.</option>
                                                <option value="NSDF">No show due to family issues.</option>
                                                <option value="NSDT">No show due to unavailability of transport.</option>
                                                <option value="NSDO">Other.</option>
                                            </select>
                                            <div
                                                class="invalid-msg"
                                                v-if="form.errors.has('cancellation_reason')"
                                                v-html="form.errors.get('cancellation_reason')"
                                            />

                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-sm-8">
                                                <div class="mb-4">
                                                    <label class="form-label">Units (30 mins = 0.5)</label>
                                                    <input :disabled="isEditable"   type="text" class="form-control" v-model="form.hours" placeholder="0.5">
                                                    <div
                                                        class="invalid-msg"
                                                        v-if="form.errors.has('hours')"
                                                        v-html="form.errors.get('hours')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mb-4">
                                                    <label class="form-label">Cost</label>
                                                    <input  :disabled="isEditable"  type="text"  v-model="form.unit_price"  class="form-control" placeholder="$100">
                                                    <div
                                                        class="invalid-msg"
                                                        v-if="form.errors.has('unit_price')"
                                                        v-html="form.errors.get('unit_price')"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-sm-8">
                                                <div class="mb-4">
                                                    <label class="form-label">Tax Rate</label>
                                                    <select :disabled="isEditable"  class="form-select"  v-model="form.gst_code">
                                                        <option value="P1">Tax Claimable (10%)</option>
                                                        <option value="P2">GST Free</option>
                                                        <option value="P3">GST out of Scope</option>
                                                    </select>
                                                    <div
                                                        class="invalid-msg"
                                                        v-if="form.errors.has('gst_code')"
                                                        v-html="form.errors.get('gst_code')"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mb-4">
                                                    <label class="form-label">Total</label>
                                                    <input type="text"  disabled class="form-control" :value="Math.round((form.hours * form.unit_price + Number.EPSILON) * 100) / 100" placeholder="$">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" v-if="isStatusEditable">
                                    <div class="col-md-6" >
                                        <label class="form-label">Status</label>
                                        <select   class="form-select" v-model="form.status">
                                            <option value="0">Pending</option>
                                            <option value="1">Accepted</option>
                                            <option value="2">Rejected</option>
                                            <option value="3">Approved</option>
                                            <option value="4">Processed</option>
                                            <option value="5">Reconciled</option>
                                            <option value="6">Cancel</option>
                                        </select>
                                        <div
                                            class="invalid-msg"
                                            v-if="form.errors.has('status')"
                                            v-html="form.errors.get('status')"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <br>
                                        <button  v-if="!loader"  class="btn  btn-lg py-md-3 px-md-5 mx-2 btn-primary" v-on:click="updateClaim">Update Claim</button>
                                        <button
                                            v-else-if="loader"
                                            class="btn  btn-lg py-md-3 px-md-5 mx-2 btn-primary"
                                            disabled
                                        >
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>
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
                                    <input disabled type="text" placeholder="Invoice file" value="Invoice file"  aria-label="Invoice file"
                                           aria-describedby="fileBtn" class="form-control prepended-form-control">
                                    <div class="input-group-append-overlay">
                              <span class="input-group-text text-primary" v-if="claim.invoice_path">
                                <a type="button" id="fileBtn" :href="claim.invoice_url" class="btn btn-text p-0 fw-bold text-primary">View
                                  File</a>
                              </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div v-if="role == 'representative' && (claim.items[0] ? claim.items[0].can_changed : false)"  class="text-center mt-3 mt-md-5">
                        <button v-if="!loader" :class="{ 'btn-primary': claim.items[0].status == 2 , 'btn-light': claim.items[0].status != 2 }"  class="btn  btn-lg py-md-3 px-md-5 mx-2" v-on:click="claimRepresentativeAction((claim.items[0] ? claim.items[0].id : 0),2)">Reject Claim</button>
                        <button v-if="!loader" :class="{ 'btn-primary': claim.items[0].status == 1 , 'btn-light': claim.items[0].status != 1 }" class="btn btn-lg py-md-3 px-md-5 mx-2" v-on:click="claimRepresentativeAction((claim.items[0] ? claim.items[0].id : 0),1)">Accept Claim</button>
                        <button v-if="loader" class="btn btn-light btn-lg py-md-3 px-md-5 mx-2" disabled="" >
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CreateInvoicePopup from "./CreateInvoicePopup";
import Form from "vform";
export default {
    components: {CreateInvoicePopup},
    props: ['role'],
    data() {
    return {
        loader : false,
        isEditable : true,
        isStatusEditable : false,
        itemName : null,
        reason : null,
        claim : null,
        form: new Form({
            'item_number': null,
            'claim_type': "",
            'hours' : null,
            'unit_price': null,
            'gst_code': null,
            'cancellation_reason': null,
        }),
    }
  },
  mounted() {
      this.$root.$on("ein-admin:claim-detail-popup-open", (claim) => {
          this.claim = claim;

          let item = this.claim.items[0];
          this.isEditable = true;
          this.itemName = claim.service.support_item_name;
          this.isStatusEditable = false;
          switch(item.status) {
              case 0:
                  this.isEditable = false;
                  this.isStatusEditable = true;

                  break;
              case 1:
                  this.isEditable = false;
                  this.isStatusEditable = true;
                  break;
              case 2:
                  this.isEditable = false;
                  this.isStatusEditable = true;
                  break;
              case 3:
                  this.isEditable = false;
                  this.isStatusEditable = true;
                  break;

              case 4:
                  this.isEditable = true;
                  this.isStatusEditable = true;
                  break;
              case 5:
                  this.isEditable = true;
                  this.isStatusEditable = true;
                  break;
              case 6:
                  this.isEditable = false;
                  this.isStatusEditable = true;
                  break;
              default:
              // code block
          }

          item.hours = Math.round((item.hours + Number.EPSILON) * 100) / 100;
          item.unit_price = Math.round((item.unit_price + Number.EPSILON) * 100) / 100;
          item.amount_claimed = Math.round((item.amount_claimed + Number.EPSILON) * 100) / 100;

          this.form =  new Form({
              'id': item.id,
              'item_number': item.support_item_number,
              'claim_type': item.claim_type == null ? '' :  item.claim_type,
              'cancellation_reason': item.cancellation_reason,
              'hours' : item.hours,
              'unit_price': item.unit_price,
              'amount_claimed': item.amount_claimed,
              'gst_code': item.gst_code,
              'status': item.status,
          });

      });
  },
  methods:{
    claimRepresentativeAction(claimId ,status) {
        this.loader = true;
        let route = this.laroute.route("ajax.claims.representative.action",{'claim': claimId });
        axios
            .post(route,{'status': status,'reason': this.reason})
            .then(res => {
                this.$root.$emit("ein-claim:action");
                this.$toastr.s("Success", "Claim updated!");
                this.form.reset();
                this.isEditable = true;
                this.isStatusEditable =false;
                this.reason = null;
                this.claim = null;
                $("#claimDetailPopup").modal('hide');
            })
            .catch(error => {

                let err = error.response.data.error;
                if(err){
                    this.$toastr.e("Error", err);
                }else {
                    this.$toastr.e("Error", "Some thing went wrong.")
                }

            })
            .finally(() => {
                this.loader = false
            });


    },
    updateClaim(){
        this.loader = true;
        let route = this.laroute.route("ajax.claims.update");
        this.form
            .post(route)
            .then(res => {
                this.$root.$emit("ein-admin:claim-updated");
                this.$toastr.s("Success", "Claims updated.");
                $("#claimDetailPopup").modal('hide');

            })
            .catch(error => {
                let err = error.response.data.error;
                if(err){
                    this.$toastr.e("Error", err);
                }else {
                    this.$toastr.e("Error", "Some thing went wrong.")
                }
            })
            .finally(() => {
                this.loader = false;
            });

    }
  }
}
</script>
