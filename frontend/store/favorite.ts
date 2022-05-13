import { GetterTree, ActionTree, MutationTree } from "vuex";
import { Context } from "@nuxt/types";
import { RootState } from ".";
import { Models } from "~/lib/Models";
import { ModelResourseWrapper } from "~/lib/types";


export const state = () => ({
  favoriteContacts: [] as Models.Contact[]
})


export type FavoriteState = ReturnType<typeof state>;

export enum FavoriteGetters {
}

export const getters: GetterTree<FavoriteState, RootState> = {

}


export enum FavoriteMutations {
  SET_CONTACT_FAVORATES = "SET_CONTACT_FAVORATES",
  ADD_CONTACT_FAVORITE_ITEM = "ADD_CONTACT_FAVORITE_ITEM",
  DELETE_CONTACT_FAVORITE_ITEM = "DELETE_CONTACT_FAVORITE_ITEM"
}

export const mutations: MutationTree<FavoriteState> = {
  [FavoriteMutations.SET_CONTACT_FAVORATES](state, payload) {
    state.favoriteContacts = payload;
  },
  [FavoriteMutations.ADD_CONTACT_FAVORITE_ITEM](state, payload: Models.Contact) {
    state.favoriteContacts.push(payload);
  },
  [FavoriteMutations.DELETE_CONTACT_FAVORITE_ITEM](state, id) {
    const deletedItemIndex = state.favoriteContacts.findIndex(contact => contact.id === id);
    if (deletedItemIndex > -1) {
      state.favoriteContacts.splice(deletedItemIndex, 1);
    }
  },
}

export enum FavoriteAction {
  ADD_CONTACT_TO_FAVORITE = "addContactToFavorite",
  DELETE_CONTACT_FROM_FAVORITE = "deleteContactToFavorite",
  LOAD_FAVORITE_CONTACTS = "loadFavoriteContacts"
}

export const actions: ActionTree<FavoriteState, RootState> = {
  async [FavoriteAction.ADD_CONTACT_TO_FAVORITE]({ commit }, id) {
    const apiReponseData = (await (await this.$axios.get<ModelResourseWrapper<Models.Contact>>(`/contacts/favorite/${id}`)).data)
    const favoriteContact = apiReponseData.data;
    commit(FavoriteMutations.ADD_CONTACT_FAVORITE_ITEM, favoriteContact)
  },
  async [FavoriteAction.DELETE_CONTACT_FROM_FAVORITE]({ commit }, id: number) {
    await this.$axios.delete(`/contacts/favorite/${id}`)
    commit(FavoriteMutations.DELETE_CONTACT_FAVORITE_ITEM, id);
  },
  async [FavoriteAction.LOAD_FAVORITE_CONTACTS]({ commit }) {
    const apiResponseData = (await this.$axios.get<ModelResourseWrapper<Models.Contact>>('/contacts/favorite')).data;
    const favoriteContacts = apiResponseData.data;
    commit(FavoriteMutations.SET_CONTACT_FAVORATES, favoriteContacts);
  },
  async nuxtServerInit({ dispatch }) {
    // Если надо загрузить избарнное один раз за сессию
    if (this.$auth.loggedIn) await dispatch(FavoriteAction.LOAD_FAVORITE_CONTACTS)
  }
}
