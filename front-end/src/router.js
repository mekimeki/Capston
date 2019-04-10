import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)
import main from './views/Main';
import video_see from './views/Video_see';
import subtitle_create from './views/Subtitle_create';
import upload_page from './views/Upload_page';
import quiz_select from './views/Quiz_select';
import quiz_one from './views/Quiz_one';
export default new Router({
  mode:'history',//#を消す。
  routes:[
    {
      path:'/',
      name:'main',
      component:main,
    },
    {
      path:'/qselect',
      name:'qselect',
      component:quiz_select,
    },
    {
      path:'/quizOne',
      name:'quizOne',
      component:quiz_one,
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
  ]
});
