<template>
    <h3>コメント欄</h3>
    <div class="form-group">
        <form @submit.prevent="addComment">
            <p class="validation" v-if="addValidationMessage">
                {{ addValidationMessage }}
            </p>
            <textarea
                rows="4"
                cols="150"
                class="form-control"
                v-model="commentTextarea"
            ></textarea>
            <button type="submit" class="btn btn-success">コメント</button>
        </form>
    </div>
    <div v-for="(comment, index) in comments" :key="index.id">
        <form @submit.prevent="updateComment(comment, index)">
            <p class="validation" v-if="comment.editValidationMessage">
                {{ comment.editValidationMessage }}
            </p>
            <textarea
                v-if="isEdit[index]"
                rows="4"
                cols="150"
                class="form-control"
                v-model="comment.pivot.content"
            ></textarea>
            <div v-if="!isEdit[index]" class="d-flex justify-content-between">
                <span>{{ comment.pivot.content }}</span>
                <div>
                    <button
                        v-if="!isEdit[index] && isAuthorized(index)"
                        class="btn btn-primary"
                        @click="editComment(index)"
                    >
                        <i class="fas fa-edit"></i>
                    </button>
                    &nbsp;
                    <button
                        v-if="!isEdit[index] && isAuthorized(index)"
                        class="btn btn-danger"
                        @click="deleteComment(comment)"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <hr v-if="!isEdit[index]" />
            <button
                v-if="isEdit[index] && isAuthorized(index)"
                type="submit"
                class="btn btn-primary"
            >
                更新
            </button>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        recordId: {
            type: Number,
            required: true,
        },
        userId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            commentTextarea: "",
            addValidationMessage: "",
            comments: [
                {
                    pivot: [],
                    editValidationMessage: "",
                },
            ],
            isEdit: [],
        };
    },
    mounted() {
        this.fetchComments();
    },
    computed: {
        isAuthorized() {
            return (index) => {
                const comment = this.comments[index];
                return comment.pivot.user_id === this.userId;
            };
        },
    },
    methods: {
        fetchComments() {
            axios
                .get(`/comments/${this.recordId}`)
                .then((response) => {
                    this.addValidationMessage = "";
                    this.commentTextarea = "";
                    this.comments = response.data.comments;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        addComment() {
            axios
                .post("/records/comments", {
                    recordId: this.recordId,
                    content: this.commentTextarea,
                })
                .then((response) => {
                    this.fetchComments();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.addValidationMessage = error.response.data.message;
                        console.log(error);
                    } else {
                        console.log(error);
                    }
                });
        },
        editComment(index) {
            if (this.isEdit.some((value, idx) => value && idx !== index)) {
                return;
            }
            this.isEdit[index] = true;
        },
        updateComment(comment, index) {
            axios
                .put(`/records/comments/${comment.pivot.id}`, {
                    content: comment.pivot.content,
                })
                .then((response) => {
                    this.comments[index].editValidationMessage = "";
                    this.isEdit[index] = false;
                    this.fetchComments();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.comments[index].editValidationMessage =
                            error.response.data.message;
                        console.log(error);
                    } else {
                        console.log(error);
                    }
                });
        },
        deleteComment(comment) {
            axios
                .delete(`/records/comments/${comment.pivot.id}`)
                .then((response) => {
                    this.fetchComments();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
