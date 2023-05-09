<template>
  <div>
    <div v-html="textareaValue"></div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState(['textareaValue']),
  },
};
</script>