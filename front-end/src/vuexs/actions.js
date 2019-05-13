import axios from 'axios';
import Service from '../api/service'

const service = new Service('http://172.26.2.223/');


// import Service from '../api/service';
// // 172.26.4.110
// const service = new Service("http://172.26.4.110/");//axios api service class created
// // 172.26.3.143

const actions = {
  video_action : ({commit},payload) => {//video actions
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
  audio_action: ({commit},payload) =>{
    commit('audio_mutation',payload);
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
  seek_bar_action : ({commit},payload) => {//video seek_bar actions
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
  upload_actions : ({commit},payload,check) => {
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
      console.log("cut 1",result);
      commit('video_cut_mutation',result);
    });
  },
  subtitle_word_action : ({commit},payload) => {
    return service.subtitle_word("http://localhost/Capstone_practice/project_videoPlayer/api/test2.php",payload);
  },
  upload_subtitle_actions: ({commit},payload) =>{
    const config = {
      onUploadProgress: function(progressEvent) {
        var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total )
        commit('upload_percent_mutation',percentCompleted);
      }
    }
    service.subtitle_upload("api/subtitle/produce",payload,config).then(result=>{
      console.log('subtitle upload',result);
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

  //quiz actions
  quest_actions : ({ commit },payload) => {
    return service.quiz_quest('api/quiz',payload);
  },
  quest_post_actions : ({commit},payload) =>{
    return service.quiz_post('api/insertResult',payload);  
  },

  //word delete actions
  word_delete_actions : ({ commit }, payload) =>{
    return service.word_delete_post('api/deletedWord',payload);
  },
  //word crawl actions
  word_crawl_actions : ({ commit }, payload) => {
    return service.word_crawl_post('api/example', payload);
  },
  //call album actions
  call_album_actions : ({ commit }, payload) => {
    console.log(payload);
    return service.call_album_post('api/create', payload);
  },
  //all word actions
  all_word_actions : ({ commint }, payload) => {
    if(payload == 0){
      return service.all_word_quest('api/book/0', payload);
    }else if(payload == 1){
      return service.all_word_quest('api/memo/T', payload);
    }else{
      return service.all_word_quest('api/memo/F', payload);      
    }
  },
  //classify word actions
  classify_word_actions : ({ commit },payload) => {
    return service.classify_word_quest('api/book/0',payload);
  },
  //selected word quest
  select_word_actions : ({ commit },payload) => {
    return service.select_word_quest('api/book/'+ payload, payload)
  },
   //update word actions
  update_word_actions : ({ commit }, payload) => {
    return service.update_word_post('api/update',payload);
  },


  upload_created_action: ({commit},payload) =>{
    return service.upload_created('api/video/enrollment',payload);
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
  bookmark_save_subtitle_action: ({commit},payload) =>{
    return service.bookmark_subtitle('/api/getLine',payload);
  },
  bookmark_save_word_action: ({commit},payload) =>{
    return service.bookmark_word('/api/getWord',payload);
  },
  video_explain_action: ({commit},payload) =>{
    return service.video_explain('/api/videoInfo/explain/',payload);
  },
  recommend_action: ({commit},payload) => { //main page 용
    return service.recommend('',payload);
  },
  share_content_action: ({commit},payload) =>{
    service.share_content('api/voca/insert',payload).then(result=>{
      console.log('content',result);
      commit('share_content_mutation',payload);
    });
  },
  share_content_update_action:({commit},payload)=>{
    return service.share_cocntent_update('api/voca/update',payload).then(result=>{
      let data = {
        'vo_pk':result.vo_pk,
        'num':payload.num,
      }
      commit('share_content_update_mutation',data);
    });
  },
  share_word_action: ({commit},payload) =>{
    //여기 controller 만들어야 함 .
    service.share_word('',payload).then(result=>{
      console.log('word',result);
      commit('share_word_mutation',payload);
    });
  },
  history_action: ({commit},payload) =>{
    return service.history('api/voca/history',payload);
  },
  graph_origin_action: ({commit},payload) =>{
    return service.graph_origin('api/voice/extraction',payload).then(result=>{
      console.log('graph origin data',result);
      commit('graph_origin_mutations',result);
    });
  },
  graph_record_action: ({commit},payload) =>{
    return service.graph_record('api/voice/record',payload).then(result=>{
      console.log('graph record data',result);
      commit('graph_record_mutations',result);
    });
  },
  subtitle_record_action: ({commit},payload) =>{
    commit('subtitle_record_mutation',payload);
  }

}
export default actions;
