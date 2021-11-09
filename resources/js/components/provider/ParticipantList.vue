<template>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Linked Participants</h5>
                    <small class="text-primary">{{ items.total }} Active Users</small>
                </div>
                <div class="card-right-btns">
                    <div class="dropdown">
                        <button
                            class="btn btn-light btn-icon"
                            type="button"
                            id="userSearchDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="userSearchDropdown">
                            <div class="py-2 px-3">
                                <div class="">
                                    <label class="form-label">Search for a User</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        v-model="filters.name"
                                        placeholder="Enter Users Name"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn btn-light btn-icon"
                            type="button"
                            id="filterDropdown2"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <ion-icon name="funnel-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown2">
                            <div class="py-2 px-3">
                                <label class="form-label">Account Type</label>
                                <select class="form-select form-select-sm" v-model="filters.role">
                                    <option selected value="all">All</option>
                                    <option value="provider">Provider</option>
                                    <option value="participant">Participant</option>
                                    <option value="representative">Representative</option>
                                </select>
                            </div>
                            <div class="py-2 px-3">
                                <div class="mb-3">
                                    <label class="form-label">Plan Status</label>
                                    <select class="form-select form-select-sm" v-model="filters.plan_status">
                                        <option selected value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                        <option value="3">New Expiry</option>
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
                            <th scope="col" class="not-center">User</th>
                            <th scope="col">Plan</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(user, index) in items.data" v-bind:key="index">
                            <td class="not-center">
                                <div class="d-flex">
                                    <div class="me-4">
                                        <img src="/images/avatar.png" width="50" height="50" alt="" />
                                    </div>
                                    <div class="fw-bold">
                                        {{ user.name }}
                                        <span class="d-block text-primary fw-normal">{{ user.roles[0].name }}</span>
                                    </div>
                                    <div class="ms-3 d-inline-flex align-items-center">
                                        <a href="#" class="d-flex text-secondary h5 mb-0" data-bs-toggle="collapse"
                                           :data-bs-target="'#part_collapse_'+user.id" aria-expanded="false"   :aria-controls="'part_collapse_'+user.id">
                                            <ion-icon v-if="user.participant.representative" name="chevron-down-outline"></ion-icon>
                                        </a>
                                    </div>
                                </div>
                                <div class="collapse" :id="'part_collapse_'+user.id" v-if="user.participant.representative">
                                    <div class="d-flex pt-3 ps-4">
                                        <div class="me-4">
                                            <img src="/images/avatar.png" width="40" height="40" alt="" />
                                        </div>
                                        <div class="fw-bold" >
                                            {{user.participant.representative.name}}
                                            <span class="d-block text-primary fw-normal">Representative</span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <button class="btn btn-primary btn-sm" v-on:click="openCreateInvoiceModal(user)">New Invoice</button>
                            </td>
                            <td>
                                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                                    <button class="btn btn-link p-0 fs-16 mx-1 hover-danger" v-on:click="removeParticipant(user.id)">
                                        <ion-icon name="remove-circle-outline"></ion-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Loader -->
                <div  v-if="this.loading" class="loader-bg">
                    <div class="spinner-grow text-primary spinner-loder" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="mt-4 mt-md-5">
                <advanced-laravel-vue-paginate
                    :data="items"
                    @paginateTo="getUsersList"
                    :showNextPrev="false"
                    useStyle="bootstrap"
                    listClass="pagination"
                />
            </div>
            <plan-popup></plan-popup>
        </div>
    </div>
</template>

<script>
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate"
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css"
import PlanPopup from "../popups/PlanPopup"

export default {
    components: { AdvancedLaravelVuePaginate, PlanPopup },
    data() {
        return {
            loading: false,
            filters: {
                name: null,
                role: "all",
                plan_status: "all",
            },
            items: {},
            participantProp:null
        }
    },
    watch: {
        "filters.name": function(val, old) {
            this.getUsersList(1)
        },
        "filters.role": function(val, old) {
            this.getUsersList(1)
        },
    },
    mounted() {
        this.getUsersList()
    },
    methods: {
        getUsersList(page = 1) {
            this.loading = true
            let data = { page: page }
            //Filtering Admin Role.
            data["filter[not_in][0]"] = 1;
            data["filter[roles][0]"] = 'participant';

            if (this.filters.name) {
                data["filter[name]"] = this.filters.name
            }

            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    this.items = res.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loading = false))
        },
        removeParticipant(participantId) {
            this.loading = true;
            let route = this.laroute.route("ajax.providers.remove.participants",{'participant_id':participantId});
            axios
                .post(route)
                .then(res => {
                    this.$toastr.s("Success", "Participant removed!");
                    this.getUsersList();
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.");
                })
                .finally(() => (this.loading = false));
        },
        openCreateInvoiceModal(participant) {
            VueEvents.$emit('ein-provider:participant-selected-to-invoice',participant)
            $("#invoicePopup").modal('show');
        }


    },
}
</script>
