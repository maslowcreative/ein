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
          <button class="btn btn-light btn-icon">
            <ion-icon name="search-outline"></ion-icon>
          </button>
        </div>
      </div>
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
            <tr v-for="(admin, index) in items.data" v-bind:key="index">
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
                    <input class="form-check-input" type="checkbox" checked id="flexSwitchCheckDefault" />
                    <label class="form-check-label" for="flexSwitchCheckDefault"></label>
                  </div>
                </div>
              </td>
              <td>
                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                  <button class="btn btn-link p-0 fs-16 mx-1">
                    <ion-icon name="options-outline"></ion-icon>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4 mt-md-5">
        <advanced-laravel-vue-paginate :data="items" previousText="<<" nextText=">>" @paginateTo="getAdminList" />
      </div>
    </div>
  </div>
</template>

<script>
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate"
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css"

export default {
  components: { AdvancedLaravelVuePaginate },
  data() {
    return {
      loader: false,
      items: {},
    }
  },
  mounted() {
    //Called first time.
    this.getAdminList()

    //Called Whenever admin is added.
    this.$root.$on("ein-admin:added", () => {
      this.getAdminList()
    })
  },
  methods: {
    getAdminList(page = 1) {
      this.loader = true
      let route = this.laroute.route("ajax.admins.index", { page: page })
      axios
        .get(route)
        .then(res => {
          this.items = res.data
        })
        .catch(error => {
          console.log(error)
        })
        .finally(() => (this.loading = false))
    },
  },
  mounted() {
    this.getAdminList()
  },
  methods: {
    getAdminList(page = 1) {
      this.loader = true
      let route = this.laroute.route("ajax.admins.index", { page: page })

      axios
        .get(route)
        .then(res => {
          this.items = res.data
        })
        .catch(error => {
          console.log(error)
        })
        .finally(() => (this.loading = false))
    },
  },
}
</script>
