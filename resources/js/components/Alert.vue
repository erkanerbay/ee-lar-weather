<template>
    <div v-if="items" class="py-1 px-3 mb-3 bg-white shadow-sm rounded">
        <div v-for="(item, index) in items" v-text="item" class="text-danger" :key="index"></div>
    </div>
</template>

<script>
export default {
    name: 'Alert',
    props: {
        items: {
            type: Array,
            default: null,
        }
    }
}
</script>
