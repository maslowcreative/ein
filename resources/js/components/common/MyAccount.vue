<template>
    <div>
    <div class="card">
        <div  class="card-body">
            <h3 class="border-bottom pb-4 mb-5">My Account</h3>
            <div class="row">
                <div class="col-lg-3">
                    <div class="">
                        <label class="form-label">Profile Picture</label>
                        <div class="profile-img-wrap">
                            <div class="profile-img"></div>
                            <div class="profile-btns">
                                <button type="button" class="btn btn-light">
                                    <ion-icon name="duplicate-outline"></ion-icon>
                                </button>
                                <button type="button" class="btn btn-light">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </div>
                        </div>
                        <div class="profile-hint py-3">Allowed File Types: .png . jpg and .jpeg.</div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="mb-4">
                                <label  class="form-label">Full Name</label>
                                <div class="input-group-overlay">
                                    <input type="text"  class="form-control" v-model="user.name"  placeholder="The Name of User" />
                                    <div class="invalid-msg" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
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
                        <div class="col-md-4 col-sm-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Enter Password</label>

                                    <input type="password" v-model="form.password" placeholder="****************************" class="form-control appended-form-control">
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

                                    <input type="password"  v-model="form.password_confirmation" placeholder="****************************" class="form-control appended-form-control">
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

            <div>

            </div>
        </div>
    </div>
    </div>
</template>
<script>
import Form from "vform";

export default {
    props:['user'],
    data() {
        return {
            loader: false,
            form: new Form({
                name: null,
                email: null,
                phone: null,
                address: null,
                password: null,
                password_confirmation: null,
            }),
        }
    },
    mounted() {

    },
    methods:{
        updateUser() {
            this.loader = true;

            let data = [];

            data.name = this.user.name;
            data.email = this.user.email;
            data.phone = this.user.phone;
            data.address = this.user.address;

            if( this.form.password || this.form.password_confirmation) {
                data.password = this.form.password;
                data.password_confirmation = this.form.password_confirmation;
            }

            this.form = new Form(data);

            let route = this.laroute.route("ajax.users.update.basic.info",{ 'user' : this.user.id});
            console.log(route);
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
    }
}
</script>
