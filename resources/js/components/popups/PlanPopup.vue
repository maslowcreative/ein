<template>
    <div class="modal fade" id="editPlanModal" tabindex="-1" data-bs-backdrop="static"
         aria-labelledby="editPlanModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPlanModalTitle">Edit Plan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="ndisPlanFile" class="form-label fw-bold">NDIS Plan  </label>

                                <a v-if="plan.file_name" class="btn btn-link p-0 mx-1" :href="this.laroute.route('plan.file.download',{'file_name':plan.file_name })">
                                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                </a>
                                <input
                                    type="file"
                                    class="form-control"
                                    id="ndisPlanFile"
                                    placeholder="Plan File"
                                    v-on:change="onFileChange"
                                    accept="application/pdf"
                                />
                                <div
                                    class="invalid-msg"
                                    v-if="form.errors.has('file_name')"
                                    v-html="form.errors.get('file_name')"
                                />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="enablePlan" class="form-label fw-bold">Edit Plan</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" v-model ="plan.status" id="enablePlan">
                                    <label class="form-check-label" for="enablePlan"></label>
                                    <div class="invalid-msg" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label  class="form-label fw-bold">Start Date</label>
                                <input type="date" class="form-control" v-model = "plan.start_date" placeholder="01/01/2021">
                                <div class="invalid-msg" v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label  class="form-label fw-bold">End Date</label>
                                <input type="date" class="form-control" v-model = "plan.end_date"   placeholder="01/01/2021">
                                <div class="invalid-msg" v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label  class="form-label">Types of Charges</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="plan.charges_types"
                                    placeholder="REPW, TRAN"
                                />
                                <div
                                    class="invalid-msg"
                                    v-if="form.errors.has('charges_types')"
                                    v-html="form.errors.get('charges_types')"
                                />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <label  class="form-label">Plan’s Budget</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="plan.budget"
                                    placeholder="$180,000"
                                />
                                <div
                                    class="invalid-msg"
                                    v-if="form.errors.has('budget')"
                                    v-html="form.errors.get('budget')"
                                />
                            </div>
                        </div>

                        <div class="mw290 mx-auto px-4 mt-3">
                            <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updatePlan(plan.id)">Update Plan</button>
                            <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Form from "vform";

export default {
    props: ['plan'],
    data() {
        return {
           loader : false,
           form : new Form({
               file_name : null,
               start_date: this.plan.start_date,
               end_date: null,
               status: null,
               charges_types: null,
               budget: null,
           })
        }
    },
    mounted() {

    },
    methods:{
        updatePlan(planId) {
            this.form.file_name = this.plan.file_name;
            this.form.start_date = this.plan.start_date;
            this.form.end_date = this.plan.end_date;
            this.form.status = this.plan.status;
            this.form.charges_types = this.plan.charges_types;
            this.form.budget = this.plan.budget;
            this.loader = true;
            let route = this.laroute.route("ajax.plans.update",{plan:planId })
            this.form
                .put(route)
                .then(res => {
                    if ((res.status = 200)) {
                        this.$toastr.s("Success", "Record Updated!")
                    }
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                })
                .finally(() => {
                    this.loader = false
                })
        },
        onFileChange(e) {
            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;

            let route = this.laroute.route("ajax.plans.upload");
            let  form = new Form({
                'file':files[0]
            });
            this.loader = true;
            form
                .post(route)
                .then(res => {
                    this.plan.file_name = res.data.file_name;
                    this.loader = false;
                })
                .catch(error => {
                    this.form.file_name = null;
                    this.$toastr.e("Error", "Some thing went wrong while file upload.");
                    this.loader = false;
                })
                .finally(() => {
                    this.loader = false;
                });
        }
    }
}
</script>
