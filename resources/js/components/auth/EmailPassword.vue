<template>
  <div class="grid login-box-wrap">
    <div class="login-box">
      <auth-logo></auth-logo>
      <div class="login-box-from">
        <h2 class="mb-md-5 mb-3 fw-bold">Forgot your password?</h2>
        <p class="mb-md-5 mb-3">
          Enter your e-mail address and we will send you an email with a link to reset your password.
        </p>
        <div v-if="message" class="alert alert-success" role="alert">
          {{ message }}
        </div>

        <form @submit.prevent="emailResetLink" method="POST">
          <div class="mb-3">
            <!-- <label for="email" class="col-form-label">E-Mail Address</label> -->
            <div class="input-group-overlay">
              <div class="input-group-prepend-overlay">
                <span class="input-group-text text-primary"><i class="far fa-envelope"></i></span>
              </div>
              <input
                id="email"
                type="email"
                class="form-control prepended-form-control"
                name="email"
                placeholder="E-Mail Address"
                v-model="form.email"
                required
                autocomplete="email"
                autofocus
              />
              <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
            </div>
          </div>

          <div class="d-grid gap-3">
            <button type="submit" class="btn btn-primary btn-lg">
              Send Password Reset Link
            </button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a class="text-decoration-none" :href="loginUrl">Back to Login</a>
      </div>
    </div>
  </div>
</template>
<script>
import Form from "vform"
import AuthLogo from "./AuthLogo";
export default {
    components: {AuthLogo},
    data() {
        return {
          loader: false,
          message: null,
          loginUrl: null,
          form: new Form({
            email: null,
          }),
        }
    },
  mounted() {
        this.loginUrl = this.laroute.route('login');
  },
  methods: {
    emailResetLink() {
      this.message = null
      this.loader = true
      let route = this.laroute.route("password.email")
      this.form
        .post(route)
        .then(res => {
          this.loader = false
          this.message = res.data.message
        })
        .catch(error => {
          this.loader = false
        })
    },
  },
}
</script>
