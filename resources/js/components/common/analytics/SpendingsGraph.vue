<template>
    <div class="card">
        <div class="card-body">
            <div>
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
    </div>
</template>

<script>

import { Bar } from 'vue-chartjs/legacy'

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: {
        Bar
    },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 400
        },
        cssClasses: {
            default: '',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            chartData: {
                labels: [
                   'Assistance with Daily Life',
                   'Assistance with Social, Economic and Community Participation',
                   'Assistive Technology',
                   'Consumables',
                   'Finding and Keeping a Job',
                   'Home Modifications and Specialised Disability Accommodation (SDA)',
                   'Improved Daily Living Skills',
                   'Improved Health and Wellbeing',
                   'Improved Learning',
                   'Improved Life Choices',
                   'Improved Living Arrangements',
                   'Improved Relationships',
                   'Increased Social and Community Participation',
                   'Support Coordination',
                   'Transport'
                ],
                datasets: [
                    {
                        label: 'Spent',
                        backgroundColor: '#36a2eb',
                        data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11, 13 ,14, 15]
                    },
                    {
                        label: 'Pending',
                        backgroundColor: '#ff6484',
                        data: [5,6,7,8,9,10,15,14,13,12,11,1,2,3,4,5]
                    },
                    {
                        label: 'Balance',
                        backgroundColor: '#f87979',
                        data: [1,2,3,4,5,6,7,8,9,10,12,13,14,15]
                    }
                ]

            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false
            }
        }
    }
}
</script>
