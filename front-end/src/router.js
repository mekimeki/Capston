import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import main from './views/Main';
import video_see from './views/Video_see';
import subtitle_create from './views/Subtitle_create';
import upload_page from './views/Upload_page';
import video_create from './views/Video_create';
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
      path:'/upload',
      name:'upload',
      component:upload_page,
    },
    {
      path:'/videocreate',
      name:'videoCreate',
      component:video_create,
    },
  ]
});
