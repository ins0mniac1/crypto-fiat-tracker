<template>
    <div class="">
        <h1 class="text-2xl font-bold underline text-center mt-4">Crypto/Fiat pair tracker</h1>
        <div class="w-full flex justify-center mt-12">
            <div class="w-1/6 mr-4">
                <label for="pairs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option</label>
                <select v-model="selectedPair" id="pairs"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="(index, pair) in pairs" :value="pair" v-text="pair"></option>
                </select>
            </div>
            <div class="w-1/6 mx-4">
                <label for="pairs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option</label>
                <select v-model="selectedDriver" id="drivers"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option v-for="(driver) in drivers" :value="driver.toUpperCase()" v-text="driver.toUpperCase()"></option>
                </select>
            </div>
            <div class="w-1/6 ml-4">
                <label for="pairs" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an
                    option</label>
                <select @change="onChange()" v-model="selectedUnit" id="units"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="month">Month</option>
                    <option value="Year">Year</option>
                    <option value="Year">Day</option>
                </select>
            </div>
        </div>
        <div class="mt-16 w-1/2 mx-auto">
            <canvas ref="chartEl"></canvas>
        </div>
        <div class="flex justify-center mt-24">
            <form class="w-full max-w-sm">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4"
                               for="inline-full-name">
                            Email
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input v-model="email"
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                               id="inline-full-name" type="email" placeholder="email@example.com">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-price">
                            Price
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input v-model="price"
                               class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500"
                               id="inline-price" type="number" placeholder="18981.99">
                    </div>
                </div>
                <div>
                    <div v-if="errors.text" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mb-8 rounded relative"
                         role="alert">
                        <p  v-text="`Error: ${errors.text}`" class="border border-b-red-600">
                        </p>
                    </div>
                </div>
                <div class="md:flex md:items-center">
                    <div class="md:w-1/3"></div>
                    <div class="md:w-2/3">
                        <button @click.prevent="onSubmit"
                                class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                                type="button">
                            Subscribe
                        </button>
                    </div>
                </div>
            </form>
            <div v-if="successfullySubscribed.text" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded absolute w-2/3 h-24 text-center">
                <strong v-text="successfullySubscribed.text"></strong>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";

import useConfig from "../composables/config";
import Chart from "chart.js/auto";
import 'chartjs-adapter-moment';

const {config} = useConfig();
const chartEl = ref(null)
const pairs = config.tracked_pairs
const drivers = config.tracked_drivers
const errors = ref({})
const successfullySubscribed = ref({})

const loadedChart = ref({})

const email = ref('');
const price = ref('');
const selectedPair = ref('');
const selectedDriver = ref('');
const selectedUnit = ref('');

console.log(drivers)


onMounted(() => {
    selectedUnit.value = 'month'

    makeCallToDB()

    selectedPair.value = 'BTCUSD'
    selectedDriver.value = 'BITFINEX'
})

async function onSubmit() {
    errors.value = {}
    axios.post('/api/guest/notify', {
        email: email.value,
        pair: selectedPair.value,
        price: price.value,
    }).then(res => {
        successfullySubscribed.value = {
            text: res.data
        }

        setTimeout(function () {
            successfullySubscribed.value = {}
        }, 3000)
    }).catch(err => {
        for (const validationError in err.response.data.errors) {
            errors.value = {
                field: validationError,
                text: err.response.data.errors[validationError][0]
            }
        }
    })
}

function onChange(){
    loadChart.value.config.options.scales.x.time.unit = selectedUnit.value
    loadChart.value.update()
}

function makeCallToDB()
{
    axios.get('/api/guest')
        .then(response => {
            loadChart(response.data.data)
        })
}

function loadChart(data) {

    let chartData = []

    data.map((el) => {
        chartData.push({
            x: el.created_at,
            y: el.last_price
        })
    })


    const ctx = chartEl.value
    loadChart.value = new Chart(ctx, {
        type: 'line',
        data: {
            datasets: [{
                label: selectedPair.value,
                data: chartData
            }],
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'month'
                    }
                }
            }
        }
    });
}
</script>
