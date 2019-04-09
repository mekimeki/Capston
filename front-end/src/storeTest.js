import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);
import axios from 'axios';

export default new Vuex.Store({
  state:{
    video:"",
    subtitle:[],
    subtitle_buffer:[],
    seek_bar:"",
    login:{
      email:"",
      PassWord:"",
    },
    login_page:"",
    upload:{//upload
      video:false,
      subtitle:false,
    },
    video_cut:false,
  },
  getters:{
    video_getter: (state) => {
      return state.video;
    },
    subtitle_getter: (state) =>{
      return state.subtitle;
    },
    subtitle_buffer_getter: (state) =>{
      return state.subtitle_buffer;
    },
    seek_bar_getter:(state) =>{
      return state.seek_bar;
    },
    login_getters:(state) =>{
      return state.login;
    },
    login_page_getters:(state) =>{//login page check getters
      return state.login_page;
    },
    upload_getters:(state) =>{
      return state.upload;
    },
    video_cut_getters:(state) =>{
      return state.video_cut;
    }
  },
  mutations:{
    video_mutation: (state, payload) => {
      state.video = payload;
    },
    subtitle_mutation: (state, payload) => {
      state.subtitle = payload;
    },
    subtitle_buffer_mutation: (state, payload) => {
      state.subtitle_buffer = payload;
    },
    seek_bar_mutation:(state,payload) => {
      state.seek_bar = payload;
    },
    login_mutation:(state,payload) => {
      state.login = payload;
    },
    login_page_mutation:(state,payload) => {
      state.login_page = payload;
    },
    upload_mutation:(state,payload) => { //upload
      if(payload){
        state.upload.video = true;
      }else{
        state.upload.subtitle = true;
      }
    },
    video_cut_mutation:(state,payload) => {
      state.video_cut = payload;
    },
  },
  actions:{
    video_action: ({commit},payload) => {//video actions
      commit('video_mutation',payload);
    },
    subtitle_action:({commit},payload) => {//subtitle actions
      commit('subtitle_mutation',payload);
    },
    subtitle_buffer_action:({commit},payload) => {//subtitle create input subtitle buffer actions
      commit('subtitle_buffer_mutation',payload);
    },
    seek_bar_action:({commit},payload) => {//video seek_bar actions
      commit('seek_bar_mutation',payload);
    },
    login_actions:({commit},payload) => {//login actions
      if(!(payload.email&&payload.password)){
        alert("빈칸 입니당");
      }else{
        let url = "";//login url;

        let form = new FormData();
        form.append("email",payload.email);
        form.append("password",payload.password);

        axios.post(url).then((res)=>{
          console.log(res.data);
        },(error)=>{alert("연결을 확인해 주세요")});
        commit('login_mutation',payload);
      }
    },
    login_page_actions:({commit},payload) => {//login page move
      commit('login_page_mutation',payload);
    },
    upload_actions:({commit},payload,check) => {
      let form = new FormData();
      if (check) {
        form.append("video",payload);
        commit('upload_mutation',true);
      }else{
        form.append("subtitle",payload);
        commit('upload_mutation',false);
      }

      // let url_token = "http://172.26.3.246/get-token"
      // // let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/TestUpload.php";
      // let url = "http://172.26.3.246/upload"
      // axios.get(url_token).then((res)=>{
      //   //
      //   console.log(res.data);
      //   if (res.data) {
      //     form.append("_token",res.data);
      //     console.log(form);
      //     axios.post(url,form).then((res) => {
      //       console.log(res.data);
      //       if(res.data){
      //         if(check){
      //           commit('upload_mutation',true);
      //         }else {
      //           commit('upload_mutation',false);
      //         }
      //       }else{
      //         alert("업로드 실패");
      //       }
      //     }).catch( error => {
      //       console.log('failed', error);
      //     });
      //   }
      //   //
      // }).catch( error => {
      //   console.log('failed',error);
      // });

    },
    video_cut_actions:({commit},payload) => {
      let form = new FormData();
      form.append("time",JSON.stringify(payload));
      let url = `http://localhost/FFMPEGTEST/ffmpeg_test.php`;
      alert("준비중입니다.");
      axios.post(url,form).then( (res) => {
        console.log(res.data);
        if(res.data){
          alert("준비 끝 났습니다.");
          commit('video_cut_mutation',true);
        }
      }).catch( error => {
        console.log('failed', error);
      });
    }
  }
});
