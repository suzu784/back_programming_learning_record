<template>
    <div>
        <ul class="nav nav-tabs nav-justified">
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    :class="{ active: write }"
                    href="#"
                    @click="toggleTab('write')"
                >
                    write
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    :class="{ active: preview }"
                    href="#"
                    @click="toggleTab('preview')"
                >
                    preview
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            write: true,
            preview: false,
        };
    },
    methods: {
        toggleTab(tab) {
            if (tab === "write") {
                this.write = true;
                this.preview = false;
                this.$emit("tab-changed", "write");
            } else if (tab === "preview") {
                this.preview = true;
                this.write = false;
                this.$emit("tab-changed", "preview");
            }
        },
    },
};
</script>