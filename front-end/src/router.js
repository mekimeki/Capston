import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const video_see = () => {//top views
  return import("./views/Video_see.vue");
};

//create components
const create = () => {//top views
  return import("./views/Create.vue");
};
import upload from '@/components/createBox_/Upload';
import create_video from '@/views/Video_create';
import create_subtitle from '@/views/Subtitle_create';

//login components
const login_page = () => {//top views
  return import("./views/Login_page");
};
import register from '@/components/login_/LoginRegister';
import passowrd_find from '@/components/login_/passwordFind';
import login from '@/components/login_/Login';

import test from '@/views/Test';//test page

import start from '@/components/startPage_/StartPage'; //start page

import quiz_select from '@/components/quizPage_/Qselect'; //quiz
import quiz_one from './views/Quiz_one';

import all_word from '@/components/wordBook_/AllWord';

import recommend from '@/components/mainPage_/Recommend';

import register_video from '@/components/mainPage_/Register';

export default new Router({
  mode:'history',//#を消す。
  routes:[
    { //start
      path:'/',
      name:'start',
      component:start,
    },
    { //quizOne
      path:'/quizOne',
      name:'quizOne',
      component:quiz_one,
    },
    { //video
      path:'/video',
      name:'video',
      component:video_see,
      children:[
      ]
    },
    {
      path:'/main',
      name:'recommend',
      component:recommend,
      children:[
      {
      path:'/main',
      name:'register',
      component:register_video,
    },
      ]
    },
    { //quizSelect
      path:'/qselect',
      name:'qselect',
      component:quiz_select,
    },
    { //allWord
      path:'/allWord',
      name:'allWord',
      component:all_word,
    },
    { //create
      path:'/create',
      name:'create',
      component:create,
      children:[
        {
          path:'upload',
          name:'upload',
          component:upload,
        },
        {
          path:'c-video',
          name:'c-video',
          component:create_video,
          beforeEnter:(to, from, next) => {
            console.log("to",to.params.check);
            if (to.params.check) {
              next();
            }else {
              next('/create/upload');
            }
          }
        },
        {
          path:'subtitle',
          name:'subtitle',
          component:create_subtitle,
          beforeEnter:(to, from, next) => {
            console.log("to",to.params.check);
            if (to.params.check) {
              next();
            }else {
              next('/create/upload');
            }
          }
        },
      ]
    },
    { //login
      path:'/log',
      name:'login_page',
      component:login_page,
      children:[
        {
          path:'login',
          name:'login',
          component:login,
        },
        {
          path:'register',
          name:'register',
          component:register,
        },
        {
          path:'password',
          name:'password',
          component:passowrd_find,
        }
      ]
    },
    {
      path:'/test',
      name:'test',
      component:test,
    },
    { //redirect
      path:'/*',
      redirect:{name:'/'},
    },
  ]
});
