import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
import axios from 'axios';
export default new Vuex.Store({
  state:{
    video:"",
    subtitle:[],
    subtitle_buffer:[],
    seek_bar:"",
    login:{
      id:"",
      PassWord:"",
    },
  },
  getters:{
    video_getter: (state) => {
      return state.video;
    },
    subtitle_getter: (state) =>{
      return state.subtitle;
    },
    subtitle_buffer_getter: (state) =>{
      return state.subtitle_buffer;
    },
    seek_bar_getter:(state) =>{
      return state.seek_bar;
    },
    login_getters:(state) =>{
      return state.login;
    },
  },
  mutations:{
    video_mutation: (state, payload) => {
      state.video = payload;
    },
    subtitle_mutation: (state, payload) => {
      state.subtitle = payload;
    },
    subtitle_buffer_mutation: (state, payload) => {
      state.subtitle_buffer = payload;
    },
    seek_bar_mutation:(state,payload) => {
      state.seek_bar = payload;
    },
    login_mutation:(state,payload) => {
      state.login = payload;
    }
  },
  actions:{
    video_action: ({commit},payload) => {
      commit('video_mutation',payload);
    },
    subtitle_action:({commit},payload) => {
      commit('subtitle_mutation',payload);
    },
    subtitle_buffer_action:({commit},payload) => {
      commit('subtitle_buffer_mutation',payload);
    },
    seek_bar_action:({commit},payload) => {
      commit('seek_bar_mutation',payload);
    },
    login_actions:({commit},payload) => {
      commit('login_mutation',payload);
    }
  }
});
