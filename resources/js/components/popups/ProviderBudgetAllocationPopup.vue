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
                        <div class="col-md-6"><label class="form-label fw-bold">Remaining Budget </label>: ${{roundedRemainingBudget}}</div>
                    </div>

                    <div class="grid align-items-end mb-3" v-for="(provider,index) in form.providers_collection"  :key="index" style="--template: 1fr 1fr 60px">
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
                             <div class="invalid-msg" v-if="form.errors.has('providers_collection.'+index+'.providerItemsResultSelected.id')" v-html="form.errors.get('providers_collection.'+index+'.providerItemsResultSelected.id').replace('providers_collection.'+index+'.providerItemsResultSelected.id','provider')" />
                        </div>
                        <div>
                            <label>Budget</label>
                            <input 
                                class="form-control" 
                                type="number"  
                                v-model="provider.budget" 
                                @input="limitDecimalPlaces(provider, index)"
                            />
                            <div class="invalid-msg" v-if="form.errors.has('providers_collection.'+index+'.budget')" v-html="form.errors.get('providers_collection.'+index+'.budget').replace('providers_collection.'+index+'.budget','budget')" />

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

                        <button class="btn btn-primary" v-on:click="updateProviderBudgetAllocation()">
                            <ion-icon name="save-outline"></ion-icon> Update

                        </button>
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
            user: null,
            plan: null,
            catName : null,
            budget : null,
            remainingBudget : 0,
            backform:null,
            form: new Form({
                plan_id : null,
                category_id : null,
                participant_id : null,
                providers_collection : [],
            }),
        }
    },
    mounted() {
        this.$root.$on("ein:provider-budget-allocation-popup-open", (data) => {
            this.form =  new Form({
                plan_id : null,
                category_id : null,
                participant_id : null,
                providers_collection : [],
            });

            this.user = data.user;
            this.plan = data.plan;
            this.backform = data.form;
            this.catName = data.catName;
            this.budget = data.budget;
            this.form.category_id = data.catId;
            this.form.plan_id = data.plan.id;
            this.form.participant_id = this.user.id;

            let dataApi = {
                category_id: data.catId,
                plan_id: data.plan.id,
            };


            let route = this.laroute.route("ajax.get.budget.allocation", dataApi)
            axios
                .get(route)
                .then(res => {
                    let d = res.data;

                    d.forEach((item, index) => {
                        this.form.providers_collection.push({
                            providerItemsResultSelected : item.user,
                            providerItemsResult: [],
                            budget: item.amount,
                            loading: false,
                        });
                    });


                })
                .catch(error => {
                    console.log(error)
                })
                .finally(() => (this.loader = false))

            // this.remainingBudget = 0,
            //console.log('this is plan data',data.plan);
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
    computed: {
        roundedRemainingBudget() {
            try {
                return this.remainingBudget.toFixed(2);
            } catch (e) {
                console.error("Error rounding remaining budget:", e);
                return this.remainingBudget;
            }
        }
    },
    methods: {
        limitDecimalPlaces(provider, index) {
            let value = provider.budget.toString();
            if (value.includes('.')) {
                let parts = value.split('.');
                if (parts[1].length > 2) {
                    provider.budget = parseFloat(parts[0] + '.' + parts[1].substring(0, 2));
                }
            }
        },
        addProviderToBudget()
        {
            this.form.providers_collection.push({
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
                form : this.backform,
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
            this.form.providers_collection.splice(index, 1);

            let usedBudet = 0;
            this.form.providers_collection.forEach((provider, index) => {
                usedBudet = this.parseFloatValue(usedBudet) +  this.parseFloatValue(provider.budget) ;
            });
            this.remainingBudget = this.budget - this.parseFloatValue(usedBudet);
        },
        updateProviderBudgetAllocation(){
            let route = this.laroute.route("ajax.budget.allocation", { })
            this.form
                .post(route)
                .then(res => {
                    if ((res.status = 200)) {
                        this.$toastr.s("Success", "Record Updated!");
                    }
                })
                .catch(error => {
                    this.$toastr.e("Error", error.response.data.error);
                })
                .finally(() => {
                    this.loader = false
                })
        }

    },

}
</script>
