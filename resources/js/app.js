import "./bootstrap";
import { createApp } from "vue";
import GoalForm from "./components/GoalForm.vue";
import TextAreaModal from "./components/TextAreaModal.vue";

const goalFormApp = createApp(GoalForm);
goalFormApp.mount("#goal-form");

const textAreaModalApp = createApp(TextAreaModal);
textAreaModalApp.mount("#text-area-modal");