<template>
  <button
    class="border inline-flex items-center font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition-all"
    :class="btnClasses"
    type="button"
  >
    <v-spiner v-if="loading" class="animate-spin h-4 w-4 mr-3" />
    <slot></slot>
  </button>
</template>

<script lang="ts">
import Vue from 'vue'
import vSpiner from './v-spiner.vue'
import { ColorTypes } from '~/lib/types'

export default Vue.extend({
  components: { vSpiner },
  props: {
    color: {
      type: String,
      default: ColorTypes.DEFAULT,
      validator: (type) =>
        Object.values(ColorTypes).includes(type as ColorTypes),
    },
    loading: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    btnClasses(): object {
      return {
        'bg-blue-700 hover:bg-blue-800 text-white':
          ColorTypes.PRIMARY === this.color,
        'bg-gray-300 hover:bg-gray-400 text-black':
          ColorTypes.DEFAULT === this.color,
        'bg-white hover:bg-gray-100 text-black':
          ColorTypes.WHITE === this.color,
      }
    },
  },
})
</script>