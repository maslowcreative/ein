<template>
    <div>
        <div class="card">
            <div v-if="(this.userRole == 'provider' || this.userRole == 'representative') && (!this.user.account_name || !this.user.account_number || !this.user.bsb )" class="alert alert-danger" role="alert">
                Please enter your banking information before using this portal.
            </div>
            <div  class="card-body">
                <h3 class="border-bottom pb-4 mb-5">My Account</h3>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="">
                            <label class="form-label">Profile Picture</label>
                            <div class="profile-img-wrap">
                                <div class="profile-img" >
                                    <img :src="avatar_url">
                                </div>
                                <div class="profile-btns">
                                </div>
                            </div>
                            <input type="file" v-on:change="onFileChange">
                            <div class="profile-hint py-3">Allowed File Types: .png . jpg and .jpeg.</div>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label">First Name</label>
                                    <div class="input-group-overlay">
                                        <input type="text"  class="form-control" v-model="user.first_name"  placeholder="The first name of User" />
                                        <div class="invalid-msg" v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label">Last Name</label>
                                    <div class="input-group-overlay">
                                        <input type="text"  class="form-control" v-model="user.last_name"  placeholder="The last name of User" />
                                        <div class="invalid-msg" v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">E-mail Address</label>
                                    <input type="email" placeholder="paremail@gmail.com" v-model="user.email" class="form-control appended-form-control">
                                    <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">Phone Number</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        v-model="user.phone"
                                        placeholder="0000000000"
                                    />
                                    <div class="invalid-msg" v-if="form.errors.has('phone')" v-html="form.errors.get('phone')" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
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
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Enter Password</label>
                                    <div class="input-group-overlay">
                                        <div class="input-group-prepend-overlay">
                                            <span class="input-group-text text-primary"><ion-icon name="lock-open-outline"></ion-icon></span>
                                        </div>
                                        <input
                                            v-if="showPassword"
                                            id="password"
                                            type="password"
                                            v-model="form.password"
                                            class="form-control prepended-form-control"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <input
                                            v-else
                                            type="text"
                                            v-model="form.password"
                                            class="form-control prepended-form-control"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <div class="input-group-append-overlay">
                                            <button type="button" class="input-group-text text-primary">
                                                <ion-icon v-if="showPassword" v-on:click="showPasswordToggle('password',false)" name="eye-off-outline"></ion-icon>
                                                <ion-icon v-else v-on:click="showPasswordToggle('password',true)" name="eye-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="invalid-msg"
                                        v-if="form.errors.has('password')"
                                        v-html="form.errors.get('password')"
                                    />

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Confirm the Password</label>
                                    <div class="input-group-overlay">
                                        <div class="input-group-prepend-overlay">
                                            <span class="input-group-text text-primary"><ion-icon name="lock-open-outline"></ion-icon></span>
                                        </div>
                                        <input
                                            v-if="showConfirmPassword"
                                            type="password"
                                            v-model="form.password_confirmation"
                                            class="form-control prepended-form-control"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <input
                                            v-else
                                            type="text"
                                            v-model="form.password_confirmation"
                                            class="form-control prepended-form-control"
                                            name="password"
                                            required
                                            autocomplete="current-password"
                                        />
                                        <div class="input-group-append-overlay">
                                            <button type="button" class="input-group-text text-primary">
                                                <ion-icon v-if="showConfirmPassword" v-on:click="showPasswordToggle('confirm_password',false)" name="eye-off-outline"></ion-icon>
                                                <ion-icon v-else v-on:click="showPasswordToggle('confirm_password',true)" name="eye-outline"></ion-icon>
                                            </button>
                                        </div>
                                    </div>
                                    <div
                                        class="invalid-msg"
                                        v-if="form.errors.has('password_confirmation')"
                                        v-html="form.errors.get('password_confirmation')"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updateUser" >Update Information</button>
                                <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>

                <h3 v-if="this.userRole == 'provider' || this.userRole == 'representative'" class="border-bottom pb-4 mb-5">Bank Details</h3>
                <div v-if="this.userRole == 'provider' || this.userRole == 'representative'"  class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                           <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label">Account Name</label>
                                    <div class="input-group-overlay">
                                        <input type="text"  class="form-control"  v-model="bankForm.account_name" placeholder="Account name" />
                                        <div class="invalid-msg" v-if="bankForm.errors.has('account_name')" v-html="bankForm.errors.get('account_name')" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label fw-bold">BSB</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        placeholder="0000000000"
                                        v-model="bankForm.bsb"
                                    />
                                    <div class="invalid-msg" v-if="bankForm.errors.has('bsb')" v-html="bankForm.errors.get('bsb')" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Account Number</label>
                                    <input type="email" placeholder="Account Number" v-model="bankForm.account_number" class="form-control appended-form-control">
                                    <div class="invalid-msg" v-if="bankForm.errors.has('account_number')" v-html="bankForm.errors.get('account_number')" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <button v-if="!bankinfoLoader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updateBankInfo" >Update Information</button>
                                <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <h3 v-if="this.userRole == 'representative'" class="border-bottom pb-4 mb-5">Configuration</h3>
                <div v-if="this.userRole == 'representative'"  class="row">
                    <div class="col-lg-3">
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <div class="mb-4">
                                    <label  class="form-label">Approval Days</label>
                                    <div class="input-group-overlay">
                                        <select class="form-control" v-model="approvalForm.auto_approval_days">
                                            <option value="1">1 Day</option>
                                            <option value="2">2 Day</option>
                                            <option value="3">3 Day</option>
                                            <option value="4">4 Day</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-6">
                                <button v-if="!autoApprovalLoader" class="btn btn-primary btn-lg w-100 py-3" v-on:click="updateAutoApprovalDays" >Update Information</button>
                                <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</template>
