import "./bootstrap";
import { createApp } from "vue";
import Vuex from "vuex";
import GoalForm from "./components/GoalForm.vue";
import Textarea from "./components/Textarea.vue";
import RecordLike from "./components/RecordLike.vue";

const goalFormElement = document.querySelector("#goal-form");
if(goalFormElement) {
    const goalFormApp = createApp(GoalForm);
    goalFormApp.mount("#goal-form");
}

const store = new Vuex.Store({
    state: {
        textareaValue: "",
    },
    mutations: {
        setTextareaValue(state, textareaValue) {
            state.textareaValue = textareaValue;
        },
    },
    actions: {
        updateTextareaValueAction(context, textareaValue) {
            context.commit("setTextareaValue", textareaValue);
        },
    },
});

const textareaElement = document.querySelector("#text-area-modal");
if(textareaElement) {
    const textareaApp = createApp(Textarea);
    textareaApp.use(store);
    textareaApp.mount("#text-area-modal");
}

const likeButtonElement = document.querySelector("#like-button");
if(likeButtonElement) {
    const LikeButtonApp = async () => {
        const likeButtonApp = createApp({});
        likeButtonApp.component("record-like", RecordLike);
        likeButtonApp.mount("#like-button");
    };
    LikeButtonApp();
}