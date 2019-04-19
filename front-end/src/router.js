import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const main = () => {
  return import("./views/Main.vue");
};
const video_see = () => {
  return import("./views/Video_see.vue");
};

//create components
const create = () => {
  return import("./views/Create.vue");
};
import upload from '@/components/createBox_/create/Upload';
import create_video from '@/components/createBox_/create/Video_create';
import create_subtitle from '@/components/createBox_/create/Subtitle_create';
import create_content from '@/components/createBox_/create/Content_create';
import create_message from '@/components/createBox_/create/CreateMessage';

//login components
const login_page = () => {//top views
  return import("./views/Login_page");
};
import register from '@/components/login_/LoginRegister';
import passowrd_find from '@/components/login_/passwordFind';
import login from '@/components/login_/Login';

//beforeEnter methods
const login_check = (path,query_check) => (to,from,next) => {//login and query check .1
  if(localStorage.getItem('login')){//user check
    if(query_check){
      if(to.query[query_check]){//querycheck
        next();
      }else{
        next('/');
      }
    }else{
      next(path);
    }
  }else{
    next(path);
  }
}


import test from '@/views/Test';//test page

export default new Router({
  mode:'history',//#を消す。
  routes:[
    { // main
      path:'/',
      name:'main',
      component:main,
    },
    { //video view
      path:'/video',
      name:'v-video',
      component:video_see,

    },
    { //create routers
      path:'/create',
      name:'create',
      component:create,
      children:[
        { //upload
          path:'upload',
          name:'upload',
          component:upload,
          beforeEnter:login_check('/log/login','user'),
        },
        { //create video
          path:'video',
          name:'c-video',
          component:create_video,
          beforeEnter:login_check('/log/login','video'),
        },
        { //create subtitle
          path:'subtitle',
          name:'subtitle',
          component:create_subtitle,
          beforeEnter:login_check('/log/login','subtitle'),
        },
        { //create content
          path:'content',
          name:'content',
          component:create_content,
          beforeEnter:login_check('/log/login','content'),
        },
      ]
    },
    { //login
      path:'/log',
      name:'login_page',
      component:login_page,
      children:[
        { //login
          path:'login',
          name:'login',
          component:login,
        },
        { //register
          path:'register',
          name:'register',
          component:register,
        },
        { //password find
          path:'password',
          name:'password',
          component:passowrd_find,
        }
      ]
    },
    { //test record
      path:'/test',
      name:'test',
      component:test,
    },
    { //redirect
      path:'/*',
      redirect:{name:'main'},
    },
  ]
});
