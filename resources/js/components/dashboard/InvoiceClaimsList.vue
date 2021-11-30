<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h5>Invoices/Claims</h5>
          <small class="text-primary">{{items.total}} Invoices/Claims</small>
        </div>
        <div class="card-right-btns">
          <button class="btn" v-bind:class="[filters.claim_status == 'all' ?  'btn-primary' : 'btn-light']"
          <button class="btn" v-bind:class="[filters.claim_status == 'all' ?  'btn-primary' : 'btn-light']"
            v-on:click="setFilter('all')"
          >
            All Claims
          </button>
          <button class="btn position-relative" v-bind:class="[filters.claim_status == 0 ?  'btn-primary' : 'btn-light']"
                  v-on:click="setFilter('0')"
          >
            Pending Approval
<!--            <span-->
<!--              class="position-absolute top-0 start-100 translate-middle badge badge-alrt border border-light rounded-circle bg-primary"-->
<!--              ><span class="visually-hidden">unread messages</span></span-->
<!--            >-->
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
                        <option value="0">Pending Approval</option>
                        <option value="1">Approved by Representative</option>
                        <option value="2">Denied by Representative</option>
                        <option value="3">Admin Approved</option>
                        <option value="4">Reconciled</option>
                    </select>
                </div>
                <div class="">
                  <label class="form-label">Claim Type</label>
                    <select class="form-select form-select-sm" v-model="filters.claim_type">
                        <option  value="all">All</option>
                        <option value="CANC">Cancellation Charges</option>
                        <option value="REPW">Report Writing Charges</option>
                        <option value="TRAN">Travel Charges</option>
                        <option value="NF2F">Non-Face to Face Services</option>
                    </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
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
                <input :disabled="item.status != 1" :checked="isChecked(item.id)" v-on:click="checkboxChanged($event,item.id)" class="form-check-input" type="checkbox"  aria-label="..." />
              </td>
              <td class="not-center">
                <div class="fw-bold">
                  Claim #{{item.claim_reference}}
                  <span class="d-block text-primary fw-normal">{{item.claim.participant.user.name}}</span>
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
                  <button class="btn btn-link p-0 mx-1">
                    <ion-icon name="document-attach-outline"></ion-icon>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mt-md-5 card-right-btns justify-content-end">
<!--        <a class="btn btn-light" :href="laroute.route('ajax.claims.bulk.upload.file')" >Download Selected</a>-->
        <button class="btn btn-light" v-on:click="bulkUploadFile" >Download Selected</button>
        <button class="btn btn-primary">Upload Selected</button>
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
    <provider-claim-detail-popup v-bind:claim="claim"></provider-claim-detail-popup>
  </div>
</template>

<script>
export default {
  data() {
    return {
        loader: false,
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
            claim_status: "all",
            claim_type: "all",
        },
        selectedClaims: []
    }
  },
  mounted() {
      this.getProviderClaimsList();
  },
  watch: {
    "filters.claim_status": function(val, old) {
        this.getProviderClaimsList(1)
    },
    "filters.claim_type": function(val, old) {
        this.getProviderClaimsList(1)
    },
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

          let route = this.laroute.route("ajax.claims.bulk.upload.file",{claims:this.selectedClaims});
          axios
              .post(route)
              .then(res => {
                  console.log();
                  const blob = new Blob([res.data], { type: "text/csv" });
                  const link = document.createElement("a");
                  link.href = URL.createObjectURL(blob);
                  link.download = res.headers['content-disposition'].split(';')[1].split('"')[1];
                  link.click();
                  URL.revokeObjectURL(link.href);
                  this.getProviderClaimsList();
              })
              .catch(error => {
                  console.log(error)
              })
              .finally(() => ( [] ))
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
      }
  }
}
</script>
