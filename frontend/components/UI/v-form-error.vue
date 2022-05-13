<template>
  <div
    v-if="errors.length !== 0"
    class="p-5 rounded-md border-red-600 bg-gray-50 text-red-600 space-y-3"
  >
    <p
      v-for="(error, index) in errors"
      :key="'error_' + index"
      class="font-bold text-sm"
    >
      {{ error }}
    </p>
  </div>
</template>


<script lang="ts">
import Vue, { PropType } from 'vue'

export default Vue.extend({
  props: {
    errors: {
      type: Array as PropType<string[]>,
      default: () => [],
    },
  },
})
</script>