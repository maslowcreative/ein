<template>
    <div
        class="modal fade"
        id="providerBudgetAllocationPopup"
        tabindex="-1"
        data-bs-backdrop="static"
        aria-labelledby="adminModalTitle"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content addUserPopup">
                <div class="modal-header">
                    <h4 class="modal-title" id="editPlanModalTitle" v-if="user">{{ user.name }}: Budget Allocation</h4>
                    <button type="button" class="btn-close" v-on:click="closePopup()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6" v-if="catName && budget">
                            <label class="form-label fw-bold">{{ catName }}</label> : ${{ budget }}
                        </div>
                        <div class="col-md-6"><label class="form-label fw-bold">Remaining Budget</label>: ${{remainingBudget}}</div>
                    </div>

                    <div class="grid align-items-end mb-3" v-for="(provider,index) in providersCollection"  :key="index" style="--template: 1fr 1fr 60px">
                        <div>
                            <label class="form-label fw-bold">Provider</label>
                            <multiselect
                                v-model="provider.providerItemsResultSelected"
                                placeholder="Search or add item"
                                label="name"
                                track-by="id"
                                :options="provider.providerItemsResult"
                                :multiple="false"
                                :taggable="false"
                                :searchable="true"
                                :loading="provider.loader"
                                :internal-search="false"
                                :clear-on-select="false"
                                :close-on-select="true"
                                :options-limit="50"
                                :limit="15"
                                @search-change="(name) => getProviderList(name,provider)"
                            >
                            </multiselect>
                            <!-- <div class="invalid-msg" v-if="form.errors.has('participant.representative_id')" v-html="form.errors.get('participant.representative_id').replace('participant.representative id','representative')" />-->
                        </div>
                        <div>
                            <label>Budget</label>
                            <input class="form-control" type="number"  v-model="provider.budget" />
                        </div>
                        <div>
                            <button class="btn btn-danger" v-on:click="deleteProvider(index)">
                                <ion-icon name="close"></ion-icon>
                            </button>
                        </div>
                    </div>
                    <div class="text-end mb-3">
                        <button class="btn btn-primary" v-on:click="addProviderToBudget()">
                            <ion-icon name="add-outline"></ion-icon> Add provider
                        </button>

                        <button class="btn btn-primary" v-on:click="addProviderToBudget()">
                            <ion-icon name="add-outline"></ion-icon> Update
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    components: { Multiselect },
    data() {
        return {
            loader: false,
            user: null,
            plan: null,
            form: null,
            catName : null,
            budget : null,
            remainingBudget : 0,
            providersCollection : [],

        }
    },
    mounted() {
        this.$root.$on("ein:provider-budget-allocation-popup-open", (data) => {
            this.user = data.user;
            this.plan = data.plan;
            this.form = data.form;
            this.catName = data.catName;
            this.budget = data.budget;

            this.remainingBudget = 0,
            this.providersCollection =  [];
        });
    },
    watch:{
        providersCollection: {
            handler(newVal, oldVal) {
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
        addProviderToBudget()
        {
            this.providersCollection.push({
                providerItemsResultSelected : null,
                providerItemsResult: [],
                budget: 0,
                loading: false,
            });
        },
        getProviderList(name,provider) {
            provider.loading = true;

            let data = {
                page: 1,
                "filter[name]": name,
                "filter[roles][0]": 'provider',
            }

            if (name) {
                data["filter[name]"] = name;
            }


            let route = this.laroute.route("ajax.users.index", data)
            axios
                .get(route)
                .then(res => {
                    provider.providerItemsResult = res.data.data
                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (provider.loading = false))
        },
        closePopup(){
            $("#providerBudgetAllocationPopup").modal("hide");
            let data = {
                plan: this.plan,
                form : this.form,
                user : this.user
            }
            this.$root.$emit("ein:participant-plan-edit-popup-open", data);
            $("#editPlanModal").modal("show");
        },
        parseFloatValue(val){
            val = parseFloat(val);
            if(isNaN(val)){
                val = 0;
            }
            return val;
        },
        deleteProvider(index){
            this.providersCollection.splice(index, 1);

            let usedBudet = 0;
            this.providersCollection.forEach((provider, index) => {
                usedBudet = this.parseFloatValue(usedBudet) +  this.parseFloatValue(provider.budget) ;
            });
            this.remainingBudget = this.budget - this.parseFloatValue(usedBudet);
        }
    },
}
</script>
