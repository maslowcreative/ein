<template>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Invoices/Claims</h5>
                    <small class="text-primary">{{items.total}} Submitted Invoices/Claims </small>
                </div>
                <div class="card-right-btns">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#invoicePopup">
                        + New Invoice
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-light btn-icon" type="button" id="filterDropdown1" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <ion-icon name="funnel-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown1">
                            <div class="py-2 px-3">
                                <div class="mb-3">
                                    <label class="form-label">Claim Status</label>
                                    <select class="form-select form-select-sm" v-model="filters.claim_status">
                                        <option  value="all">All</option>
                                        <option value="0">Pending Approval</option>
                                        <option value="1">Approved by Represetntative</option>
                                        <option value="2">Denied by Represetntative</option>
                                        <option value="3">Pending Reconcilation</option>
                                        <option value="4">Reconciled</option>
                                    </select>
                                </div>
                                <div class="">
                                    <label class="form-label">Claim Status</label>
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
            <div class="loader-wrap">
                <div class="table-x-scroll">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="not-center">Claim Number</th>
                            <th scope="col">Status</th>
                            <th scope="col">Details</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="claim in items.data">
                            <td class="not-center">
                                <div class="fw-bold">
                                    Claim #{{claim.claim_reference}}
                                    <span class="d-block text-primary fw-normal">{{claim.participant.user.name}}</span>
                                </div>
                            </td>
                            <td>
                                {{claim.state}}
                            </td>
                            <td><button class="btn btn-light btn-sm" v-on:click="openViewInvoiceModal(claim)">View more</button></td>
    <!--                        <td><button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#claimDetailPopup">View more</button></td>-->
                            <td>
                                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                                    <a v-if="claim.invoice_path" class="btn btn-link p-0 mx-1" :href="claim.invoice_url">
                                        <ion-icon name="push-outline" class="flip-v"></ion-icon>
                                    </a>
                                    <button class="btn btn-link p-0 mx-1 d-flex" data-bs-toggle="modal"
                                            data-bs-target="#claimPopup">
                                        <ion-icon name="cash-outline"></ion-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Loader -->
                <div  v-if="this.loader" class="loader-bg">
                    <div class="spinner-grow text-primary spinner-loder" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
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

            <view-invoice-popup ></view-invoice-popup>
            <provider-claim-detail-popup v-bind:claim="claim"></provider-claim-detail-popup>
            <create-invoice-popup></create-invoice-popup>
        </div>
    </div>
</template>

<script>
import CreateInvoicePopup from "./CreateInvoicePopup";
import ViewInvoicePopup from "./ViewInvoicePopup";
import ProviderClaimDetailPopup from "./ProviderClaimDetailPopup";
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate";
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css";
export default {
    components: {ProviderClaimDetailPopup, ViewInvoicePopup, CreateInvoicePopup,AdvancedLaravelVuePaginate},
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
    }
  },
  watch: {
        "filters.claim_status": function(val, old) {
            this.getProviderClaimsList(1)
        },
        "filters.claim_type": function(val, old) {
            this.getProviderClaimsList(1)
        },
  },
  mounted() {
    this.getProviderClaimsList();
    //Called Whenever claim is created.
    this.$root.$on("ein-claim:created", () => {
      this.getProviderClaimsList();
    });
  },
  methods: {
      getProviderClaimsList(page = 1) {
          this.loader = true;
          let data = { page: page };


          if (this.filters.claim_status && this.filters.claim_status != "all") {
              data["filter[claim_status]"] = this.filters.claim_status
          }

          // if (this.filters.claim_type && this.filters.claim_type != "all") {
          //     data["filter[claim_type]"] = this.filters.claim_type
          // }

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
