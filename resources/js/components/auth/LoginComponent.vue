<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>

                    <div class="card-body">
                        <form @submit.prevent="login" method="POST">
                            <csrf-token></csrf-token>
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>


                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="form.email" class="form-control" name="email" required autocomplete="email" autofocus>
                                    <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="form.password" class="form-control " name="password" required autocomplete="current-password">
                                    <div v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
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
            form: new Form({
                email: null,
                password: null
            }),

        }
    },
    mounted() {
        this.loginUrl = this.laroute.route('login');

    },
    methods:{
         login() {
            this.loader = true;
            let route = this.laroute.route('login');
            this.form.post(route)
                    .then((res) => {
                        if(res.status = 204){
                            window.location.reload();
                        }
                    })
                    .catch((error) => {

                    });

        }
    }
}
</script>
