<template>
  <div
    class="modal fade"
    id="editPlanModal"
    tabindex="-1"
    data-bs-backdrop="static"
    aria-labelledby="editPlanModalTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div class="modal-header">
          <h4 class="modal-title" id="editPlanModalTitle" v-if="user">{{user.name}}: Edit Plan</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div v-if="plan" class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-4">
                <label for="ndisPlanFile" class="form-label fw-bold">NDIS Plan </label>

                <a
                  v-if="plan.file_name"
                  class="btn btn-link p-0 mx-1"
                  :href="this.laroute.route('plan.file.download', { file_name: plan.file_name })"
                >
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
                <div class="invalid-msg" v-if="form.errors.has('file_name')" v-html="form.errors.get('file_name')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label for="enablePlan" class="form-label fw-bold">Edit Plan</label>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" v-model="plan.status" id="enablePlan" />
                  <label class="form-check-label" for="enablePlan"></label>
                  <div class="invalid-msg" v-if="form.errors.has('status')" v-html="form.errors.get('status')" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label class="form-label fw-bold">Start Date</label>
                <input type="date" class="form-control" v-model="plan.start_date" placeholder="01/01/2021" />
                <div class="invalid-msg" v-if="form.errors.has('start_date')" v-html="form.errors.get('start_date')" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-4">
                <label class="form-label fw-bold">End Date</label>
                <input type="date" class="form-control" v-model="plan.end_date" placeholder="01/01/2021" />
                <div class="invalid-msg" v-if="form.errors.has('end_date')" v-html="form.errors.get('end_date')" />
              </div>
            </div>

            <!-- <div class="col-md-6">
              <div class="mb-4">
                <label class="form-label">Types of Charges</label>
                <input type="text" class="form-control" v-model="plan.charges_types" placeholder="REPW, TRAN" />
                <div
                  class="invalid-msg"
                  v-if="form.errors.has('charges_types')"
                  v-html="form.errors.get('charges_types')"
                />
              </div>
            </div> -->

            <div class="col-md-6">
              <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                  <label class="form-label">User’s Budget</label>
                  <a
                    class="fs-sm mb-2"
                    data-bs-toggle="collapse"
                    href="#editBudgetOption"
                    role="button"
                    aria-expanded="false"
                    aria-controls="editBudgetOption"
                    >More Options</a
                  >
                </div>
                <input type="text" class="form-control" disabled v-model="form.budget" @change="bugdetChange" placeholder="$180,000" />
                <div class="invalid-msg" v-if="form.errors.has('budget')" v-html="form.errors.get('budget')" />
              </div>
            </div>
          </div>
          <div id="editBudgetOption" class="col-md-12 collapse">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Assistance with Daily Life</label>
                            <input type="text" v-model="form.budgets.cat_1" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Transport</label>
                            <input type="text"  v-model="form.budgets.cat_2" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Consumables</label>
                            <input type="text"  v-model="form.budgets.cat_3" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Assistance with Social</label>
                            <input type="text"  v-model="form.budgets.cat_4" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Assistive Technology</label>
                            <input type="text"  v-model="form.budgets.cat_5" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Home Modifications</label>
                            <input type="text"  v-model="form.budgets.cat_6" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Support Coordination</label>
                            <input type="text" v-model="form.budgets.cat_7" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Living Arrangements</label>
                            <input type="text"  v-model="form.budgets.cat_8" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Increased Social</label>
                            <input type="text" v-model="form.budgets.cat_9" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Finding and Keeping a Job</label>
                            <input type="text"  v-model="form.budgets.cat_10" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Relationships</label>
                            <input type="text"  v-model="form.budgets.cat_11" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Health and Wellbeing</label>
                            <input type="text"  v-model="form.budgets.cat_12" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Learning</label>
                            <input type="text"  v-model="form.budgets.cat_13" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Life Choices</label>
                            <input type="text"  v-model="form.budgets.cat_14" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Improved Daily Living Skills</label>
                            <input type="text"  v-model="form.budgets.cat_15" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
          <div class="mw290 mx-auto px-4 mt-3">
            <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updatePlan(plan.id)">
              Update Plan
            </button>
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
      user: null,
      plan: null,
      form: new Form({
        file_name: null,
        start_date: null,
        end_date: null,
        status: null,
        charges_types: null,
        budget: 0,
        budgets: {
          cat_1 : 0,
          cat_2 : 0,
          cat_3 : 0,
          cat_4 : 0,
          cat_5 : 0,
          cat_6 : 0,
          cat_7 : 0,
          cat_8 : 0,
          cat_9 : 0,
          cat_10 : 0,
          cat_11 : 0,
          cat_12 : 0,
          cat_13 : 0,
          cat_14 : 0,
          cat_15 : 0,
          total: 0,
        },
      }),
    }
  },
  mounted() {
      this.$root.$on("ein:participant-plan-edit-popup-open", (data) => {

          this.plan = data.plan;
          this.form = data.form;
          this.user = data.user;
          // this.form.file_name = this.plan.name;
          // this.form.start_date = this.plan.start_date;
          // this.form.end_date = this.plan.end_date;
          // this.form.status = this.plan.status;
          // this.form.status = this.plan.status;
          // this.form.budget = 0;
          //
          // this.form.budgets = {
          //     cat_1 : 0,
          //     cat_2 : 0,
          //     cat_3 : 0,
          //     cat_4 : 0,
          //     cat_5 : 0,
          //     cat_6 : 0,
          //     cat_7 : 0,
          //     cat_8 : 0,
          //     cat_9 : 0,
          //     cat_10 : 0,
          //     cat_11 : 0,
          //     cat_12 : 0,
          //     cat_13 : 0,
          //     cat_14 : 0,
          //     cat_15 : 0,
          // };
          //
          // this.plan.budgets.forEach((item, index) => {
          //     let cat = 'cat_'+ item.category_id;
          //     this.form.budgets[cat] = item.amount;
          // });
          // this.form.budget = this.plan.budget;
      });
  },
  watch:{
        "form.budgets.cat_1": function (val,old){
            this.form.budget =
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_2": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_3": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_4": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_5": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_6": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_7": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_8": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_9": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_10": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_11": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_12": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_13": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_14": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(val)
                + this.parseFloatValue(this.form.budgets.cat_15);
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
        "form.budgets.cat_15": function (val,old){
            this.form.budget =
                this.parseFloatValue(this.form.budgets.cat_1)
                + this.parseFloatValue(this.form.budgets.cat_2)
                + this.parseFloatValue(this.form.budgets.cat_3)
                + this.parseFloatValue(this.form.budgets.cat_4)
                + this.parseFloatValue(this.form.budgets.cat_5)
                + this.parseFloatValue(this.form.budgets.cat_6)
                + this.parseFloatValue(this.form.budgets.cat_7)
                + this.parseFloatValue(this.form.budgets.cat_8)
                + this.parseFloatValue(this.form.budgets.cat_9)
                + this.parseFloatValue(this.form.budgets.cat_10)
                + this.parseFloatValue(this.form.budgets.cat_11)
                + this.parseFloatValue(this.form.budgets.cat_12)
                + this.parseFloatValue(this.form.budgets.cat_13)
                + this.parseFloatValue(this.form.budgets.cat_14)
                + this.parseFloatValue(val)
            ;
            this.form.budget = Math.round((this.form.budget + Number.EPSILON) * 100) / 100;
        },
    },
  methods: {
    updatePlan(planId) {
      this.form.file_name = this.plan.file_name
      this.form.start_date = this.plan.start_date
      this.form.end_date = this.plan.end_date
      this.form.status = this.plan.status
      this.form.charges_types = this.plan.charges_types
      this.plan.budget = this.form.budget;
      this.loader = true
      let route = this.laroute.route("ajax.plans.update", { plan: planId })
      this.form
        .put(route)
        .then(res => {
          if ((res.status = 200)) {
            this.$toastr.s("Success", "Record Updated!");
          }
        })
        .catch(error => {
            this.$toastr.e("Error", error.response.data.error);
        })
        .finally(() => {
          this.loader = false
        })
    },
    onFileChange(e) {
      var files = e.target.files || e.dataTransfer.files
      if (!files.length) return

      let route = this.laroute.route("ajax.plans.upload")
      let form = new Form({
        file: files[0],
      })
      this.loader = true
      form
        .post(route)
        .then(res => {
          this.plan.file_name = res.data.file_name
          this.loader = false
        })
        .catch(error => {
          this.form.file_name = null;
          this.loader = false
        })
        .finally(() => {
          this.loader = false
        })
    },
    parseFloatValue(val){
      val = parseFloat(val);
      if(isNaN(val)){
          val = 0;
      }
      return val;
    },
    bugdetChange(){
        alert('ehllo');
    }
  },
}
</script>
