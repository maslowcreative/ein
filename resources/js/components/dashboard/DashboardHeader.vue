<template>
  <div>

    <div class="qo-section bg-primary text-white">
<!--      <h1 class="h2 mb-4 fw-bold pb-2">Dashboard</h1>-->
      <h4 class="fw-bold">Dashboard</h4>
      <div class="grid options-grid">
        <a v-if="getPermission('add_invoices_receipts')" href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#adminProviderInvoicePopup">
<!--          <ion-icon name="person-add-outline" class="option-item-icon"></ion-icon>-->
          <ion-icon name="receipt-outline" class="option-item-icon"></ion-icon>
          + New Invoice
        </a>
        <a  v-if="getPermission('add_invoices_receipts')" href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#adminRepReceiptPopup">
          <span class="option-item-icon">
            <span class="admin-icon">
              <ion-icon name="newspaper-outline" class="option-item-icon"></ion-icon>

            </span>
          </span>
            + New Receipt
        </a>
        <a v-if="getPermission('export_import_documents')" href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#fileUpload">
          <ion-icon name="push-outline" class="option-item-icon"></ion-icon>
          Reconcile
        </a>
        <a v-if="getPermission('export_import_documents')" href="#" class="option-item" data-bs-toggle="modal" data-bs-target="#fileDownload">
          <ion-icon name="push-outline" class="flip-v option-item-icon"></ion-icon>
          Download
        </a>
      </div>
    </div>
    <create-user-popup></create-user-popup>
    <create-admin-popup></create-admin-popup>

    <!-- File upload -->

    <div class="modal" id="fileUpload" tabindex="-1" aria-labelledby="filePopupTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="px-3 pt-3 text-end">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <h3 id="filePopupTitle">Upload Claim Reconciliations</h3>
            <div class="mx-md-5 px-md-5 my-4 pt-2">
              <div class="input-group-overlay">
                <div class="input-group-prepend-overlay">
<!--                  <span class="input-group-text text-primary"-->
<!--                    ><ion-icon name="document-attach-outline"></ion-icon-->
<!--                  ></span>-->
                </div>
                <input
                  type="file"
                  class="form-control prepended-form-control"
                  v-on:change="onFileChange"
                  placeholder="Drag & Drop File Here"
                  aria-label="Sizing example input"
                  aria-describedby="inputGroup-sizing-default"
                />
              </div>
            </div>

            <div>
              <div class="text-center text-primary">
<!--                <ion-icon name="checkmark" role="img" class="md hydrated" aria-label="checkmark"></ion-icon> FileUploaded!-->
              </div>
            </div>
            <div class="mw290 mx-auto px-4 mt-3 mb-4">
                <button v-if="!loader" type="button" v-on:click="uploadReconciledFile()" class="btn btn-primary btn-lg w-100 py-3">Upload File</button>
                <button v-else class="btn btn-primary btn-lg w-100 py-3" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>

            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Download File Popup -->

    <div class="modal" id="fileDownload" tabindex="-1" aria-labelledby="downloadPopupTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="px-3 pt-3 text-end">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <h3 class="downloadPopupTitle">Download Files</h3>

            <div class="mw290 mx-auto px-4 mt-5 mb-4">
                <a  :href="laroute.route('ajax.claims.reconciled.results.file')" class="btn btn-primary btn-lg w-100 py-3">For Bank</a>
                <a  :href="laroute.route('ajax.claims.bulk.upload.file')" class="btn btn-primary btn-lg w-100 py-3 mt-3">For PRODA</a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CreateAdminPopup from "../popups/CreateAdminPopup"
import CreateUserPopup from "../popups/CreateUserPopup"
import Form from "vform";

export default {
  props:["policy"],
  components: { CreateUserPopup, CreateAdminPopup },
  data() {
    return {
        loader: false,
        form: new Form({
            file: {},
        }),
    }
  },
  mounted() {
  },
  methods: {
      onFileChange(e) {
          var files = e.target.files || e.dataTransfer.files;
          if (!files.length)
              return;
          this.form.file = files[0];
      },
      uploadReconciledFile()  {
          this.loader = true;
          let route = this.laroute.route("ajax.claims.upload.reconciled.file",);
          this.form
              //.post(route)
              .post( route,null,{ headers: { 'Content-Type': 'multipart/form-data'}} )
              .then(res => {
                  this.loader = false;
                  this.$toastr.s('Success','Reconciled file proccessed succesfully');
              })
              .catch(error => {
                  this.$toastr.e("Error", "Some thing went wrong.")
              })
              .finally(() => {
                  this.loader = false;
              });
      },
      getPermission(pName) {
          if(this.policy.is_supper_admin){
              return true;
          }
          return this.policy.permissions[pName];
      }
  }
}
</script>
