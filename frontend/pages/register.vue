<template>
  <div class="min-h-screen">
    <div class="max-w-xl mx-auto">
      <page-title>Регистрация</page-title>
      <v-card>
        <form @submit.prevent="registerUser">
          <v-form-error class="mb-2" :errors="formErorrs" />
          <div class="mb-4">
            <v-label> Имя пользователя </v-label>
            <v-input
              v-model="username"
              class="input"
              type="text"
              placeholder="Введите имя пользователя"
              required
              min="6"
            />
          </div>
          <div class="mb-4">
            <v-label> Email </v-label>
            <v-input
              v-model="email"
              type="email"
              placeholder="Введите e-mail"
              required
            />
          </div>
          <div class="mb-8">
            <v-label> Пароль </v-label>
            <v-input
              v-model="password"
              type="password"
              placeholder="Введите пароль"
              required
            />
          </div>

          <div class="flex items-center justify-between">
            <v-button
              :disabled="isLogining"
              type="submit"
              :loading="isLogining"
              color="primary"
              >Регистрация
            </v-button>
          </div>
        </form>
      </v-card>
    </div>
  </div>
</template>



<script lang="ts">
import Vue from 'vue'
import axios from 'axios'
import pageTitle from '~/components/Global/page-title.vue'
import VButton from '~/components/UI/v-button.vue'
import VCard from '~/components/UI/v-card.vue'
import VInput from '~/components/UI/v-input.vue'
import VLabel from '~/components/UI/v-label.vue'
import VFormError from '~/components/UI/v-form-error.vue'
import { ModelResourseWrapper } from '~/lib/types'
import { Models } from '~/lib/Models'

export default Vue.extend({
  components: {
    pageTitle,
    VCard,
    VButton,
    VInput,
    VLabel,
    VFormError,
  },
  middleware({ $auth, redirect }) {
    if ($auth.loggedIn) redirect('/')
  },
  data() {
    return {
      isLogining: false,
      username: '123',
      password: '123456',
      email: '123@123.r2',
      formErorrs: [] as string[],
    }
  },

  methods: {
    async registerUser() {
      this.formErorrs = []
      this.isLogining = true
      const isValidated = await new Promise((resolve) =>
        setTimeout(() => {
          resolve(this.validate())
        }, 500)
      )
      if (!isValidated) {
        this.isLogining = false
        return
      }
      try {
        const apiResponseData = (
          await this.$axios.post<ModelResourseWrapper<Models.User>>(
            '/auth/register',
            {
              name: this.username,
              password: this.password,
              email: this.email,
            }
          )
        ).data
        this.$router.push('/')
      } catch (e: unknown) {
        if (axios.isAxiosError(e)) {
          this.formErorrs.push(e.response?.data.message)
        } else
          this.$toast.error(
            'Произошла непредвиденная ошибка. Попробуйте еще раз'
          )
      }
      this.isLogining = false
    },
    validate() {
      if (!this.username) {
        this.formErorrs.push(
          'Поле "Имя пользователя" обязательно для заполнения'
        )
        return false
      }
      if (!this.password) {
        this.formErorrs.push('Поле "Пароль" обязательно для заполнения')
        return false
      }
      if (this.password.length < 6) {
        this.formErorrs.push('Поле "Пароль" должно быть не менее 6 символов')
        return false
      }
      return true
    },
  },
})
</script>