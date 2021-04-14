<template>
    <table class="table table-bordered table-sm mb-0">
        <tbody>
        <tr v-for="key in keys" :key="key">
            <template v-if="typeof data[key] !== 'undefined'">
                <td v-text="getName(key)"></td>
                <td v-text="data[key]"></td>
            </template>
        </tr>
        </tbody>
    </table>
</template>

<script>
const names = {
    name: 'Name',
    country: 'Country',
    description: 'Description',
    wind_speed: 'Wind Speed',
    wind_degree: 'Wind Degree',
    humidity: 'Humidity',
    feels_like: 'Feels Like',
    temp: 'Temperature',
    pressure: 'Pressure',
    date_time: 'Date Time',
};

export default {
    name: 'Weather',
    props: {
        data: {
            type: Object,
            default: null,
        }
    },
    computed: {
        keys() {
            return Object.keys(names);
        }
    },
    methods: {
        getName(name) {
            return names[name];
        }
    }
}
</script>
