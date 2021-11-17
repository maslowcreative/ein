<template>
    <div
        class="modal fade"
        id="userEditProviderModal"
        tabindex="-1"
        data-bs-backdrop="static"
        aria-labelledby="adminModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="adminModalTitle">Edit Provider Profile</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="editUser" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Full Name</label>
                                    <input type="text"  class="form-control"  placeholder="The Name of the Provider" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">ABN</label>
                                    <input type="text"  class="form-control"  placeholder="00000000000000000000" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Home Address</label>
                                    <textarea
                                        cols="30"
                                        rows="2"
                                        class="form-control"
                                       placeholder="Home Address 13, 10000 State, Country."
                                    ></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Phone Number</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="0000000000"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">E-mail Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="providersemail@gmail.com"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Participants</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Specific Item Numbers</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                    />
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="mw290 mx-auto px-4 mt-3">
                        <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3" >Update Information</button>
                        <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
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
import Form from "vform"
export default {
    data() {
        return {
            loader: false,
        }
    },
    mounted() {},
    methods: {
    },
}
</script>
