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
    props: {
        tagName: {
            type: Array,
        },
    },
    data() {
        return {
            tags: [],
        };
    },
    computed: {
        tagsJson() {
            if(this.tagName[0]) {
                this.tagName[0].forEach((element) => {
                    this.tags.push(element.name);
                });
            }
            return this.tags;
        },
    },
};
</script>
