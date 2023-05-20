import "./bootstrap";
import "./fontawesome";
import "chartkick/chart.js";
import { createApp } from "vue";
import Vuex from "vuex";
import VueChartkick from "vue-chartkick";
import GoalForm from "./components/GoalForm.vue";
import Textarea from "./components/Textarea.vue";
import RecordLike from "./components/RecordLike.vue";
import CommentForm from "./components/CommentForm.vue";
import TagInput from "./components/TagInput.vue";
import StudyAnalytics from "./components/StudyAnalytics.vue";
import PostContent from "./components/markdown/PostContent.vue";

const goalFormElement = document.querySelector("#goal-form");
if (goalFormElement) {
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
if (textareaElement) {
    const textareaApp = createApp(Textarea);
    textareaApp.use(store);
    textareaApp.mount("#text-area-modal");
}

const likeButtonElement = document.querySelector("#like-button");
if (likeButtonElement) {
    const LikeButtonApp = async () => {
        const likeButtonApp = createApp({});
        likeButtonApp.component("record-like", RecordLike);
        likeButtonApp.mount("#like-button");
    };
    LikeButtonApp();
}

const commentFormElement = document.querySelector("#comment-form");
if (commentFormElement) {
    const CommentFormApp = async () => {
        const commentFormApp = createApp({});
        commentFormApp.component("comment-form", CommentForm);
        commentFormApp.mount("#comment-form");
    };
    CommentFormApp();
}

const tagInputElement = document.querySelector("#tag-input");
if (tagInputElement) {
    const tagInputApp = createApp(TagInput);
    tagInputApp.mount("#tag-input");
}

const studyAnalyticsElement = document.querySelector("#study-analytics");
if (studyAnalyticsElement) {
    const studyAnalyticsApp = createApp(StudyAnalytics);
    studyAnalyticsApp.use(VueChartkick);
    studyAnalyticsApp.mount("#study-analytics");
}

const postContentElement = document.querySelector("#post-content");
if (postContentElement) {
    const PostContentApp = async () => {
        const postContentApp = createApp();
        postContentApp.component("post-content", PostContent);
        postContentApp.mount("#post-content");
    };
    PostContentApp();
}
