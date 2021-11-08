<template>
    <div class="modal" id="claimDetailPopup" tabindex="-1" aria-labelledby="claimDetailPopupTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" >
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="claimDetailPopupTitle">Claim #{{claim.claim_reference}}</h4>
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
                                            <div class="me-3"><img src="/images/avatar.png" width="40" alt=""></div>
                                            <div class="participant-name">
                                                <h6>{{claim.provider.user.name}}</h6> <span class="text-primary">Provider</span>
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
                                                <h6>{{claim.participant.user.name}}</h6> <span class="text-primary">Participant</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <h5 class="border-bottom pb-3 mb-3">Service Cost</h5>
                            <div class="cost-div" v-for="(item, index) in claim.items">
                                <div class="my-4">
                                    <span class="badge bg-primary py-2 px-4">Service #{{index+1}}</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Claim Type</label>
                                            <select disabled class="form-select" :value="item.claim_type" >
                                                <option value="">Standard Service Charges</option>
                                                <option value="CANC">Cancellation Charges</option>
                                                <option value="REPW">Report Writing Charges</option>
                                                <option value="TRAN">Travel Charges</option>
                                                <option value="NF2F">Non-Face to Face Services</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label class="form-label">Item Number</label>
                                            <input disabled type="text" :value="item.support_item_number" class="form-control" placeholder="134134134134">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-sm-8">
                                                <div class="mb-4">
                                                    <label class="form-label">Service Length (1h = 1)</label>
                                                    <input disabled type="text" class="form-control" :value="item.hours" placeholder="0.5">
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mb-4">
                                                    <label class="form-label">Cost</label>
                                                    <input disabled type="text" :value="item.unit_price" class="form-control" placeholder="$100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row g-3">
                                            <div class="col-sm-8">
                                                <div class="mb-4">
                                                    <label class="form-label">Tax Rate</label>
                                                    <select class="form-select" disabled="" :value="item.gst_code">
                                                        <option value="P1">Tax Claimable (10%)</option>
                                                        <option value="P2">GST Free</option>
                                                        <option value="P3">GST out of Scope</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="mb-4">
                                                    <label class="form-label">Total</label>
                                                    <input disabled type="text" :value="item.hours * item.unit_price" class="form-control" placeholder="$100">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CreateInvoicePopup from "./CreateInvoicePopup";
export default {
    components: {CreateInvoicePopup},
    props: ['claim'],
    data() {
    return {
        //claimData: this.claim
    }
  },
  mounted() {},
}
</script>
