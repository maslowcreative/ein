<template>
    <div class="modal" id="invoicePopup" tabindex="-1" aria-labelledby="invoicePopupTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content invoicePopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="invoicePopupTitle">Submit New Invoice</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <div class="step1" v-show="step === 1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" placeholder="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" placeholder="" value="DD/MM/YYYY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Invoice Number</label>
                                    <input type="text" class="form-control" placeholder="000000000000000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Link a Participant</label>
                                    <input type="text" class="form-control" placeholder="Participant Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="step2" v-show="step === 2">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Item Number</label>
                                    <select class="form-select">
                                        <option value="">Choose Item Number</option>
                                        <option value="">Choose Item Number</option>
                                        <option value="">Choose Item Number</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label">Claim Type</label>
                                    <select class="form-select">
                                        <option value="">Choose Claim Type</option>
                                        <option value="">Choose Claim Type</option>
                                        <option value="">Choose Claim Type</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col-8">
                                            <div class="mb-4">
                                                <label class="form-label">Service Length (1h = 1)</label>
                                                <input type="text" class="form-control" placeholder="Enter Amount">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-4">
                                                <label class="form-label">Cost</label>
                                                <input type="text" class="form-control" placeholder="$">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row g-3">
                                        <div class="col-8">
                                            <div class="mb-4">
                                                <label class="form-label">Tax Rate</label>
                                                <select class="form-select">
                                                    <option value="">GST Free</option>
                                                    <option value="">GST Free</option>
                                                    <option value="">GST Free</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-4">
                                                <label class="form-label">Total</label>
                                                <input type="text" class="form-control" placeholder="$">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-primary btn-sm">Remove Service</button>
                            </div>
                        </div>
                        <div class="pt-4 mt-4 border-top">
                            <button class="btn btn-light btn-lg w-100 py-3">+ Add New Service</button>
                        </div>
                    </div>
                    <div class="step3" v-show="step === 3">
                        <div class="mb-4">
                            <label class="form-label">Upload Invoice</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Invoice file name"
                                       aria-label="Invoice file name" aria-describedby="fileBtn">
                                <button class="btn btn-light fw-bold" type="button" id="fileBtn">View File</button>
                            </div>
                        </div>
                    </div>
                    <div class="mw290 mx-auto px-4 mt-4 mt-md-5">
                        <button v-if="!lastStep" class="btn btn-primary btn-lg w-100 py-3 mb-3" @click.prevent="next()">
                            Next
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  data() {
    return {
        loader: false,
        step: 1,
        lastStep: false,
    }
  },
  watch: {
      step(val, old) {
          if (val == 3) {
              this.lastStep = true
          } else {
              this.lastStep = false
          }
      },
  },
  mounted() {

  },
  methods: {
      current(value) {
          this.step = value
      },
      prev() {
          this.step--
      },
      next() {
          if (this.step < 3) {
              this.step++
          }
      },
  }
}
</script>
