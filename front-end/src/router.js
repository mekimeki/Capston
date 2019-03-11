import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import video from './components/Video';

export default new Router({
  mode:'history',//#を消す。
  routes:[
    {
      path:'/video',
      name:'video',
      component:video,
    },
  ]
});
