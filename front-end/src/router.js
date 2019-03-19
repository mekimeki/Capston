import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import main from './views/Main';
import video_see from './views/Video_see';

export default new Router({
  mode:'history',//#を消す。
  routes:[
    {
      path:'/',
      name:'main',
      component:main,
    },
    {
      path:'/video',
      name:'video',
      component:video_see,
    },
  ]
});
