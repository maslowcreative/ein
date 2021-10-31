<template>
    <!--Claim Popup-->
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
    <!--Claim End-->
</template>

<script>
import CreateInvoicePopup from "./CreateInvoicePopup";
export default {
    components: {CreateInvoicePopup},
    data() {
    return {}
  },
  mounted() {},
}
</script>
