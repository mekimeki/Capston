import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

export default new Vuex.Store({
  state:{
    video:"",
    subtitle:[],
  },
  getters:{
    video_getter: (state) => {
      return state.video;
    },
    subtitle_getter: (state) =>{
      return state.subtitle;
    }
  },
  mutations:{
    video_mutation: (state, payload) => {
      state.video = payload;
    },
    subtitle_mutation: (state, payload) => {
      state.subtitle = payload;
    }
  },
  actions:{
    video_action: ({commit},payload) => {
      commit('video_mutation',payload);
    },
    subtitle_action:({commit},payload) => {
      commit('subtitle_mutation',payload);
    }
  }
});
