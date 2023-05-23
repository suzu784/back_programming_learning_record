<template>
    <div>
        <textarea
            v-model="textareaValue"
            name="body"
            id="body"
            class="form-control"
            cols="40"
            rows="18"
            placeholder="学習内容を入力してください"
            @input="updateTextareaValue"
        >
        </textarea>
        <modal @template-selected="onTemplateSelected" />
    </div>
</template>

<script>
import MarkdownIt from "markdown-it/lib";
import Modal from "../Modal.vue";
import { mapActions } from "vuex";

export default {
    components: {
        Modal,
    },
    props: {
        initialRecordBody: {
            type: String,
        },
    },
    data() {
        return {
            textareaValue: this.initialRecordBody,
            md: new MarkdownIt({
                html: true,
                linkify: true,
                breaks: true,
            }),
        };
    },
    methods: {
        ...mapActions(["updateTextareaValueAction"]),
        updateTextareaValue() {
            this.updateTextareaValueAction(this.md.render(this.textareaValue));
        },
        onTemplateSelected(template) {
            this.textareaValue += template;
            this.updateTextareaValue();
        },
    },
};
</script>