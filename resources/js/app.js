import "./bootstrap";
import { createApp } from "vue";
import Vuex from "vuex";
import GoalForm from "./components/GoalForm.vue";
import Textarea from "./components/Textarea.vue";

const goalFormApp = createApp(GoalForm);
goalFormApp.mount("#goal-form");

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

const textareaApp = createApp(Textarea);
textareaApp.use(store);
textareaApp.mount("#text-area-modal");