import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

const main = () => {
  return import("./views/Main.vue");
};
const login_page = () => {
  return import("./views/Login_page");
};
import register from '@/components/login_/LoginRegister';
import passowrd_find from '@/components/login_/passwordFind';
import login from '@/components/login_/Login';
import video_see from '@/views/Video_see';
import create from '@/views/Create';
import upload from '@/components/createBox_/create/Upload';
import create_video from '@/components/createBox_/create/Video_create';
import create_subtitle from '@/components/createBox_/create/Subtitle_create';
import create_content from '@/components/createBox_/create/Content_create';
import create_message from '@/components/createBox_/create/CreateMessage';
//
import start from './views/Start_page'; //start page
import quiz_select from './views/Quiz_select'; //quiz
import quiz_one from './views/Quiz_one';


import word_book from '@/components/wordBook_/AllWord';

import gogo_book from '@/components/gogoBook_/GogoBoard';

import recommend from '@/components/mainPage_/Recommend';

import register_video from '@/components/mainPage_/Register';

import all_word from './views/Word_book';

//beforeEnter methods
const login_check = (path,query_check) => (to,from,next) => {//login and query check
  //to 에서 vuex에서 받은 정보 가지고 localStorage.getItem 부분에 박기
  if(localStorage.getItem('login')){//user check
    if(query_check){
      if(to.query[query_check]){//query check
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


export default new Router({
  mode:'history',//#を消す。
  routes:[
    { //start
      path:'/',
      name:'start',
      component:start,
    },
    { //main
      path:'/main',
      name:'main',
      component:main,
    },
    { //quizSelect
      path:'/qselect',
      name:'qselect',
      component:quiz_select,
    },
    { //quizOne
      path:'/quizOne',
      name:'quizOne',
      component:quiz_one,
    },
    { //allWord
      path:'/allWord',
      name:'allWord',
      component:word_book,
    },
    { //gogoBoard
      path:'/gogoBoard',
      name:'gogoBoard',
      component:gogo_book,
    },
    { //video
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
          // beforeEnter:login_check('/log/login','user'),
        },
        { //create video
          path:'video',
          name:'c-video',
          component:create_video,
          // beforeEnter:login_check('/log/login','video'),
        },
        { //create subtitle
          path:'subtitle',
          name:'subtitle',
          component:create_subtitle,
          // beforeEnter:login_check('/log/login','subtitle'),
        },
        { //create content
          path:'content',
          name:'content',
          component:create_content,
          // beforeEnter:login_check('/log/login','content'),
        },
        {
          path:'message',
          name:'message',
          component:create_message,
        }
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
    { //redirect
      path:'/*',
      redirect:{name:'main'},
    },
  ]
});
