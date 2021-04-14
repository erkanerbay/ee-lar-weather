<template>
    <div>
        <alert :items="errors"></alert>

        <multiselect
            class="mb-3"
            v-model="state"
            :options="states"
            placeholder="Type to search a city"
            @select="onSelect"
        ></multiselect>

        <card v-if="current" title="LIVE">
            <weather :data="current"></weather>
        </card>

        <div v-if="forecasts" style="overflow-x: scroll;">
            <div class="d-inline-flex">
                <card v-for="forecast in forecasts" class="mx-3" style="width: 360px;">
                    <weather :data="forecast"></weather>
                </card>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'AppContent',
    data: () => ({errors: null, state: '', states: [], current: null, forecasts: null}),
    mounted() {
        this.fetchStates();
    },
    methods: {
        onSelect(selectedOption) {
            this.fetchCurrent(selectedOption);
            this.fetchForecasts(selectedOption);
        },
        fetch(url, params) {
            return this.axios
                .get('/weather/status', {params})
                .then(({data}) => {
                    return data;
                })
                .catch(err => {
                    this.errors = err?.response?.data;
                });
        },
        fetchStates() {
            this.axios
                .get('/weather/states')
                .then(({data}) => {
                    this.states = data;
                })
                .catch(err => {
                    this.errors = err?.response?.data;
                });
        },
        fetchCurrent(state) {
            const params = {type: 'current', state};
            this.axios
                .get('/weather/status', {params})
                .then(({data}) => {
                    this.current = data;
                })
                .catch(err => {
                    this.errors = err?.response?.data;
                });
        },
        async fetchForecasts(state) {
            const params = {type: 'forecast', state};
            const data = await this.fetch('/weather/status', params);
            this.forecasts = data;
        },
    }
}
</script>
