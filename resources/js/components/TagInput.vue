<template>
    <div>
        <input
            type="hidden"
            name="tagName"
            :value="tagsJson"
            class="form-control"
            id="tagName"
        />
        <Vue3TagsInput
            :tags="tags"
            placeholder="タグを入力してください。"
            @on-tags-changed="(newTags) => (tags = newTags)"
        />
    </div>
</template>

<script>
import Vue3TagsInput from "vue3-tags-input";
export default {
    components: {
        Vue3TagsInput,
    },
    data() {
        return {
            tags: [],
        };
    },
    computed: {
        tagsJson() {
            return this.tags;
        },
    },
};
</script>
