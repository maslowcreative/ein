<template>
    <div
        class="modal fade"
        id="providerBudgetAllocationListPopup"
        tabindex="-1"
        data-bs-backdrop="static"
        aria-labelledby="adminModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" v-if="category_name">{{ category_name }} </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-x-scroll">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col" class="not-center">Provider</th>
                                <th scope="col" class="not-center">Budget</th>
                                <th scope="col" class="not-center">Spent</th>
                                <th scope="col" class="not-center">Processing</th>
                                <th scope="col" class="not-center">Balance</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="row in list">
                                <td class="not-center">{{row.user.other_name}}</td>
                                <td class="not-center">${{row.amount}}</td>
                                <td class="not-center">${{row.spent}}</td>
                                <td class="not-center">${{row.pending}}</td>
                                <td class="not-center">${{row.balance}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
import Form from "vform"
export default {
    components: { Multiselect },
    data() {
        return {
            loader: false,
            category_name:null,
            list : [],
        }
    },
    mounted() {
        this.$root.$on("ein:provider-budget-allocation-list-popup-open", (data) => {

            this.category_name = data.category_name;
            let dataApi = {
                category_id: data.category_id,
                plan_id: data.plan_id,
            };

            let route = this.laroute.route("ajax.get.budget.allocation", dataApi)
            axios
                .get(route)
                .then(res => {
                     this.list = res.data;
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loader = false))


        });
    },
    watch:{
        "form.providers_collection": {
            handler(newVal, oldVal) {
                //alert('asssa');
                let usedBudet = 0;
                newVal.forEach((provider, index) => {
                    usedBudet = this.parseFloatValue(usedBudet) +  this.parseFloatValue(provider.budget) ;
                });
                this.remainingBudget = this.budget - this.parseFloatValue(usedBudet);

            },
            deep: true
        },
    },
    methods: {



    },

}
</script>
