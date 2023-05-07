<template>
    <div>
        <button
            type="button"
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#templateModal"
        >
            テンプレート
        </button>

        <!-- モーダル -->
        <div
            class="modal fade"
            id="templateModal"
            tabindex="-1"
            aria-labelledby="templateModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="templateModalLabel">
                            テンプレートを選択してください
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <button
                            v-for="template in templates"
                            :key="template"
                            type="button"
                            class="btn btn-outline-primary mb-3"
                            @click="selectTemplate(template)"
                        >
                            {{ template }}
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            閉じる
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            templates: [],
        };
    },
    mounted() {
        this.getTemplates();
    },
    methods: {
        async getTemplates() {
            const response = await fetch("/api/templates");
            const templates = await response.json();
            this.templates = templates;
        },
        selectTemplate(template) {
            this.$emit("template-selected", template);
        },
    },
};
</script>
