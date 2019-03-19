import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
  state:{
    video:"",
  },
  getters:{
    video_getter: (state) => {
      return state.video;
    }
  },
  mutations:{
    video_mutation: (state, payload) => {
      state.video = payload;
    }
  },
  actions:{
    video_action: ({commit},payload) => {
      commit('video_mutation',payload);
    }
  }
});
