<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Reset Password</div>

                    <div class="card-body">
                        <div v-if="message" class="alert alert-success" role="alert">
                            {{ message }}
                        </div>

                        <form @submit.prevent="emailResetLink" method="POST" >
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="form.email"  required autocomplete="email" autofocus>
                                    <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import Form from 'vform';
export default {
    data() {
        return {
            loader : false,
            message: null,
            form: new Form({
                email: null
            }),
        }
    },
    methods:{
        emailResetLink() {
            this.message = null;
            this.loader = true;
            let route = this.laroute.route('password.email');
            this.form.post(route)
                .then((res) => {
                    this.loader = false;
                    this.message = res.data.message;
                })
                .catch((error) => {
                    this.loader = false;
                });

        }
    }
}
</script>