<script>
import Form from "vform";

export default {
    props:['user','role'],
    data() {
        return {
            loader: false,
            bankinfoLoader: false,
            autoApprovalLoader: false,
            showPassword: true,
            showConfirmPassword: true,
            avatar: null,
            avatar_url: null,
            userRole : null,
            form: new Form({
                first_name: null,
                last_name: null,
                avatar: null,
                email: null,
                phone: null,
                address: null,
                password: null,
                password_confirmation: null,
            }),
            bankForm: new Form({
                account_name: null,
                account_number: null,
                bsb: null,
            }),
            approvalForm: new Form({
                auto_approval_days: null
            })
        }
    },
    mounted() {
        this.avatar = this.user.avatar;
        this.avatar_url = this.user.avatar_url
        this.userRole = this.role;
        this.bankForm.account_name = this.user.account_name;
        this.bankForm.account_number = this.user.account_number;
        this.bankForm.bsb = this.user.bsb;

        if(this.role == 'representative')
        {
            this.approvalForm.auto_approval_days = this.user.representative.auto_approval_days;
        }


    },
    methods:{
        updateUser() {
            this.loader = true;
            let data = [];

            data.first_name = this.user.first_name;
            data.last_name = this.user.last_name;
            data.email = this.user.email;
            data.phone = this.user.phone;
            data.address = this.user.address;
            data.avatar = this.avatar;

            if( this.form.password || this.form.password_confirmation) {
                data.password = this.form.password;
                data.password_confirmation = this.form.password_confirmation;
            }

            this.form = new Form(data);

            let route = this.laroute.route("ajax.users.update.basic.info",{ 'user' : this.user.id});

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
        },
        showPasswordToggle(type,status){

            if(type =='password') {

                this.showPassword = status;
            }

            if(type =='confirm_password') {

                this.showConfirmPassword = status;
            }
        },
        onFileChange(e) {

            var files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;

            let route = this.laroute.route("ajax.users.upload.avatar");
            let  form = new Form({
                'avatar':files[0]
            });

            this.loader = true;
            form
                .post(route)
                .then(res => {
                    this.avatar = res.data.avatar;
                    this.avatar_url = res.data.avatar_url;
                    this.loader = false;
                })
                .catch(error => {
                    this.avatar = null;
                    this.$toastr.e("Error", "Some thing went wrong while file upload.");
                    this.loader = false;
                })
                .finally(() => {
                    this.loader = false;
                });
        },
        updateBankInfo() {
            this.bankinfoLoader = true;

            let route = this.laroute.route("ajax.users.update.bank.info",{ 'user' : this.user.id});

            this.bankForm
                .put(route)
                .then(res => {
                    this.$toastr.s("Success", "User bank info updated!");
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                })
                .finally(() => (this.bankinfoLoader = false))
        },
        updateAutoApprovalDays() {
            this.autoApprovalLoader = true;

            let route = this.laroute.route("ajax.user.representative.approval",{ 'user' : this.user.id});

            this.approvalForm
                .post(route)
                .then(res => {
                    this.$toastr.s("Success", "User bank info updated!");
                })
                .catch(error => {
                    this.$toastr.e("Error", "Some thing went wrong.")
                })
                .finally(() => (this.autoApprovalLoader = false))
        },
    }
}
</script>
