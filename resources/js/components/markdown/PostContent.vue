<template>
    <div>
        <p class="card-text" v-html="renderedBody"></p>
    </div>
</template>

<script>
import MarkdownIt from "markdown-it/lib";
export default {
    props: {
        initialRecordBody: {
            type: String,
        },
    },
    data() {
        return {
            md: new MarkdownIt({
                html: true,
                linkify: true,
                breaks: true,
            }),
            body: this.initialRecordBody,
        };
    },
    computed: {
        renderedBody() {
            return this.md.render(this.body);
        },
    },
};
</script>
