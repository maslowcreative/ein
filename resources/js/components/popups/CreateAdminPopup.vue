<template>
    <div class="modal fade" id="adminModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="adminModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="adminModalTitle">Create a new Sub-admin</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="fullName" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="fullName" placeholder="Admin Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="emailAddress" class="form-label">E-mail Address</label>
                                <input type="email" class="form-control" id="emailAddress" placeholder="adminsemail@ein.net.au">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enterPassword" class="form-label">Enter Password</label>
                                <input type="password" class="form-control" id="enterPassword" placeholder="*********************">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enterPassword2" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="enterPassword2" placeholder="*********************">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="fw-bold">Edit Provider Profiles</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOption1" checked>
                                    <label class="form-check-label" for="editOption1"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="fw-bold">Edit Participants Profiles</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOption2" checked>
                                    <label class="form-check-label" for="editOption2"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="fw-bold">Edit Representatives Profiles</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOption3" checked>
                                    <label class="form-check-label" for="editOption3"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="fw-bold">Approving Claims</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOption4" checked>
                                    <label class="form-check-label" for="editOption4"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <label class="fw-bold">Export / Import Documents</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="editOption5" checked>
                                    <label class="form-check-label" for="editOption5"></label>
                                </div>
                            </div>
                        </div>
                        <div class="mw290 mx-auto px-4 mt-3">
                            <button class="btn btn-primary btn-lg w-100 py-3">Create Sub-admin</button>
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
        return {

        }
    },
    mounted() {

    }
}
</script>
