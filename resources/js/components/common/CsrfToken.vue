<template>
    <input type="hidden" name="_token" :value="token">
</template>

<script>
export default {
    data() {
        return {
            'token': null,
        }
    },
    mounted() {
         this.token = document.head.querySelector("meta[name='csrf-token']").content;
    }
}
</script>
