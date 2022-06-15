<template>
    <div
        class="modal fade"
        id="userEditRepresentativeModal"
        tabindex="-1"
        data-bs-backdrop="static"
        aria-labelledby="adminModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="adminModalTitle">Edit Representative Profile</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div v-if="user" class="modal-body">
                    <form @submit.prevent="editUser" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">First Name</label>
                                    <input type="text" v-model="user.first_name"  class="form-control"  placeholder="The first name of the Representative" />
                                    <div class="invalid-msg" v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label">Last Name</label>
                                    <input type="text" v-model="user.last_name"  class="form-control"  placeholder="The last name of the Representative" />
                                    <div class="invalid-msg" v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">E-mail Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="user.email"
                                        placeholder="providersemail@gmail.com"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Home Address</label>
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
                                        v-model="user.phone"
                                        placeholder="0000000000"
                                    />
                                </div>
                                <div class="invalid-msg" v-if="form.errors.has('phone')" v-html="form.errors.get('phone')" />
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
import 'vue-select/dist/vue-select.css';
<script>
import Form from "vform"
import Multiselect from 'vue-multiselect'
export default {
    components: { Multiselect },
    data() {
        return {
            user:null,
            loader: false,
            form: new Form({
                first_name: null,
                last_name: null,
                email: null,
                phone: null,
                address: null,
                role_id : 3,
                representative:{
                    participants:[]
                }
            }),
            participantItemsResultSelected: null,
            participantItemsResult: []

        }
    },
    mounted() {
            this.$root.$on("ein:rep-edit-popup-open", (user) => {
                this.form.reset();
                this.form.errors.errors = {};
                this.user = user;
                let route = this.laroute.route("ajax.users.representative.participants", {representative : user.id })
                axios
                    .get(route)
                    .then(res => {
                        this.setParticipantsSelected(res.data);
                    })
                    .catch(error => {
                        console.log(error)
                    })
                    .finally(() => (this.loading = false))
            });
    },
    methods: {
        setParticipantsSelected(participants){
            let participantsSelected = [];
            participants.forEach(function (participant){
                participantsSelected.push({
                    id: participant.user.id,
                    name: participant.user.name
                })
            });
            this.participantItemsResultSelected = participantsSelected;
        },
        getUsersList(name) {
            this.loading = true
            let data = { page: 1 }
            //Filtering Admin Role.
            data["filter[not_in][0]"] = 1;
            data["filter[participant_has_representative]"] = 0;
            data["filter[roles][0]"] = 'participant';

            if (name) {
                data["filter[name]"] = name
            }

            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    this.participantItemsResult = res.data.data
                    console.log(this.participantItemsResult);
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loading = false))
        },
        updateUser() {
            this.loader = true;
            this.form.first_name = this.user.first_name;
            this.form.last_name = this.user.last_name;
            this.form.email = this.user.email;
            this.form.phone = this.user.phone;
            this.form.address = this.user.address;
            let repIds = [];
            this.participantItemsResultSelected.forEach(function ($participant){
                repIds.push($participant.id);
            })
            this.form.representative.participants = repIds;

            let route = this.laroute.route("ajax.users.update",{ 'user' : this.user.id})
            this.form
                .put(route)
                .then(res => {
                    this.$toastr.s("Success", "User updated!");
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                    console.log(error)
                })
                .finally(() => (this.loader = false))
        }

    },
}
</script>
