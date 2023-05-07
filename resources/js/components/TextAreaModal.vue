<template>
    <textarea
        v-model="textAreaValue"
        name="boy"
        id="body"
        class="form-control"
        cols="40"
        rows="18"
        placeholder="学習内容を入力してください"
    >
    </textarea>
    <modal @template-selected="onTemplateSelected" />
</template>

<script>
import Modal from "./Modal.vue";

export default {
    components: {
        Modal,
    },
    data() {
        return {
            textAreaValue: "",
        };
    },
    methods: {
        onTemplateSelected(template) {
            this.textAreaValue = template;
        },
    },
};
</script>
