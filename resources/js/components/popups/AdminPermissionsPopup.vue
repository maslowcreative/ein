<template>
  <div
    class="modal fade"
    id="adminPermissionModal"
    tabindex="-1"
    data-bs-backdrop="static"
    aria-labelledby="adminPermissionModal"
    aria-hidden="true"
  >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content addUserPopup">
        <div v-if="uid" class="modal-header">
          <h4 class="modal-title" id="adminModalTitle">Admin Permissions</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" v-if="permissions">
          <form @submit.prevent="updatePermissions" method="POST">
            <div class="row">
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Provider Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="permissions.edit_provider_profiles" type="checkbox"  checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Participants Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="permissions.edit_participants_profiles" type="checkbox"  checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Edit Representatives Profiles</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-model="permissions.edit_representatives_profiles" type="checkbox"  checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Approving Claims</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" v-model="permissions.approving_claims"  checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <label class="fw-bold">Export / Import Documents</label>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" v-model="permissions.export_import_documents" checked />
                    <label class="form-check-label" ></label>
                  </div>
                </div>
              </div>
              <div class="mw290 mx-auto px-4 mt-3">
                <button v-if="!loader" class="btn btn-primary btn-lg w-100 py-3">Update Permissions</button>
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
  props: ['uid','permissions'],
  data() {
    return {
      loader: false
    }
  },
  mounted() {},
  methods: {
    updatePermissions() {
      this.loader = true
      let route = this.laroute.route("ajax.admins.update.permission")
      let form = new Form({
          'user_id': this.uid,
          'permissions': this.permissions
      });

      form
        .post(route)
        .then(res => {
            this.$toastr.s("Success", "Permissions updated!")
        })
        .catch(error => {
          this.$toastr.e("Error", "Some thing went wrong.")
        })
        .finally(() => {
          this.loader = false
        });
    },

  },
}
</script>
