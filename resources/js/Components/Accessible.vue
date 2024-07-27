<template>
    <div v-if="message.fail">
        <div class="mt-3 font-normal text-sm text-red-600">{{ message.fail }}</div>
    </div>
</template>
<script>

export default {
    props: {
        message: Object,
    },
}
</script>
