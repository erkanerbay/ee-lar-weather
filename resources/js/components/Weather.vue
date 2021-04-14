<template>
    <table class="table table-bordered table-sm mb-0">
        <tbody>
        <tr>
            <td>Name</td>
            <td v-text="data.name"></td>
        </tr>
        <tr>
            <td>Country</td>
            <td v-text="data.country"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td class="text-capitalize" v-text="data.description"></td>
        </tr>
        <tr>
            <td>Wind Speed</td>
            <td v-text="data.wind_speed"></td>
        </tr>
        <tr>
            <td>Wind Degree</td>
            <td v-text="data.wind_degree"></td>
        </tr>
        <tr>
            <td>Humidity</td>
            <td v-text="data.humidity"></td>
        </tr>
        <tr>
            <td>Feels Like</td>
            <td v-text="data.feels_like"></td>
        </tr>
        <tr>
            <td>Temperature</td>
            <td v-text="data.temp"></td>
        </tr>
        <tr>
            <td>Pressure</td>
            <td v-text="data.pressure"></td>
        </tr>

        </tbody>
    </table>
</template>

<script>
export default {
    name: 'Weather',
    props: {
        data: {
            type: Object,
            default: null,
        }
    }
}
</script>
