<template>
  <input
    v-model="model"
    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 outline-none dark:focus:border-blue-500"
  />
</template>

<script lang="ts">
import Vue from 'vue'
export default Vue.extend({
  props: ['value'],
  data() {
    return {
      model: this.value,
    }
  },
  watch: {
    model(modelValue) {
      this.$emit('input',modelValue);
    }
  }
})
</script>