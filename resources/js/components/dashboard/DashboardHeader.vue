<template>
  <div>
    <h1 class="h2 mb-4 fw-bold pb-2">Dashboard</h1>
    <div class="qo-section bg-primary text-white">
      <h4 class="fw-bold">Quick Options</h4>
      <p>Choose one of the quick options for easier navigation</p>

      <div class="grid options-grid">
        <a href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#userModal">
          <ion-icon name="person-add-outline" class="option-item-icon"></ion-icon>
          Add New User
        </a>
        <a href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#adminModal">
          <span class="option-item-icon">
            <span class="admin-icon">
              <ion-icon name="person-add-outline" class=""></ion-icon>
              <ion-icon name="cog-outline" class="icon-cog"></ion-icon>
            </span>
          </span>
          Add New Admin
        </a>
        <a href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#fileUpload">
          <ion-icon name="push-outline" class="option-item-icon"></ion-icon>
          Bulk Upload
        </a>
        <a href="#" class="option-item">
          <ion-icon name="push-outline" class="flip-v option-item-icon"></ion-icon>
          Bulk Download
        </a>
      </div>
    </div>
    <create-user-popup></create-user-popup>
    <create-admin-popup></create-admin-popup>

    <!-- File upload -->

    <div class="modal" id="fileUpload" tabindex="-1" aria-labelledby="filePopupTitle" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="px-3 py-2 text-end">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <h3>Upload Claim Reconciliations</h3>
            <div class="input-group-overlay">
              <div class="input-group-prepend-overlay">
                <span class="input-group-text text-primary"><ion-icon name="document-attach-outline"></ion-icon></span>
              </div>
              <input
                type="text"
                class="form-control prepended-form-control"
                placeholder="Drag & Drop File Here"
                aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default"
              />
            </div>
            <button class="btn btn-primary">Upload File</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CreateAdminPopup from "../popups/CreateAdminPopup"
import CreateUserPopup from "../popups/CreateUserPopup"

export default {
  components: { CreateUserPopup, CreateAdminPopup },
  data() {
    return {}
  },
  mounted() {},
}
</script>
