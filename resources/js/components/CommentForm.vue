<template>
    <div>
        <div class="row mt-5 justify-content-center">
            <div class="col-md-10 col-lg-9 offset-lg-1">
                <div class="form-group row">
                    <div class="col-md-5">
                        <form @submit.prevent="addComment">
                            <p class="validation" v-if="addValidationMessage">
                                {{ addValidationMessage }}
                            </p>
                            <textarea
                                rows="4"
                                cols="50"
                                class="form-control"
                                v-model="commentTextarea"
                            ></textarea>
                            <button type="submit" class="btn btn-success">
                                コメント
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="row mt-5 justify-content-center">
            <div class="col-md-10 col-lg-9 offset-lg-1">
                <div v-for="(comment, index) in comments" :key="index.id">
                    <div v-if="!isEdit[index]">
                        {{ comment.pivot.content }}
                    </div>
                    <div class="col-md-5">
                        <form @submit.prevent="updateComment(comment, index)">
                            <p
                                class="validation"
                                v-if="comment.editValidationMessage"
                            >
                                {{ comment.editValidationMessage }}
                            </p>
                            <textarea
                                v-if="isEdit[index]"
                                rows="2"
                                cols="50"
                                class="form-control"
                                v-model="comment.pivot.content"
                            ></textarea>
                            <button
                                v-if="!isEdit[index]"
                                class="btn btn-primary"
                                @click="editComment(index)"
                            >
                                編集
                            </button>
                            <button
                                v-if="isEdit[index]"
                                type="submit"
                                class="btn btn-primary"
                            >
                                更新
                            </button>
                            <button
                                class="btn btn-danger"
                                @click="deleteComment(comment)"
                            >
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        recordId: {
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
                    pivot: [
                        {
                            content: "",
                        },
                    ],
                    editValidationMessage: "",
                },
            ],
            isEdit: [],
        };
    },
    mounted() {
        this.fetchComments();
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
