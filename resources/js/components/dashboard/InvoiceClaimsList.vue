<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h5>Invoices/Claims</h5>
          <small class="text-primary">{{items.total}} Invoices/Claims</small>
        </div>

        <div class="card-right-btns">
          <div class="dropdown">
                <button
                    class="btn btn-light btn-icon"
                    type="button"
                    id="claimSearchDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <ion-icon name="search-outline"></ion-icon>
                </button>
                <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="claimSearchDropdown">
                    <div class="py-2 px-3">
                        <div class="">
                            <label class="form-label">Search for a Claim</label>
                            <input
                                type="text"
                                v-model="filters.claim_number"
                                class="form-control form-control-sm"
                                placeholder="Enter Claim number"
                            />
                        </div>
                    </div>
                </div>
            </div>
          <button class="btn" v-bind:class="[filters.claim_status == 'all' ?  'btn-primary' : 'btn-light']"
            v-on:click="setFilter('all')"
          >
            All Claims
          </button>
          <button class="btn position-relative" v-bind:class="[filters.claim_status == 1 ?  'btn-primary' : 'btn-light']"
                  v-on:click="setFilter('1')"
          >
              Attention
          </button>
          <div class="dropdown">
            <button
              class="btn btn-light btn-icon"
              type="button"
              id="filterDropdown1"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <ion-icon name="funnel-outline"></ion-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown1">
              <div class="py-2 px-3">
                <div class="mb-3">
                    <label class="form-label">Claim Status</label>
                    <select class="form-select form-select-sm" v-model="filters.claim_status">
                        <option  value="all">All</option>
                        <option value="0">Pending</option>
                        <option value="1">Accepted</option>
                        <option value="2">Rejected</option>
                        <option value="3">Approved</option>
                        <option value="4">Processing</option>
                        <option value="5">Reconciled</option>
                        <option value="6">Canceled</option>
                    </select>
                </div>
                <div class="">
                  <label class="form-label">Claim Type</label>
                    <select class="form-select form-select-sm" v-model="filters.claim_type">
                        <option  value="all">All</option>
                        <option value="CANC">Cancellation Charges</option>
                        <option value="REPW">Report Writing Charges</option>
                        <option value="TRAN">Travel Charges</option>
                        <option value="F2F">Face-To-Face</option>
                        <option value="NF2F">Non-Face to Face Services</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="loader-wrap">
        <div class="table-x-scroll">
        <table class="table">
          <thead>
            <tr>
              <th scope="col"></th>
              <th scope="col" class="not-center">Claim Number</th>
              <th scope="col">Status</th>
              <th scope="col">Details</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items.data">
              <td>
                <input v-if="item.status == 1" :disabled="item.status != 1" :checked="isChecked(item.id)" v-on:click="checkboxChanged($event,item.id)" class="form-check-input" type="checkbox"  aria-label="..." />
              </td>
              <td class="not-center">
                <div class="fw-bold">
                  Claim #{{item.claim_reference}} ({{item.claim.claim_reference}})
                  <span class="d-block text-primary fw-normal">{{item.claim.participant.user.name}} </span>
                  <span class="d-block text-primary fw-normal" v-if="item.claim.participant.user.othername">{{item.claim.participant.user.othername}}</span>
                </div>
              </td>
              <td>
                  {{item.state}}
              </td>
              <td><button class="btn btn-light btn-sm" v-on:click="openViewInvoiceModal(item.claim,item)">View more</button></td>
              <td>
                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                  <a v-if="item.claim.invoice_path" class="btn btn-link p-0 mx-1" :href="item.claim.invoice_url">
                      <ion-icon name="push-outline" class="flip-v"></ion-icon>
                  </a>
                  <button class="btn btn-link p-0 mx-1" v-on:click="openClaimModal(item.claim,item)">
                    <ion-icon name="cash-outline"></ion-icon>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
          <!-- Loader -->
          <div v-if="this.loader" class="loader-bg">
              <div class="spinner-grow text-primary spinner-loder" role="status">
                  <span class="visually-hidden">Loading...</span>
              </div>
          </div>
      </div>
        <div class="mt-4 mt-md-5 card-right-btns justify-content-end">
          <span v-if="getPermission('approving_claims')">
          <button v-if="!claimApproveLoader" class="btn btn-light" v-on:click="bulkUploadFile" >Approve Selected</button>
          <button v-else  class="btn btn-light" type="button" disabled>
              <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              Loading...
          </button>
          </span>
