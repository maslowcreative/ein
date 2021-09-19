<template>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Users</h5>
                    <small class="text-primary">9999 Active Users</small>
                </div>
                <div class="card-right-btns">
                    <button class="btn btn-primary btn-icon">
                        <ion-icon name="add-outline"></ion-icon> Add New User
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-light btn-icon" type="button" id="userSearchDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="userSearchDropdown">
                            <div class="py-2 px-3">
                                <div class="">
                                    <label class="form-label">Search for a User</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Enter Users Name">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light btn-icon" type="button" id="filterDropdown2" data-bs-toggle="dropdown"
                                aria-expanded="false">
                            <ion-icon name="funnel-outline"></ion-icon>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="filterDropdown2">
                            <div class="py-2 px-3">
                                <div class="mb-3">
                                    <label class="form-label">Claim Status</label>
                                    <select class="form-select form-select-sm">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                                <div class="">
                                    <label class="form-label">Claim Status</label>
                                    <select class="form-select form-select-sm">
                                        <option selected>All</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    <tr v-for="user in users">
                        <td class="not-center">
                            <div class="d-flex">
                                <div class="me-4">
                                    <img :src="'/images/avatar.png'" width="50" height="50" alt="" />
                                </div>
                                <div class="fw-bold">
                                    {{user.name}}
                                    <span class="d-block text-primary fw-normal">{{user.roles[0].name}}</span>
                                </div>
                            </div>
                        </td>
                        <td><button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editPlanModal">Edit
                            Plan</button></td>
                        <td>
                            <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                                <button class="btn btn-link p-0 mx-1">
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
            <div class="mt-4 mt-md-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="#">100</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <plan-popup></plan-popup>
    </div>
</template>

<script>
import PlanPopup from "../popups/PlanPopup";
export default {
    components: {PlanPopup},
    data() {
        return {
            loading: false,
            users : null,
        }
    },
    mounted() {
        this.getUsersList();
    },
    methods: {
        getUsersList() {
            this.loading = true;
            let route = this.laroute.route("ajax.users.index");
            axios.get(route)
                .then(res => {
                    this.users = res.data.data;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => this.loading = false);

        },
    },
}
</script>
