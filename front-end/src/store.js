import Vue from 'vue';
import Vuex from 'vuex';
import state from '@/vuexs/state';
import getters from '@/vuexs/getters';
import mutations from '@/vuexs/mutations';
import actions from '@/vuexs/actions';

Vue.use(Vuex);
export default new Vuex.Store({
  state:state,
  getters:getters,
  mutations:mutations,
  actions:actions,
})
