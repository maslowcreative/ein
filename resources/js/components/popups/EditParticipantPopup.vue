<template>
    <div
        class="modal fade"
        id="userEditParticipantModal"
        tabindex="-1"
        data-bs-backdrop="static"
        aria-labelledby="adminModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="adminModalTitle">Edit Participant Profile</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div v-if="user && user.participant" class="modal-body">
                    <form @submit.prevent="editUser" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">First Name</label>
                                    <input type="text" v-model="user.first_name"  class="form-control"  placeholder="The first name of the Provider" />
                                    <div class="invalid-msg" v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Last Name</label>
                                    <input type="text" v-model="user.last_name"  class="form-control"  placeholder="The last name of the Provider" />
                                    <div class="invalid-msg" v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Other Name</label>
                                    <input type="text" v-model="user.other_name"  class="form-control"  placeholder="Other Name of the participant" />
                                    <div class="invalid-msg" v-if="form.errors.has('other_name')" v-html="form.errors.get('other_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4" >
                                    <label class="form-label">Date of Birth</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        placeholder="01/01/1999"
                                        v-model="user.participant.dob"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('participant.dob')" v-html="form.errors.get('participant.dob').replace('participant.dob','dob')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">State</label>
                                    <select class="form-control"  v-model="user.state">
                                        <option value="">Select a state</option>
                                        <option value="ACT">Australian Capital Territory</option>
                                        <option value="NSW">New South Wales</option>
                                        <option value="NT">Northern Territory</option>
                                        <option value="QLD">Queensland</option>
                                        <option value="SA">South Australia</option>
                                        <option value="TAS">Tasmania</option>
                                        <option value="VIC">Victoria</option>
                                        <option value="WA">Western Australia</option>
                                    </select>
                                    <div class="invalid-msg" v-if="form.errors.has('state')" v-html="form.errors.get('state')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Mailing Address</label>
                                    <textarea
                                        cols="30"
                                        rows="2"
                                        class="form-control"
                                        v-model="user.address"
                                        placeholder="Home Address 13, 10000 State, Country."
                                    ></textarea>
                                    <div class="invalid-msg" v-if="form.errors.has('address')" v-html="form.errors.get('address')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Unique Identifier</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="16515656115615656"
                                        v-model="user.participant.ndis_number"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('participant.ndis_number')" v-html="form.errors.get('participant.ndis_number').replace('participant.ndis number','ndis number')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">E-mail Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="providersemail@gmail.com"
                                        v-model="user.email"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Phone Number</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="0000000000"
                                        v-model="user.phone"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('phone')" v-html="form.errors.get('phone')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Providers</label>
                                    <multiselect
                                        v-model="providerItemsResultSelected"
                                        placeholder="Search or add item"
                                        label="show_name"
                                        track-by="id"
                                        :options="providerItemsResult"
                                        :multiple="true"
                                        :taggable="true"
                                        :searchable="true"
                                        :loading="loader"
                                        :internal-search="false"
                                        :clear-on-select="false"
                                        :close-on-select="false"
                                        :options-limit="50" :limit="15"
                                        @search-change="getUsersList"

                                    >
                                    </multiselect>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Representative</label>
                                    <multiselect
                                        v-model="representativeItemsResultSelected"
                                        placeholder="Search or add item"
                                        label="name"
                                        track-by="id"
                                        :options="representativeItemsResult"
                                        :multiple="false"
                                        :taggable="false"
                                        :searchable="true"
                                        :loading="loader"
                                        :internal-search="false"
                                        :clear-on-select="false"
                                        :close-on-select="true"
                                        :options-limit="50" :limit="15"
                                        @search-change="getRepList"

                                    >
                                    </multiselect>
                                    <div class="invalid-msg" v-if="form.errors.has('participant.representative_id')" v-html="form.errors.get('participant.representative_id').replace('participant.representative id','representative')" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Specific Item Numbers</label>
                                    <multiselect
                                        v-model="servicesItemsSelected"
                                        placeholder="Search or add item"
                                        label="support_item_number" track-by="support_item_number"
                                        :options="servicesItemsResult"
                                        :multiple="true"
                                        :taggable="true"
                                        :searchable="true"
                                        :loading="loader"
                                        :internal-search="false"
                                        :clear-on-select="false"
                                        :close-on-select="false"
                                        :options-limit="50" :limit="15"
                                        @search-change="asyncFindItemNumber"
                                    >
                                    </multiselect>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mw290 mx-auto px-4 mt-3">
                        <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updateUser" >Update Information</button>
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
import Multiselect from 'vue-multiselect'
export default {
    components: { Multiselect },
    props:['user'],
    data() {
        return {
            loader: false,
            form: new Form({
                role_id: 4,
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                address: null,
                state: "",
                participant: {
                    dob: null,
                    ndis_number: null,
                    representative_id: null,
                    providers: [],
                    items:[],
                }
            }),
            providerItemsResultSelected: [],
            providerItemsResult: [],

            representativeItemsResultSelected: null,
            representativeItemsResult: [],

            servicesItemsResult: [],
            servicesItemsSelected: [],
        }
    },
    mounted() {
        this.$root.$on("ein:participant-edit-popup-open", (user) => {
            let providerItemsResultSelected = [];
            let servicesItemsSelected = [];
            this.form.reset();
            this.form.errors.errors = {};
            user.participant.providers.forEach(function (item){

                providerItemsResultSelected.push({
                    id: item.user.id,
                    show_name: item.user.show_name
                });
            });

            user.participant.items.forEach(function (item){
                servicesItemsSelected.push({
                    support_item_number: item.item_number
                });
            })

            if(user.participant && user.participant.representative ){
                this.representativeItemsResultSelected = {id: user.participant.representative.id,  name: user.participant.representative.name};
            }else {
                this.representativeItemsResultSelected = null;
            }

            this.providerItemsResultSelected = providerItemsResultSelected;
            this.servicesItemsSelected = servicesItemsSelected;
        });
    },
    methods: {
        updateUser() {
            this.loader = true;
            this.form.first_name = this.user.first_name;
            this.form.last_name = this.user.last_name;
            this.form.other_name = this.user.other_name;
            this.form.email = this.user.email;
            this.form.phone = this.user.phone;
            this.form.address = this.user.address;
            this.form.state = this.user.state;
            this.form.participant.dob = this.user.participant.dob;
            this.form.participant.ndis_number = this.user.participant.ndis_number;
            this.form.participant.representative_id = this.representativeItemsResultSelected.id;
            let providers = [];
            this.providerItemsResultSelected.forEach(function (item){
                providers.push(item.id);
            });

            let items = [];
            this.servicesItemsSelected.forEach(function (item){
                items.push(item.support_item_number);
            });
            this.form.participant.items = items;

            this.form.participant.providers = providers;

            let route = this.laroute.route("ajax.users.update",{ 'user' : this.user.id})
            this.form
                .put(route)
                .then(res => {
                    this.$toastr.s("Success", "User updated!");
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                })
                .finally(() => (this.loader = false))
        },
        getUsersList(name) {
            this.loading = true;

            let data = {
                page: 1,
                "filter[name]": name,
                "filter[roles][0]": 'provider',
            }

            if (name) {
                data["filter[name]"] = name;
            }


            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    this.providerItemsResult = res.data.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loading = false))
        },
        getRepList(name) {
            this.loading = true;

            let data = {
                page: 1,
                "filter[name]": name,
                "filter[roles][0]": 'representative',
            }

            if (name) {
                data["filter[name]"] = name;
            }


            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    this.representativeItemsResult = res.data.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loading = false))
        },
        asyncFindItemNumber(query) {
            this.servicesItemsResult = [];
            let data = {
                "filter[item_number]": query,
            }
            let route = this.laroute.route("ajax.services.index", data)
            axios
                .get(route)
                .then(res => {
                    this.servicesItemsResult = res.data.data;
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                })
                .finally(() => {
                    this.loader = false
                });
        },
    },
}
</script>
