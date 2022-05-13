<template>
  <div
    class="relative justify-between bg-white shadow-sm px-4 py-2.5 flex rounded-sm hover:bg-blue-600 hover:text-white transition cursor-pointer"
  >
    <span>
      <div class="font-bold">{{ contact.name }}</div>
      <div>{{ contact.phone }}</div>
    </span>

    <div class="flex items-center justify-centerbg-white group-hover:bg-white">
      <v-button
        color="white"
        class="text-sm"
        :loading="isAddToFavorite"
        :disabled="isAddToFavorite"
        @click.native="addContactClickHandler"
        >{{ favoriteButtonText }}</v-button
      >
    </div>
  </div>
</template> 


<script lang="ts">
import Vue, { PropType } from 'vue'
import axios from 'axios'
import VButton from './UI/v-button.vue'
import { FavoriteAction, FavoriteState } from '~/store/favorite'
import { Models } from '~/lib/Models'
import { ErrorMessage } from '~/lib/types'

export default Vue.extend({
  components: { VButton },

  props: {
    contact: {
      type: Object as PropType<Models.Contact>,
      required: true,
    },
  },
  data() {
    return {
      isAddToFavorite: false,
    }
  },
  computed: {
    isFavorite(): boolean {
      return (
        (
          this.$store.state.favorite as FavoriteState
        ).favoriteContacts.findIndex(
          (contact) => contact.id === this.contact.id
        ) !== -1
      )
    },
    favoriteButtonText(): string {
      return this.isFavorite ? 'Удалить' : 'Добавить'
    },
  },
  methods: {
    async addContactClickHandler() {
      this.isAddToFavorite = true
      try {
        const dispatchType = this.isFavorite
          ? FavoriteAction.DELETE_CONTACT_FROM_FAVORITE
          : FavoriteAction.ADD_CONTACT_TO_FAVORITE
        await this.$store.dispatch('favorite/' + dispatchType, this.contact.id)
      } catch (e: unknown) {
        if (axios.isAxiosError(e)) {
          const errorMessage = e.response?.data.message
          if (errorMessage)
            this.$toast.error(e.response?.data.message, {
              duration: 3000,
            })
        } else
          this.$toast.error(ErrorMessage.UNKWOWN, {
            duration: 3000,
          })
      }
      this.isAddToFavorite = false
    },
  },
})
</script>
