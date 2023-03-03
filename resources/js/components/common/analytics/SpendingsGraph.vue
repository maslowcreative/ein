<template>
  <div>
    <div class="card p-3 p-md-5">
        <h6 v-if="selectedPlan.id">Plan Status: {{selectedPlan.status ? 'Active' : 'In Active'}}</h6>
         <div class="row justify-content-end">
            <div class="col-md-3">
                <label>Participant: </label>
                <multiselect
                    v-model="selectedParticipant"
                    placeholder="Select participant"
                    label="show_name"
                    track-by="id"
                    :options="prticipantOptions"
                    :multiple="false"
                    :taggable="false"
                    :searchable="true"
                    :loading="participantLoader"
                    :internal-search="false"
                    :clear-on-select="true"
                    :close-on-select="true"
                    :options-limit="50" :limit="15"
                    @input="participantSelected"
                    @search-change="searchParticipantName">
                </multiselect>
                <label>Plan: </label>
                <multiselect v-model="selectedPlan" :options="plansOptions"  track-by="id"  placeholder="Select Plan" label="plans_range" @input="planSelected"></multiselect>
              </div>
         </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h5>SPENDING VS BUDGET</h5>
        <div class="loader-wrap">
            <Bar
              :chart-options="chartOptions"
              :chart-data="chartData"
              :chart-id="chartId"
              :dataset-id-key="datasetIdKey"
              :plugins="plugins"
              :css-classes="cssClasses"
              :styles="styles"
              :width="width"
              :height="height"
            />
            <!-- Loader -->
            <div  v-if="this.loader.graph" class="loader-bg">
                <div class="spinner-grow text-primary spinner-loder" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h5>Plan Budget</h5>
        <div class="loader-wrap">
          <div class="table-x-scroll">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="not-center">Support Category</th>
                  <th scope="col" class="not-center">Budget</th>
                  <th scope="col" class="not-center">Spent</th>
                  <th scope="col" class="not-center">Processing</th>
                  <th scope="col" class="not-center">Balance</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="row in tableData">
                  <td class="not-center">{{row.category.short_name}}</td>
                  <td class="not-center">${{row.amount}}</td>
                  <td class="not-center">${{row.spent}}</td>
                  <td class="not-center">${{row.pending}}</td>
                  <td class="not-center">${{row.balance}}</td>
                </tr>
              </tbody>
            </table>
          </div>
            <!-- Loader -->
            <div  v-if="this.loader.table" class="loader-bg">
                <div class="spinner-grow text-primary spinner-loder" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect"
import { Bar } from "vue-chartjs/legacy"

import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from "chart.js"

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: "BarChart",
  components: {
    Bar,
    Multiselect
  },
  props: {
    chartId: {
      type: String,
      default: "bar-chart",
    },
    datasetIdKey: {
      type: String,
      default: "label",
    },
    width: {
      type: Number,
      default: 400,
    },
    height: {
      type: Number,
      default: 400,
    },
    cssClasses: {
      default: "",
      type: String,
    },
    styles: {
      type: Object,
      default: () => {},
    },
    plugins: {
      type: Array,
      default: () => [],
    },
  },
  watch: {
      "selectedParticipant": function (val,old){
          this.chartData.labels = [];
          this.chartData.datasets[0].data = []; //spent
          this.chartData.datasets[1].data = []; //spent
          this.chartData.datasets[2].data = []; //spent
          this.plan = null;
          this.tableData = [];
       },

  },
  data() {
    return {
      participantLoader: false,
      paramParticipantId: null,
      paramPlanId: null,
      loader:{
            graph: false,
            table: false,
      },
      plan: null,
      selectedParticipant: {},
      prticipantOptions: [],
      selectedPlan: {},
      plansOptions: [],
      chartData: {
        labels: [],
        datasets: [
          {
            label: "Spent",
            backgroundColor: "#36a2eb",
            data: [],
          },
          {
            label: "Processing",
            backgroundColor: "#ff6484",
            data: [],
          },
          {
            label: "Balance",
            backgroundColor: "green",
            data: [],
          },
        ],
      },
      tableData: [],
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  },
  mounted() {
      let queryString = window.location.search;
      let urlParams = new URLSearchParams(queryString);

      if( urlParams.has('plan_id')  &&  urlParams.has('participant_id')){
          this.paramParticipantId = urlParams.get('participant_id');
          this.paramPlanId = urlParams.get('plan_id');
          this.getUsersList(1,null);
      }
  },

  methods: {
      getSpendingData(participantId,planId = null){

          let route = null;

          if( participantId == null || planId == null ) {
              this.$toastr.e("Error", 'Select articipant & Plans both.');
              return false;
          }


          if(planId){
              route = this.laroute.route("ajax.plans.spending.data",{'participant_id': participantId, 'plan_id':planId});
          }else {
              route = this.laroute.route("ajax.plans.spending.data",{'participant_id': participantId});
          }

          this.loader.graph = true;
          this.loader.table = true;
          axios
              .get(route)
              .then(res => {
                  let graphData = res.data.graph;
                  this.chartData.labels = graphData.labels;
                  this.chartData.datasets[0].data = graphData.spent; //spent
                  this.chartData.datasets[1].data = graphData.pending; //spent
                  this.chartData.datasets[2].data = graphData.balance; //spent
                  this.plan = res.data.plan;
                  this.tableData = res.data.table;
              })
              .catch(error => {
                  this.$toastr.e("Error", error.response.data.error);
                  this.chartData.labels = [];
                  this.chartData.datasets[0].data = []; //spent
                  this.chartData.datasets[1].data = []; //spent
                  this.chartData.datasets[2].data = []; //spent
                  this.plan = null;
                  this.tableData = [];
              })
              .finally(() => {
                  this.loader.graph = false;
                  this.loader.table = false;
              })
      },

      getUsersList(page = 1,query = null) {

          this.participantLoader = true;
          let data = { page: page }
          //Filtering Admin Role.
          data["filter[not_in][0]"] = 1;

          if(query)
          {
              data["filter[name]"] = query;
          }

          if(this.paramParticipantId){
              data["filter[id]"] = this.paramParticipantId;
          }

          data["filter[roles][0]"] = 'participant';
          let route = this.laroute.route("ajax.participants.index", data);

          axios
              .get(route)
              .then(res => {
                  this.prticipantOptions = res.data.data;
                  this.selectedParticipant = this.prticipantOptions[0];
                  if(this.selectedParticipant){
                      this.plansOptions = this.selectedParticipant.participant.plans;

                      if(this.paramPlanId)
                      {
                          this.selectedPlan = this.plansOptions.filter((plan) =>{
                              if(plan.id == this.paramPlanId)  {
                                  return plan;
                              }
                          });
                          this.getSpendingData(this.paramParticipantId,this.paramPlanId);
                      }
                  }

                  this.participantLoader = false;
                  this.paramPlanId = null;
                  this.paramParticipantId = null;
              })
              .catch(error => {
                  console.log(error);
                  this.participantLoader = false;
                  this.paramPlanId = null;
                  this.paramParticipantId = null;
              });
      },
      participantSelected(query){
          this.selectedPlan = {};
          this.plansOptions = [];
          if(this.selectedParticipant){
              this.plansOptions = this.selectedParticipant.participant.plans;
          }
         // console.log('participant selected name',this.plansOptions);

      },
      searchParticipantName(query) {
          this.getUsersList(1,query);
      },
      planSelected(plan) {
          this.selectedPlan = plan;
          this.getSpendingData(this.selectedParticipant.id,this.selectedPlan.id);

      },
  },
}
</script>

