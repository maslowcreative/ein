<template>
  <div class="grid login-box-wrap">
    <div class="login-box">
      <auth-logo></auth-logo>
      <div class="login-box-from">
        <h2 class="mb-md-5 mb-3 text-center fw-bold">Reset Password</h2>
        <div v-if="message" class="alert alert-success" role="alert">
          {{ message }}
        </div>

        <form method="POST" @submit.prevent="passwordReset">
          <input type="hidden" name="token" v-model="form.token" />

          <div class="mb-3">
            <label for="email" class="col-form-label">E-Mail Address</label>
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

          <div class="mb-4">
            <label for="password" class="col-form-label">Password</label>
            <div class="input-group-overlay">
              <div class="input-group-prepend-overlay">
                <span class="input-group-text text-primary"><i class="fas fa-lock-open"></i></span>
              </div>
              <input
                id="password"
                type="password"
                v-model="form.password"
                class="form-control prepended-form-control"
                name="password"
                required
                autocomplete="current-password"
              />
            </div>
            <div class="invalid-msg" v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
          </div>

          <div class="mb-4">
            <label for="password" class="col-form-label">Password</label>
            <div class="input-group-overlay">
              <div class="input-group-prepend-overlay">
                <span class="input-group-text text-primary"><i class="fas fa-lock-open"></i></span>
              </div>
              <input
                id="password"
                type="password"
                name="password_confirmation"
                v-model="form.password_confirmation"
                class="form-control prepended-form-control"
                required
                autocomplete="current-password"
              />
            </div>
            <div
              class="invalid-msg"
              v-if="form.errors.has('password_confirmation')"
              v-html="form.errors.get('password_confirmation')"
            />
          </div>
          <div class="d-grid gap-3">
            <button type="submit" class="btn btn-primary btn-lg">
              Reset Password
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform"

export default {
  props: ["tokenProp", "emailProp"],
  data() {
    return {
      loader: false,
      message: null,
      form: new Form({
        token: null,
        email: null,
        password: null,
        password_confirmation: null,
      }),
    }
  },
  mounted() {
    this.form.token = this.tokenProp
    this.form.email = this.emailProp
  },
  methods: {
    passwordReset() {
      this.loader = true
      let route = this.laroute.route("password.update")
      this.form
        .post(route)
        .then(res => {
          if ((res.status = 200)){
              this.message = res.data.message;
              window.location.reload();
          }
        })
        .catch(error => {})
    },
  },
}
</script>
