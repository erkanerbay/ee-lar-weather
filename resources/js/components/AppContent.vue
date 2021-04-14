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
    </div>
</template>

<script>
export default {
    name: 'AppContent',
    data: () => ({errors: null, state: '', states: [], current: null}),
    mounted() {
        this.fetchStates();
    },
    methods: {
        onSelect(selectedOption) {
            this.fetchCurrent(selectedOption);
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
    }
}
</script>
