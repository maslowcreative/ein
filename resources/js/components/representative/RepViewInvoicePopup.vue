<template>
    <!--Claim Popup-->
    <div class="modal" id="claimPopup" tabindex="-1" aria-labelledby="claimPopupTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="claimPopupTitle">Claim #{{claim.claim_reference}}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body addUser">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Amount Invoiced</label>
                                <input type="text" disabled class="form-control" placeholder="" :value="'$'+claim.total">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-primary form-label">Amount Paid</label>
                                <input type="text" disabled class="form-control text-primary" placeholder="" :value="'$'+claim.paid">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Claim End-->
</template>

<script>
export default {
    props: ['claim'],
    data() {
    return {}
  },
  mounted() {},
}
</script>
