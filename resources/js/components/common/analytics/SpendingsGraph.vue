<template>
  <div>
    <div class="card p-3 p-md-5">
      <h5>Filters</h5>
      <div class="grid filters">
        <div class="">
          <label>Filters</label>
          <input type="email" class="form-control" />
        </div>
        <div class="">
          <label>Filters</label>
          <input type="email" class="form-control" />
        </div>
        <div class="">
          <label>Filters</label>
          <select class="form-select">
            <option selected>Open this select menu</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
        </div>
        <div class="">
          <label>Filters</label>
          <input type="email" class="form-control" />
        </div>
        <div class="">
          <label>Filters</label>
          <input type="email" class="form-control" />
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
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
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <h5>Table Title</h5>
        <div class="loader-wrap">
          <div class="table-x-scroll">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col" class="not-center">Col Title</th>
                  <th scope="col" class="not-center">Col Title</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="not-center">data</td>
                  <td class="not-center">data</td>
                  <td>data</td>
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
import { Bar } from "vue-chartjs/legacy"

import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from "chart.js"

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: "BarChart",
  components: {
    Bar,
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
  data() {
    return {
      chartData: {
        labels: [
          "Assistance with Daily Life",
          "Assistance with Social, Economic and Community Participation",
          "Assistive Technology",
          "Consumables",
          "Finding and Keeping a Job",
          "Home Modifications and Specialised Disability Accommodation (SDA)",
          "Improved Daily Living Skills",
          "Improved Health and Wellbeing",
          "Improved Learning",
          "Improved Life Choices",
          "Improved Living Arrangements",
          "Improved Relationships",
          "Increased Social and Community Participation",
          "Support Coordination",
          "Transport",
        ],
        datasets: [
          {
            label: "Spent",
            backgroundColor: "#36a2eb",
            data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11, 13, 14, 15],
          },
          {
            label: "Pending",
            backgroundColor: "#ff6484",
            data: [5, 6, 7, 8, 9, 10, 15, 14, 13, 12, 11, 1, 2, 3, 4, 5],
          },
          {
            label: "Balance",
            backgroundColor: "#f87979",
            data: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13, 14, 15],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
      },
    }
  },
  mounted() {
    var ctx = document.getElementById("myChart")
    this.canvas = new Chart(ctx, {
      type: "line",
      data: this.data,
      options: {},
    })
    // console.log('chuchu',this.config);
    // this.canvas = new Chart(ctx, this.config);
    //this.canvas.update();
  },

  methods: {},
}
</script>
