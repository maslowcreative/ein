<template>
    <div class="login-box-logo text-center">
        <a :href="homeUrl">
            <img :src="'/images/logo.png'" width="141" height="103" alt="" />
        </a>
    </div>
</template>

<script>
export default {
    data(){
        return {
            homeUrl: null,
        }
    },
    mounted() {
        this.homeUrl = this.laroute.route('index');
    }
}
</script>
