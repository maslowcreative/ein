<template>
  <div
    class="modal fade"
    id="adminModal"
    tabindex="-1"
    data-bs-backdrop="static"
    aria-labelledby="adminModalTitle"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div class="modal-header">
          <h4 class="modal-title" id="adminModalTitle">Create a new Sub-admin</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="createAdmin" method="POST">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <label  class="form-label">First Name</label>
                  <input type="text" v-model="form.first_name" class="form-control"  placeholder="admin first name" />
                  <div class="invalid-msg" v-if="form.errors.has('first_name')" v-html="form.errors.get('first_name')" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label  class="form-label">Last Name</label>
                  <input type="text" v-model="form.last_name" class="form-control"  placeholder="admin last name" />
                  <div class="invalid-msg" v-if="form.errors.has('last_name')" v-html="form.errors.get('last_name')" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label  class="form-label">E-mail Address</label>
                  <input
                    type="email"
                    v-model="form.email"
                    class="form-control"
                    placeholder="admin email"
                  />
                  <div class="invalid-msg" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label">Enter Password</label>
                  <input
                    type="password"
                    class="form-control"
                    v-model="form.password"

                    placeholder="*********************"
                  />
                  <div class="invalid-msg" v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label  class="form-label">Confirm Password</label>
                  <input type="password" v-model="form.password_confirmation" class="form-control"  placeholder="*********************" />
                  <div class="invalid-msg" v-if="form.errors.has('password_confirmation')" v-html="form.errors.get('password_confirmation')" />
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Provider Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="form.permissions.edit_provider_profiles" type="checkbox" checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Participants Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="form.permissions.edit_participants_profiles" type="checkbox" id="editOption2" checked />
                    <label class="form-check-label" for="editOption2"></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Representatives Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="form.permissions.edit_representatives_profiles" type="checkbox" id="editOption3" checked />
                    <label class="form-check-label" for="editOption3"></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Approving Claims</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" v-model="form.permissions.approving_claims" id="editOption4" checked />
                    <label class="form-check-label" for="editOption4"></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Export / Import Documents</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" v-model="form.permissions.export_import_documents" id="editOption5" checked />
                    <label class="form-check-label" for="editOption5"></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="fw-bold">Add / Edit Plans</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" v-model="form.permissions.add_edit_plans"  checked />
                        <label class="form-check-label" for="editOption5"></label>
                    </div>
                </div>
              </div>
              <div class="mw290 mx-auto px-4 mt-3">
                <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3">Create Sub-admin</button>
                <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  Loading...
                </button>
              </div>
            </div>
          </form>
          <div class="step-final d-flex justify-content-center align-items-center flex-column d-none">
            <ion-icon name="checkmark-circle-outline" class="final-icon"></ion-icon>
            <h4>New Sub-Admin Created!</h4>
            <div class="mw290 mx-auto px-4 w-100">
              <button class="btn btn-primary btn-lg w-100 py-3">Back to Dashboard</button>
            </div>
          </div>
        </div>
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
      form: new Form({
        first_name: null,
        last_name: null,
        email: null,
        password: null,
        password_confirmation: null,
        random_password: false,
        role_id: 5,
        permissions: {
            edit_provider_profiles: true,
            edit_participants_profiles : true,
            edit_representatives_profiles: true,
            approving_claims: true,
            export_import_documents: true,
            add_edit_plans: true
        },
      }),
    }
  },
  mounted() {},
  methods: {
    createAdmin() {
      this.loader = true
      let route = this.laroute.route("ajax.users.store")
      this.form
        .post(route)
        .then(res => {
          if ((res.status = 201)) {
            this.resetForm()
            this.$root.$emit("ein-admin:added")
            this.$toastr.s("Success", "Account created!")
          }
        })
        .catch(error => {
          this.$toastr.e("Error", "Some thing went wrong.")
        })
        .finally(() => {
          this.loader = false
        })
    },
    resetForm() {
      this.form = new Form({
          first_name: null,
          last_name: null,
          email: null,
          password: null,
          password_confirmation: null,
          random_password: false,
          role_id: 5,
          permissions: {
              edit_provider_profiles: true,
              edit_participants_profiles : true,
              edit_representatives_profiles: true,
              approving_claims: true,
              export_import_documents: true,
              add_edit_plans: true
          },
      })
    },
  },
}
</script>
