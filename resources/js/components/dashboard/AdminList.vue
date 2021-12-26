<template>
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h5>Sub-Admins</h5>
          <small class="text-primary">{{ items.total }} Sub-admins</small>
        </div>
        <div class="card-right-btns">
          <button class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#adminModal">
            <ion-icon name="add-outline"></ion-icon> Add New Admin
          </button>
            <div class="dropdown">
                <button
                    class="btn btn-light btn-icon"
                    type="button"
                    id="adminSearchDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <ion-icon name="search-outline"></ion-icon>
                </button>
                <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="adminSearchDropdown">
                    <div class="py-2 px-3">
                        <div class="">
                            <label class="form-label">Search for a Admin</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                v-model="filters.name"
                                placeholder="Enter Admin Name"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
      <div class="loader-wrap">
        <div class="table-x-scroll">
        <table class="table">
          <thead>
            <tr>
              <th scope="col" class="not-center">Sub-Admin</th>
              <th scope="col">Enable/Disable Admin</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="admin in items.data">
              <td class="not-center">
                <div class="d-flex">
                  <div class="me-4">
                    <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                  </div>
                  <div class="fw-bold">
                    {{ admin.name }}
                    <span class="d-block text-primary fw-normal">{{ admin.roles[0].name }}</span>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-inline-block">
                  <div class="form-check form-switch">
                    <input class="form-check-input" v-on:change="onChange($event,admin.id)" type="checkbox" v-model="admin.status" id="flexSwitchCheckDefault" />
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                  <button class="btn btn-link p-0 fs-16 mx-1" v-on:click="openPermissionPopup(admin)">
                    <ion-icon name="options-outline"></ion-icon>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
        <!-- Loader -->
        <div  v-if="this.loader" class="loader-bg">
          <div class="spinner-grow text-primary spinner-loder" role="status">
              <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="mt-4 mt-md-5">
            <advanced-laravel-vue-paginate
                :data="items"
                @paginateTo="getAdminList"
                :showNextPrev="false"
                useStyle="bootstrap"
                listClass="pagination"
            />
      </div>
      <admin-permissions-popup v-bind:uid="adminId" v-bind:permissions="permissions"></admin-permissions-popup>
    </div>
  </div>
</template>

<script>

import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate";
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css";
import Form from "vform";

export default {
  components: { AdvancedLaravelVuePaginate },
  data() {
    return {
      loader: false,
      adminId: null,
       permissions: {
          edit_provider_profiles: false,
          edit_participants_profiles : false,
          edit_representatives_profiles: false,
          approving_claims: false,
          export_import_documents: false
      },
      items: {},
      filters: {
        name: null,
      },
    }
  },
  watch: {
      "filters.name": function (val, old) {
          this.getAdminList(1)
      },
  } ,
  mounted() {
    //Called first time.
    this.getAdminList()

    //Called Whenever admin is added.
    this.$root.$on("ein-admin:added", () => {
      this.getAdminList();
    })
  },
  methods: {
    getAdminList(page = 1) {
      this.loader = true
      let data = { page: page }
      //Filtering Admin Role.
      data["filter[not_in][0]"] = 1;
      data["filter[not_in][1]"] = 2;
      data["filter[not_in][2]"] = 3;
      data["filter[not_in][3]"] = 4;
      if (this.filters.name) {
        data["filter[name]"] = this.filters.name;
      }
      let route = this.laroute.route("ajax.admins.index", data)
      axios
        .get(route)
        .then(res => {
          this.items = res.data
        })
        .catch(error => {
          console.log(error)
        })
        .finally(() => (this.loader = false))
    },
    onChange: function(e,userId){
        let form = new Form({
            status: e.target.checked ? 1 : 0,
            user_id: userId
        });
        let status = e.target.checked ? 'Enabled' : 'Disabled';
        let route = this.laroute.route("ajax.user.status.toggle")
        form
           .post(route)
           .then(res => {
              this.$toastr.s("Success", "User "+status+ " successfully!")
           })
           .catch(error => {
               this.$toastr.e("Error", "Some thing went wrong.")
           })
           .finally(() => {
           })
    },
    openPermissionPopup: function (admin){
        this.permissions = {
            edit_provider_profiles: false,
                edit_participants_profiles : false,
                edit_representatives_profiles: false,
                approving_claims: false,
                export_import_documents: false
        };
        admin.permissions.forEach((item, index) => {
            this.permissions[item.name] = true;
        });
        this.adminId = admin.id;
        $("#adminPermissionModal").modal('show');
    }
  },
}
</script>
