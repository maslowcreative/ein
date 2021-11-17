<template>
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>Your Providers</h5>
                    <small class="text-primary">{{ items.total }} Providers</small>
                </div>
            </div>
            <div class="loader-wrap">
                <div class="table-x-scroll">
                    <table class="table">
                        <tbody>
                        <tr v-for="(user, index) in items.data" v-bind:key="index">
                            <td class="not-center">
                                <div class="d-flex">
                                    <div class="me-4">
                                        <img src="/images/avatar.png" width="50" height="50" alt="" />
                                    </div>
                                    <div class="fw-bold">
                                        {{ user.name }}
                                        <span class="d-block text-primary fw-normal">{{ user.roles[0].name }}</span>
                                    </div>
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
            loading: false,
            filters: {
                name: null,
                role: "all",
                plan_status: "all",
            },
            items: {},
        }
    },

    mounted() {
        this.getUsersList()
    },
    methods: {
        getUsersList(page = 1) {
            this.loading = true
            let data = { page: page }
            //Filtering Admin Role.
            data["filter[not_in][0]"] = 1;
            data["filter[roles][0]"] = 'provider';

            if (this.filters.name) {
                data["filter[name]"] = this.filters.name
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
    },
}
</script>
