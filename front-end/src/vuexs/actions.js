import axios from 'axios';
import Service from '../api/service';
// 172.26.4.110
const service = new Service("http://172.26.4.110/");//axios api service class created
// 172.26.3.143
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
  subtitle_preview_action: ({commit},payload) =>{
    commit('subtitle_preview_mutation',payload);
  },
  content_action: ({commit},payload) => {
    commit('content_mutation',payload);
  },
  content_answer_action: ({commit},payload) => {
    return service.content_answer("http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php");
  },
  content_preview_content_action: ({commit},payload) =>{
    commit('content_preview_content_mutation',payload);
  },
  content_preview_word_action: ({commit},payload) =>{
    commit('content_preview_word_mutation',payload);
  },
  subtitle_action : ({commit},payload) => {//subtitle action
    commit('subtitle_mutation',payload);
  },
  subtitle_buffer_action : ({commit},payload) => {//subtitle create input subtitle buffer action
    console.log(payload);
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
    commit('capture_data_mutation',payload);
  },
  bookmark_action : ({commit},payload) =>{
    commit('bookamrk_mutation',payload);
  },
  bookmark_image_action : ({commit},payload) =>{
    commit('bookmark_image_mutation',payload);
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
      console.log('fff',result);
      commit('upload_subtitle_mutations',result);
    });
  },
  search_content_action: ({commit},payload) =>{
    return service.search_content('api/voca/search',payload);
  },
  search_word_action:({commit},payload) =>{
    return service.search_word('api/word/searchEn',payload);
  },
  search_action:({commit},payload) =>{
    return service.search('api/searchEn',payload);
  },
  upload_content_action:({commit},payload) =>{
    return service.content_upload('api/voca/add',payload).then(result=>{
      commit('upload_content_mutations',result);
    });
  },
  upload_created_action: ({commit},payload) =>{
    return service.upload_created('api/video/enrollment',payload);
  },
  share_actions: ({commit},payload)=>{
    return service.share('',payload);
  },
  video_cut_image_action: ({commit},payload) =>{
    return service.video_cut_image('api/video/snapShot/',payload);
  },
  //video view actions
  video_link_view_action: ({commit},payload) =>{
    return service.video_link_view('/api/videoInfo/address/',payload);
  },
  subtitle_view_action: ({commit},payload) =>{
    return service.subtitle_view('/api/videoInfo/subtitle/',payload);
  },
  content_view_action: ({commit},payload) =>{
    return service.content_view('/api/videoInfo/content/',payload);
  },
  content_explain_action: ({commit},payload) =>{
    return service.content_explain('',payload);
  },
  bookmark_save_action: ({commit},payload) =>{
    return service.bookmark('/api/getLine',payload);
  },
  video_explain_action: ({commit},payload) =>{
    return service.video_explain('/api/videoInfo/explain/',payload);
  }
}

export default actions;
