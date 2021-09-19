<template>
    <div class="modal fade" id="editPlanModal" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="editPlanModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPlanModalTitle">Create a new Sub-admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="NDISPlan" class="form-label fw-bold">NDIS Plan</label>
                                <input type="text" class="form-control" id="NDISPlan" placeholder="NDIS Plan Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enablePlan" class="form-label fw-bold">Edit Plan</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="enablePlan">
                                    <label class="form-check-label" for="enablePlan"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enterPassword" class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control" id="enterPassword" placeholder="01/01/2021">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enterPassword2" class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control" id="enterPassword2" placeholder="01/01/2021">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center text-primary">
                                <ion-icon name="checkmark"></ion-icon> User Plan Updated!
                            </div>
                        </div>
                        <div class="mw290 mx-auto px-4 mt-3">
                            <button class="btn btn-primary btn-lg w-100 py-3">Update Plan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        export default {
            data() {
                return {

                }
            },
            mounted() {

            }
        }
    </script>
</template>
