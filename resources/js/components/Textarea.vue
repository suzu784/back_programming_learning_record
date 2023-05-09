<template>
    <div>
        <tab @tab-changed="handleTabChanged"/>
        <markdown-editor v-show="type === 'write'" />
        <markdown-preview v-show="type === 'preview'" />
    </div>
</template>

<script>
import Tab from "./markdown/Tab.vue";
import MarkdownEditor from "./markdown/MarkdownEditor.vue";
import MarkdownPreview from "./markdown/MarkdownPreview.vue";

export default {
    components: {
        Tab,
        MarkdownEditor,
        MarkdownPreview,
    },
    data() {
        return {
            type: "write"
        };
    },
    methods: {
        handleTabChanged(type) {
            this.type = type;
        }
    },
};
</script>