<template>
    <div>
        <button v-if="isLiked" @click="unlikeRecord" class="btn liked">
            <i class="fas fa-heart"></i>
        </button>
        <button v-else @click="likeRecord" class="btn">
            <i class="fas fa-heart"></i>
        </button>
        <span>{{ countLikes }}</span>
    </div>
</template>

<script>
export default {
    props: {
        recordId: {
            type: Number,
            required: true,
        },
        initialIsLiked: {
            type: Boolean,
            required: true,
        },
        initialCountLikes: {
            type: Number,
            default: 0,
        },
    },
    data() {
        return {
            isLiked: this.initialIsLiked,
            countLikes: this.initialCountLikes,
        };
    },
    methods: {
        likeRecord() {
            axios
                .put(`/records/${this.recordId}/like`)
                .then((response) => {
                    this.isLiked = true;
                    this.countLikes = response.data.countLikes;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        unlikeRecord() {
            axios
                .delete(`/records/${this.recordId}/unlike`)
                .then((response) => {
                    this.isLiked = false;
                    this.countLikes = response.data.countLikes;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style>
button.btn.liked {
    color: red;
}
</style>
