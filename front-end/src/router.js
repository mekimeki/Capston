import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import main from '@/views/Main';
import video_see from '@/views/Video_see';
import subtitle_create from '@/views/Subtitle_create';
import create from '@/views/Create';
import login_page from '@/views/Login_page';

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
    {
      path:'/subCreate',
      name:'subtitleCreate',
      component:subtitle_create,
    },
    {
      path:'/create',
      name:'create',
      component:create,
    },
    {
      path:'/login',
      name:'login_page',
      component:login_page,
    },
  ]
});
