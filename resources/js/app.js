import "./bootstrap";
import { createApp } from "vue";
import GoalForm from "./components/GoalForm.vue";

const app = createApp(GoalForm);
app.mount("#goal-form");