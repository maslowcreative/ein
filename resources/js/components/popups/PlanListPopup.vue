<template>
    <div class="modal fade" id="planList" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">User Plans</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body scroll-y py-0 loader-wrap"  style="--box-height: 600px" >
                    <div v-if="this.loader" class="loader-bg">
                        <div class="spinner-grow text-primary spinner-loder" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" class="not-center sticky-top bg-white">Start</th>
                            <th scope="col" class="not-center sticky-top bg-white">End</th>
                            <th scope="col" class="sticky-top bg-white">Status</th>
                            <th scope="col" class="sticky-top bg-white" width="150">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="plans"  v-for="plan in plans"  >
                            <td class="not-center">{{ plan.start_date }}</td>
                            <td class="not-center">{{ plan.end_date }}</td>
                            <td>
                                <span v-if="!plan.status" class="badge rounded-pill bg-danger mx-1">Inactive</span>
                                <span v-if="plan.status" class="badge rounded-pill bg-primary mx-1">Status</span>
                            </td>
                            <td>
                                <div class="d-inline-flex flex-nowrap align-items-center justify-content-around btn-group fs-lg">
                                    <button class="btn btn-link p-0 mx-1" v-on:click="openPlanEdit(plan)">
                                        <ion-icon name="create-outline"></ion-icon>
                                    </button>
<!--                                    <button class="btn btn-link p-0 mx-1">-->
<!--                                        <ion-icon name="trash-outline"></ion-icon>-->
<!--                                    </button>-->
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">New Plan</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import PlanPopup from "./PlanPopup";
export default {
    components: {PlanPopup},
    data() {
        return {
            loader: true,
            plans : null,
        }
    },
    mounted() {
        this.$root.$on("ein:participant-plan-list-popup-open", (user) => {
            this.getPlansList(user.id);
        });
    },
    methods: {
        getPlansList(userId){
            this.loader = true
            let data = { user_id: userId }

            let route = this.laroute.route("ajax.plans.index", data)
            axios
                .get(route)
                .then(res => {
                    this.plans = res.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loader = false))
        },
        openPlanEdit(plan) {
            this.$root.$emit("ein:participant-plan-edit-popup-open", plan);
            $("#planList").modal("hide");
            $("#editPlanModal").modal("show");
        },
        parseFloatValue(val){
            val = parseFloat(val);
            if(isNaN(val)){
                val = 0;
            }
            return val;
        },
    },
}
</script>
