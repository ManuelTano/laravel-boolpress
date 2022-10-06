<template>
    <div class="content">
        <MyHeader :title="title" />
        <main class="container mt-3">
            <router-view> </router-view>
        </main>
    </div>
</template>
<script>
import MyHeader from "./MyHeader.vue";
export default {
    name: "App",
    components: {
        MyHeader,
    },
    data() {
        return {
            title: "Laravel API",
        };
    },
};
</script>

<style>

</style>