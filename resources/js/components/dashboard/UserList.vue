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
                        <button class="btn btn-light btn-icon">
                            <ion-icon name="funnel-outline"></ion-icon>
                        </button>
                        <button class="btn btn-light btn-icon">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Plan</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>
                            <div class="fw-bold">
                                {{user.name}}
                                <span class="d-block text-primary fw-normal">{{user.roles[0].name}}</span>
                            </div>
                        </td>
                        <td><button v-if="user.roles[0].name == 'participant'" class="btn btn-light btn-sm">Edit Plan</button></td>
                        <td>
                            <div class="d-flex flex-nowrap justify-content-around">
                                <button class="btn btn-link p-0">
                                    <ion-icon name="create-outline"></ion-icon>
                                </button>
                                <button class="btn btn-link p-0">
                                    <ion-icon name="trash-outline"></ion-icon>
                                </button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>


</template>

<script>
export default {
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
