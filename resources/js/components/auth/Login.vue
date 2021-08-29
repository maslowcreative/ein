<template>
  <div class="grid login-box-wrap">
    <div class="login-box">
      <div class="login-box-logo text-center">
        <img :src="'/images/logo.png'" width="141" height="103" alt="" />
      </div>
      <div class="login-box-from">
        <h2 class="mb-md-5 mb-3 text-center fw-bold">Portal Log-in</h2>
        <form @submit.prevent="login" method="POST">
          <csrf-token></csrf-token>
          <div class="mb-4">
            <label for="email" class="col-form-label">E-mail Address</label>
            <div class="input-group-overlay">
              <div class="input-group-prepend-overlay">
                <span class="input-group-text text-primary"><i class="far fa-envelope"></i></span>
              </div>
              <input
                id="email"
                type="email"
                v-model="form.email"
                class="form-control prepended-form-control"
                name="email"
                required
                autocomplete="email"
                autofocus
              />
            </div>
            <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
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

          <div class="d-grid gap-3">
            <div><a class="text-secondary" :href="passwordRequestUrl">Forgot Your Password?</a></div>
            <button type="submit" class="btn btn-primary btn-lg">Login</button>
          </div>
        </form>
      </div>
      <div class="text-center">
        <a class="text-decoration-none" :href="passwordRequestUrl">Back to EIN Homepage</a>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform"
export default {
  data() {
    return {
      loader: false,
      passwordRequestUrl: null,
      form: new Form({
        email: null,
        password: null,
      }),
    }
  },
  mounted() {
    this.passwordRequestUrl = this.laroute.route("password.request")
  },
  methods: {
    login() {
      this.loader = true
      let route = this.laroute.route("login")
      this.form
        .post(route)
        .then(res => {
          if ((res.status = 204)) {
            window.location.reload()
          }
        })
        .catch(error => {})
    },
  },
}
</script>
