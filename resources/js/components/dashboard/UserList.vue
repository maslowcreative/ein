<template>
  <div class="card mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between">
        <div>
          <h5>Users</h5>
          <small class="text-primary">{{ items.total }} Active Users</small>
        </div>
        <div class="card-right-btns">
          <button class="btn btn-primary btn-icon" data-bs-toggle="modal" data-bs-target="#userModal">
            <ion-icon name="add-outline"></ion-icon> Add New User
          </button>
          <div class="dropdown">
            <button
              class="btn btn-light btn-icon"
              type="button"
              id="userSearchDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <ion-icon name="search-outline"></ion-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="userSearchDropdown">
              <div class="py-2 px-3">
                <div class="">
                  <label class="form-label">Search for a User</label>
                  <input
                    type="text"
                    class="form-control form-control-sm"
                    v-model="filters.name"
                    placeholder="Enter Users Name"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown">
            <button
              class="btn btn-light btn-icon"
              type="button"
              id="filterDropdown2"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <ion-icon name="funnel-outline"></ion-icon>
            </button>
            <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown2">
              <div class="py-2 px-3">
                <label class="form-label">Account Type</label>
                <select class="form-select form-select-sm" v-model="filters.role">
                  <option selected value="all">All</option>
                  <option value="provider">Provider</option>
                  <option value="participant">Participant</option>
                  <option value="representative">Representative</option>
                </select>
              </div>
              <div class="py-2 px-3">
                <div class="mb-3">
                  <label class="form-label">Plan Status</label>
                  <select class="form-select form-select-sm" v-model="filters.plan_status">
                    <option selected value="all">All</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
<!--                    <option value="3">New Expiry</option>-->
                  </select>
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
                <th scope="col" class="not-center">User</th>
                <th scope="col">Plan</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in items.data" v-bind:key="index">
                <td class="not-center">
                  <div class="d-flex">
                    <div class="me-4">
                      <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                    </div>
                    <div class="fw-bold">
                      {{ user.name }}
                      <span class="d-block text-primary fw-normal">{{ user.roles[0].name }}</span>
                    </div>
                  </div>
                </td>
                <td>
                  <button
                    v-if="user.roles[0].name == 'participant'"
                    class="btn btn-light btn-sm"
                    v-on:click="openPlanEdit(user.plan)"
                  >
                    Edit Plan
                  </button>
                </td>
                <td>
                  <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                    <button class="btn btn-link p-0 mx-1" v-on:click="openEditUserPopup(user,user.roles[0])">
                      <ion-icon name="create-outline"></ion-icon>
                    </button>
                    <button class="btn btn-link p-0 mx-1">
                      <ion-icon name="trash-outline"></ion-icon>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- Loader -->
        <div  v-if="this.loading" class="loader-bg">
          <div class="spinner-grow text-primary spinner-loder" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>

      <div class="mt-4 mt-md-5">
        <advanced-laravel-vue-paginate
          :data="items"
          @paginateTo="getUsersList"
          :showNextPrev="false"
          useStyle="bootstrap"
          listClass="pagination"
        />
      </div>
      <plan-popup v-bind:plan="plan" ></plan-popup>
      <edit-provider-popup></edit-provider-popup>
      <edit-participant-popup></edit-participant-popup>
      <edit-representative-popup v-bind:user="user"></edit-representative-popup>
    </div>
  </div>
</template>

<script>
import AdvancedLaravelVuePaginate from "advanced-laravel-vue-paginate"
import "advanced-laravel-vue-paginate/dist/advanced-laravel-vue-paginate.css"
import PlanPopup from "../popups/PlanPopup"

export default {
  components: { AdvancedLaravelVuePaginate, PlanPopup },
  data() {
    return {
      loading: false,
      filters: {
        name: null,
        role: "all",
        plan_status: "all",
      },
      items: {},
      plan: {
          plan_name: '',
          start_date:null,
          end_date:null,
          status:null,
      },
      user: null
    }
  },
  watch: {
    "filters.name": function(val, old) {
      this.getUsersList(1)
    },
    "filters.role": function(val, old) {
      this.getUsersList(1)
    },
    "filters.plan_status": function (val, old){
        this.getUsersList(1);
    }
  },
  mounted() {
    this.getUsersList();
    //Called Whenever admin is added.
    this.$root.$on("ein-user:added", () => {
          this.getUsersList();
    });
  },
  methods: {
    getUsersList(page = 1) {
      this.loading = true
      let data = { page: page }
      //Filtering Admin Role.
      data["filter[not_in][0]"] = 1;

      if (this.filters.name) {
        data["filter[name]"] = this.filters.name
      }
      if (this.filters.role && this.filters.role != "all") {
        data["filter[roles][0]"] = this.filters.role
      }

      if (this.filters.plan_status != 'all' && this.filters.plan_status) {
          this.filters.role = 'participant';
          data["filter[plan_status][0]"] = this.filters.plan_status;
      }

      let route = this.laroute.route("ajax.users.index", data)
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
    openPlanEdit(plan) {

        if(plan == null) {
            this.$toastr.e("Error", "No active plan exist.");
            return false;
        }
        this.plan = plan;
        if(!this.plan.plan_name) {
            this.plan.plan_name = '';
        }
        $("#editPlanModal").modal('show');
    },
    openEditUserPopup(user,role) {
        this.user = user;
        if(role.name == "representative") {
            this.$root.$emit('ein:rep-edit-popup-open',user.id);
            $("#userEditRepresentativeModal").modal('show');
        } else if( role.name == "participant" ) {
            $("#userEditParticipantModal").modal('show');
        } else if( role.name == "provider" ) {
            console.log('works');
            $("#userEditProviderModal").modal('show');
        }

    }
  },
}
</script>