<!--        <a class="btn btn-light" :href="laroute.route('ajax.claims.bulk.upload.file')" >Download Selected</a>-->

        <button class="btn btn-primary">Bulk Download (ABA)</button>
      </div>
      <div class="mt-4 mt-md-5">
          <advanced-laravel-vue-paginate
              :data="items"
              @paginateTo="getProviderClaimsList"
              :showNextPrev="false"
              useStyle="bootstrap"
              listClass="pagination"
          />
      </div>
    </div>
    <view-invoice-popup v-bind:claim="claim"></view-invoice-popup>
<!--    <provider-claim-detail-popup   v-bind:claim="claim"></provider-claim-detail-popup>-->
    <admin-claim-detail-popup   ></admin-claim-detail-popup>
  </div>
</template>

<script>
import ViewInvoicePopup from "../provider/ViewInvoicePopup";
import AdminClaimDetailPopup from "../provider/AdminClaimDetailPopup";
import Form from "vform";
export default {
    props:["policy"],
    components: {AdminClaimDetailPopup, ViewInvoicePopup},
    data() {
    return {
        loader: false,
        claimApproveLoader: false,
        items:{},
        claim: {
            id: null,
            claim_reference: null,
            ndis_number:null,
            authorised_by: null,
            participant_approved: null,
            provider_abn: null,
            start_date: null,
            end_date: null,
            provider:{
                id: null,
                abn:null,
                user:{
                    name:null
                }
            },
            participant:{
                id:null,
                user:{
                    name:null
                }
            },
            items: [],
        },
        filters: {
            claim_status: "1",
            claim_type: "all",
            claim_number: null,
        },
        selectedClaims: []
    }
  },
  mounted() {
      this.getProviderClaimsList();

      this.$root.$on("ein-admin:claim-updated", () => {
          this.getProviderClaimsList();
      });
  },
  watch: {
    "filters.claim_status": function(val, old) {
        this.getProviderClaimsList(1)
    },
    "filters.claim_type": function(val, old) {
        this.getProviderClaimsList(1)
    },
    "filters.claim_number":function (val,old){
        this.getProviderClaimsList(1);
    }
  },
  methods:{
      getProviderClaimsList(page = 1) {
          this.loader = true;

          let data = { page: page };

          if (this.filters.claim_status && this.filters.claim_status != "all") {
              data["filter[claim_status]"] = this.filters.claim_status
          }

          if (this.filters.claim_type && this.filters.claim_type != "all") {
              data["filter[claim_type]"] = this.filters.claim_type
          }

          if (this.filters.claim_number ) {
              data["filter[claim_number]"] = this.filters.claim_number;
          }

          let route = this.laroute.route("ajax.claims.list",data)
          axios
              .get(route)
              .then(res => {
                  this.items = res.data
              })
              .catch(error => {
                  console.log(error)
              })
              .finally(() => (this.loader = false))
      },
      openViewInvoiceModal(claim,item) {
          this.claim = claim;
          this.claim.items = [item];
          this.$root.$emit("ein-admin:claim-detail-popup-open", this.claim);
          $("#claimDetailPopup").modal('show');
      },
      setFilter(value) {
          this.filters.claim_status = value;
      },
      bulkUploadFile() {

          if(this.selectedClaims.length == 0){
              this.$toastr.e("Error", "No claim selected.");
              return false;
          }
          this.claimApproveLoader = true;
          let route = this.laroute.route("ajax.claims.admin.approved");
          axios
              .post(route,{claims:this.selectedClaims})
              .then(res => {
                  this.selectedClaims = [];
                  this.getProviderClaimsList();
                  this.$toastr.s('Sucess','Claims approved!');
              })
              .catch(error => {
                  this.claimApproveLoader = false;
                  this.$toastr.e("Error", "Something went wrong.");
                  console.log(error)
              })
              .finally(() => {
                  this.claimApproveLoader = false;
              })
      },
      checkboxChanged(event,claimId) {
        if(event.target.checked) {
            this.selectedClaims.push(claimId);
        }else {
            this.selectedClaims.pop(claimId);
        }
      },
      isChecked(claimId) {
          return this.selectedClaims.includes(claimId);
      },
      openClaimModal(claim,item) {
          this.claim = claim;
          this.claim.items = [item];
          this.claim.claim_reference = item.claim_reference;
          this.claim.paid = '$' + (item.amount_paid ? item.amount_paid : 0);
          this.claim.total = '$' + item.amount_claimed;
          $("#claimPopup").modal('show');
      },
      getPermission(pName) {
          if(this.policy.is_supper_admin){
              return true;
          }
          return this.policy.permissions[pName];
      }
  }
}
</script>
