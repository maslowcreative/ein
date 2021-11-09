<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h5>Invoices/Claims</h5>
          <small class="text-primary">9999 Invoices/Claims</small>
        </div>
        <div class="card-right-btns">
          <button class="btn btn-primary">
            All Claims
          </button>
          <button class="btn btn-light position-relative">
            Pending Approval
            <span
              class="position-absolute top-0 start-100 translate-middle badge badge-alrt border border-light rounded-circle bg-primary"
              ><span class="visually-hidden">unread messages</span></span
            >
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
                  <select class="form-select form-select-sm">
                    <option selected>All</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                  </select>
                </div>
                <div class="">
                  <label class="form-label">Claim Status</label>
                  <select class="form-select form-select-sm">
                    <option selected>All</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
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
            <tr v-for="claim in items.data">
              <td>
                <input class="form-check-input" type="checkbox" value="" aria-label="..." />
              </td>
              <td class="not-center">
                <div class="fw-bold">
                  Claim #{{claim.claim_reference}}
                  <span class="d-block text-primary fw-normal">{{claim.participant.user.name}}</span>
                </div>
              </td>
              <td>
                Claim Status
              </td>
              <td><button class="btn btn-light btn-sm" v-on:click="openViewInvoiceModal(claim)">View more</button></td>
              <td>
                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                  <button class="btn btn-link p-0 mx-1">
                    <ion-icon name="push-outline" class="flip-v"></ion-icon>
                  </button>
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
        <button class="btn btn-light">Download Selected</button>
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
    }
  },
  mounted() {
      this.getProviderClaimsList();
  },
  methods:{
      getProviderClaimsList(page = 1) {
          this.loader = true;
          let data = { page: page };
          let route = this.laroute.route("ajax.claims.store",data)
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
      openViewInvoiceModal(claim) {
          this.claim = claim;
          $("#claimDetailPopup").modal('show');
      }
  }
}
</script>
