<template>
  <div
    id="not-found-page"
    class="d-flex justify-content-center align-items-center"
  >
    <div class="text-center">
        <h3 class="text-center">404 | Page not found</h3>
        <div>
            <router-link :to="{ name: 'home'}">Torna alla Home</router-link>
        </div>
        <div>
            <button type="button" @click="$router.back()" class="btn btn-secondary">
                Torna indietro
            </button>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    name: "NotFoundPage"
};
</script>

<style>
#not-found-page {
    height: 90vh;
}
</style>