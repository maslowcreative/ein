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
                <div v-if="user" class="modal-body">
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
                                    <label  class="form-label">Name</label>
                                    <input type="text" v-model="user.other_name"  class="form-control"  placeholder="Name of the provider" />
                                    <div class="invalid-msg" v-if="form.errors.has('other_name')" v-html="form.errors.get('other_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">ABN</label>
                                    <input type="text" v-model="user.provider.abn" class="form-control"  placeholder="00000000000000000000" />
                                    <div class="invalid-msg" v-if="form.errors.has('provider.abn')" v-html="form.errors.get('provider.abn').replace('provider.abn','abn')" />
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
                                    <label class="form-label fw-bold">Participants</label>
                                    <multiselect
                                        v-model="participantItemsResultSelected"
                                        placeholder="Search or add item"
                                        label="name"
                                        track-by="id"
                                        :options="participantItemsResult"
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
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Account Name</label>
                                    <div class="input-group-overlay">
                                        <input type="text"  class="form-control"  v-model="user.account_name" placeholder="Account name" />
                                        <div class="invalid-msg" v-if="form.errors.has('account_name')" v-html="form.errors.get('account_name')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">BSB</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="0000000000"
                                        v-model="user.bsb"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('bsb')" v-html="form.errors.get('bsb')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Account Number</label>
                                    <input type="email" placeholder="Account Number" v-model="user.account_number" class="form-control appended-form-control">
                                    <div class="invalid-msg" v-if="form.errors.has('account_number')" v-html="form.errors.get('account_number')" />
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mw290 mx-auto px-4 mt-3">
                        <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3"  v-on:click="updateUser">Update Information</button>
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
                role_id: 2,
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                address: null,
                account_name: null,
                bsb: null,
                account_number: null,
                provider: {
                    abn: null,
                    business_name: null,
                    participants: [],
                    items:[],
                },
            }),
            participantItemsResultSelected: [],
            participantItemsResult: [],
            servicesItemsResult: [],
            servicesItemsSelected: [],
        }
    },
    mounted() {
        this.$root.$on("ein:provider-edit-popup-open", (user) => {
            let participantItemsResult = [];
            let servicesItemsSelected = [];
            this.form.reset();
            this.form.errors.errors = {};
            user.provider.participants.forEach(function (item){
                participantItemsResult.push({
                    id: item.user.id,
                    name: item.user.name
                });
            })
            user.provider.items.forEach(function (item){
                servicesItemsSelected.push({
                    support_item_number: item.item_number
                });
            })
            this.participantItemsResultSelected = participantItemsResult;
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
            this.form.provider.abn = this.user.provider.abn;
            this.form.provider.business_name = this.user.provider.business_name;

            this.form.account_name = this.user.account_name;
            this.form.bsb = this.user.bsb;
            this.form.account_number = this.user.account_number;

            let participants = [];
            this.participantItemsResultSelected.forEach(function (item){
                participants.push(item.id);
            });
            this.form.provider.participants = participants;

            let items = [];
            this.servicesItemsSelected.forEach(function (item){
                items.push(item.support_item_number);
            });
            this.form.provider.items = items;

            let route = this.laroute.route("ajax.users.update",{ 'user' : this.user.id})
            this.form
                .put(route)
                .then(res => {
                    this.$toastr.s("Success", "User updated!");
                })
                .catch(error => {
                    this.$toastr.e("Error", "Something went wrong.")
                })
                .finally(() => (this.loader = false))
        },
        getUsersList(name) {
            this.loading = true;

            let data = {
                page: 1,
                "filter[name]": name,
                "filter[roles][0]": 'participant',
            }

            if (name) {
                data["filter[name]"] = name;
            }


            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    this.participantItemsResult = res.data.data
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
                    this.$toastr.e("Error", "Something went wrong.")
                })
                .finally(() => {
                    this.loader = false
                });
        },

    },
}
</script>
