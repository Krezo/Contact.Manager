<template>
  <div class="container mx-auto min-h-screen">
    <div class="max-w-4xl mx-auto">
      <page-title>Контакты</page-title>
      <div class="space-y-4">
        <contact-card
          v-for="contact in contacts"
          :key="contact.id"
          :contact="contact"
        />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'
import ContactCard from '~/components/contact-card.vue'
import pageTitle from '~/components/Global/page-title.vue'
import { Models } from '~/lib/Models'
import { ModelResourseWrapper } from '~/lib/types'
import { FavoriteAction } from '~/store/favorite'

export default Vue.extend({
  name: 'IndexPage',
  components: { pageTitle, ContactCard },
  middleware: [
    'auth',
    ({ store }) => {
      store.dispatch('favorite/' + FavoriteAction.LOAD_FAVORITE_CONTACTS)
    },
  ],
  async asyncData({ $axios }) {
    try {
      const apiResponseData = (
        await $axios.get<ModelResourseWrapper<Models.Contact>>('/contacts')
      ).data
      const contacts = apiResponseData.data
      return {
        contacts,
      }
    } catch (e: unknown) {}
  },
  data() {
    return {
      contacts: [] as Models.Contact[],
    }
  },
})
</script>

    