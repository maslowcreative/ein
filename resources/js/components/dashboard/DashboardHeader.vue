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
                <a href="#" class="option-item">
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
    </div>
</template>

<script>
import CreateAdminPopup from "../popups/CreateAdminPopup";
import CreateUserPopup from "../popups/CreateUserPopup";
export default {
    components: {CreateUserPopup, CreateAdminPopup},
    data() {
        return {

        }
    },
    mounted() {

    }
}
</script>
