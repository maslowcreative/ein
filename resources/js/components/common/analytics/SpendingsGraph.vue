<template>
    <div class="card">
        <div class="card-body">
            <div>
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</template>

<script>


import {Chart} from "chart.js/auto";

export default {
    components: {},
    data()  {
        return {
            labels : [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
            ],
            data : {
                labels: this.labels,
                datasets: [{
                    label: 'My First dataset',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: [0, 10, 5, 2, 20, 30, 45],
                }]
            },
            config : {
                type: 'line',
                data: this.data,
                options: {}
            },
            canvas : null,
        }
    },
    mounted() {
        var ctx = document.getElementById('myChart');
        this.canvas = new Chart(ctx, {
            type: 'line',
            data: this.data,
            options: {}
        });
        // console.log('chuchu',this.config);
        // this.canvas = new Chart(ctx, this.config);
        //this.canvas.update();
    },

    methods: {

    }
}
</script>
