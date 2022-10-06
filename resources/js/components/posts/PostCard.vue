<template>
    <div class="card bg-gray text-black mb-3">
        <div class="card-body">
            <h5 class="card-title">
                {{ post.title }}
            </h5>
            <h6 class="card-subtitle mb-2 text-muted">
                Pubblicato il: {{ publishedAt }}
            </h6>
            <p>
                {{ post.content }}
            </p>
            <router-link
                :to="{ name: 'post-detail', params: { id: post.id } }"
                class="btn btn-primary btn-sm "
                ><i class="fa-solid fa-eye mr-2"></i> Vedi</router-link
            >
        </div>
    </div>
</template>
<script>
export default {
    name: "PostCard",
    props: {
        post: Object,
    },
    computed: {
        publishedAt() {
            const postDate = new Date(this.post.created_at);
            let day = postDate.getDate();
            let month = postDate.getMonth() + 1;
            const year = postDate.getFullYear();
            if (day < 10) day = "0" + day;
            if (month < 10) month = "0" + month;
            return `${day}/${month}/${year}`

        },
    },
};
</script>
<style lang=""></style>