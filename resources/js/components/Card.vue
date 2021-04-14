<template>
    <div class="p-1 pt-2 mb-3 bg-white shadow-sm rounded">
        <h2 v-if="title" class="h5">&mdash; {{title}}</h2>
        <slot></slot>
    </div>
</template>

<script>
export default {
    name: 'Card',
    props: {
        title: {
            type: String,
            default: null
        }
    }
}
</script>
