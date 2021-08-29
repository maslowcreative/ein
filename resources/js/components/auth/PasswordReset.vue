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
                        
                        <form method="POST" @submit.prevent="passwordReset" >
                            <input type="hidden" name="token" v-model="form.token" >

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" v-model="form.email" required autocomplete="email" autofocus>
                                    <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" v-model="form.password" required autocomplete="new-password">
                                    <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation" required autocomplete="new-password">
                                    <div v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')" />
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Reset Password
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
    props:['tokenProp','emailProp'],
    data() {
        return {
            loader: false,
            message: null,
            form: new Form({
                token: null,
                email: null,
                password:  null,
                password_confirmation : null
            }),
        }
    },
    mounted() {
        this.form.token = this.tokenProp;
        this.form.email = this.emailProp;
    },
    methods: {
        passwordReset() {
            this.loader = true;
            let route = this.laroute.route('password.update');
            this.form.post(route)
                .then((res) => {

                    if(res.status = 200)
                        this.message = res.data.message;

                })
                .catch((error) => {

                });
        }
    }
}
</script>
