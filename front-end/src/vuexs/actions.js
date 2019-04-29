import axios from 'axios';
import Service from '../api/service';

const service = new Service("http://172.26.4.110/");//axios api service class created

const actions = {
  video_action : ({commit},payload) => {//video action
    commit('video_mutation',payload);
  },
  video_link_action: ({commit},payload) =>{ //video link action
    return service.video_link("api/video/edit/",payload);
  },
  subtitle_answer_action: ({commit},payload) => { //subtitle answer action
    return service.subtitle_answer("api/subtitle/edit",payload);
  },
  subtitle_open_action: ({commit},payload) =>{//subtitle open action
    return service.subtitle_open('http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php');
  },
  content_action: ({commit},payload) => {
    commit('content_mutation',payload);
  },
  content_answer_action: ({commit},payload) => {
    return service.content_answer("http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php");
  },
  subtitle_action : ({commit},payload) => {//subtitle action
    commit('subtitle_mutation',payload);
  },
  subtitle_buffer_action : ({commit},payload) => {//subtitle create input subtitle buffer action
    commit('subtitle_buffer_mutation',payload);
  },
  subtitle_word_action : ({commit},payload) => {
    return service.subtitle_word("http://localhost/Capstone_practice/project_videoPlayer/api/test2.php",payload);
  },
  seek_bar_action : ({commit},payload) => {//video seek_bar action
    commit('seek_bar_mutation',payload);
  },
  capture_action : ({commit},payload) => {//capture element action
    commit('capture_mutation',payload);
  },
  capture_data_action : ({commit},payload) =>{
    commit('capture_data_mutation',service.capture_image('api/?',payload));
  },
  percent_action : ({commit},payload) => {//capture element action
    commit('upload_percent_mutation',payload);
  },
  login_actions : ({commit},payload) => {//login action
    service.login("api/login",payload).then(result => {
      localStorage.setItem('login',result.token);
      service.login_check("api/token",result.token).then(result => {
        commit('login_mutation',result);
      });
    });
  },
  login_check_actions : ({commit},payload) => {//login check action
    if(payload){
      service.login_check("api/token",payload).then(result => {
        commit('login_mutation',result);
      });
    }
  },
  logout_actions : ({commit}) => {//logout action
    let check = confirm("本当にlogout?");
    if(check){
      commit('logout_mutation');
    }else{
      alert("logoutX");
    }
  },
  upload_actions : ({commit},payload) => {//upload action
    const config = {
      onUploadProgress: function(progressEvent) {
        let percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
        commit('upload_percent_mutation',percentCompleted);
      }
    }
    if (payload.check) {//video
      service.csrf_check("csrf-token").then(result => {
        service.upload("api/video/originalUpload",payload.file,result,localStorage.getItem('login'),"",config)
        .then(result => {
          commit('upload_mutation',result);
        });
      });
    }else{//subtitle
      service.csrf_check("csrf-token").then(result => {
        service.upload("api/subtitle/originalUpload",payload.file,result,localStorage.getItem('login'),payload.video_pk,config)
        .then(result => {
          commit('upload_mutation',result);
        });
      });
    }
  },
  video_cut_actions : ({commit},payload) => {
    const config = {
      onUploadProgress: function(progressEvent) {
        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
        commit('upload_percent_mutation',percentCompleted);
      }
    }
    service.video_cut_upload('api/video/streamingUpload',payload,config).then(result => {
      commit('video_cut_mutation',result);
    });
  },
  upload_subtitle_actions: ({commit},payload) =>{
    const config = {
      onUploadProgress: function(progressEvent) {
        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
        commit('upload_percent_mutation',percentCompleted);
      }
    }
    service.subtitle_upload("api/subtitle/produce",payload,config).then(result=>{
      commit('upload_subtitle_mutations',result);
    });
  },
  search_action: ({commit},payload) =>{
    return service.search('',payload);
  },
  upload_content_actions:({commit},payload) =>{
    return service.content_upload('',payload).then(result=>{
      commit('upload_content_mutation',result);
    });
  }
}

export default actions;
