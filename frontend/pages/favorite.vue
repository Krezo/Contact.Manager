<template>
  <div class="min-h-screen">
    <div class="max-w-4xl mx-auto">
      <page-title>Избранное</page-title>
      <div v-if="favoriteContacts.length !== 0" class="space-y-4">
        <contact-card
          v-for="contact in favoriteContacts"
          :key="contact.id"
          :contact="contact"
        />
      </div>
      <div v-else>Список избранного пуст</div>
    </div>
  </div>
</template>



<script lang="ts">
import Vue from 'vue'
import pageTitle from '~/components/Global/page-title.vue'
import { FavoriteAction, FavoriteState } from '~/store/favorite'
export default Vue.extend({
  components: { pageTitle },
  middleware: ['auth'],
  computed: {
    favoriteContacts() {
      return (this.$store.state.favorite as FavoriteState).favoriteContacts
    },
  },
})
</script>