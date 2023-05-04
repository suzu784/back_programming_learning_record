<template>
    <div>
        <div v-if="showButton">
            <button class="btn btn-primary mt-3" @click="showForm">
                目標を設定する
            </button>
        </div>
        <form v-if="showFormFlag" class="mt-3" @submit.prevent="saveGoal">
            <div class="form-group">
                <label for="goal">目標</label>
                <textarea
                    class="form-control"
                    id="goal"
                    rows="4"
                    v-model="goal"
                ></textarea>
            </div>
            <button type="submit" class="btn btn-primary">保存</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "GoalForm",
    data() {
        return {
            showButton: true,
            showFormFlag: false,
            goal: "",
        };
    },
    methods: {
        showForm() {
            this.showButton = false;
            this.showFormFlag = true;
        },
        saveGoal() {
            axios
                .put("/users/${this.$route.params.id}", { goal: this.goal })
                .then((response) => {
                    window.location.reload();
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
