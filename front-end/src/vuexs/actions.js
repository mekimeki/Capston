import axios from 'axios';
import router from '../router';

const actions = {
  video_action : ({commit},payload) => {//video actions
    commit('video_mutation',payload);
  },
  subtitle_action : ({commit},payload) => {//subtitle actions
    commit('subtitle_mutation',payload);
  },
  subtitle_buffer_action : ({commit},payload) => {//subtitle create input subtitle buffer actions
    commit('subtitle_buffer_mutation',payload);
  },
  seek_bar_action : ({commit},payload) => {//video seek_bar actions
    commit('seek_bar_mutation',payload);
  },
  login_actions : ({commit},payload) => {//login actions
    //axios 동기식 하는방법
    if(payload.email&&payload.password){
      let url = "http://172.26.2.56/api/login";
      let form = new FormData();
      form.append("email",payload.email);
      form.append("password",payload.password);
      axios.post(url,form).then((res)=>{
        let token = res.data.token;
        url = "http://172.26.2.56/api/token";
        form = new FormData();
        form.append("token",res.data.token);
        axios.post(url,form).then((res)=>{//login axios
          localStorage.setItem('login',token);
          commit('login_mutation',res.data);
        },(error)=>{alert("연결을 확인해 주세요")});

      },(error)=>{alert("연결을 확인해 주세요")});
    }else{
      let url = "http://172.26.2.56/api/token";
      let form = new FormData();
      form.append("token",payload);
      axios.post(url,form).then((res)=>{//login axios
        commit('login_mutation',res.data);
      },(error)=>{alert("연결을 확인해 주세요")});
    }
  },
  upload_actions : ({commit},payload,check) => {//upload action
    console.log("f",payload);
    let form = new FormData();
    if (check) {//video
      form.append("video",payload);
      // commit('upload_mutation',payload.name);
    }else{//subtitle
      form.append("subtitle",payload);
      // commit('upload_mutation',payload.name);
    }
    form.append("token",localStorage.getItem('login'));

    // let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/TestUpload.php";
    let url = "http://172.26.2.56/api/upload"
    // axios.get(url_token).then((res)=>{//upload axios
    //   console.log(res.data);
    //   if (res.data) {
    //     form.append("_token",res.data);
    //     console.log(form);
        // axios.post(url,form).then((res) => {
        //   console.log(res.data);
        //   if(res.data){
        //     if(check){
        //       commit('upload_mutation',true);
        //     }else {
        //       commit('upload_mutation',false);
        //     }
        //   }else{
        //     alert("업로드 실패");
        //   }
        // }).catch( error => {
        //   console.log('failed', error);
        // });
    //   }
    //   //
    // }).catch( error => {
    //   console.log('failed',error);
    // });
  },
  video_cut_actions : ({commit},payload) => {
    let form = new FormData();
    form.append("time",JSON.stringify(payload));
    let url = `http://localhost/FFMPEGTEST/ffmpeg_test.php`;
    alert("준비중입니다.");
    axios.post(url,form).then( (res) => {//video_cut axios
      commit('video_cut_mutation',res.data);
    }).catch( error => {
      console.log('failed', error);
    });
  },
  upload_subtitle_actions: ({commit},payload) =>{
    let form = new FormData();
    form.append("subtitle",JSON.stringify(payload));
    let url = `http://localhost/Capstone_practice/project_videoPlayer/videoBack/TestVideo.php`;
    axios.post(url,form).then( (res) => {
      commit('upload_subtitle_mutations',res.data);
    }).catch( error => {
      console.log('failed', error);
    });
  },
  upload_content_actions: ({commit},payload) =>{
    commit('upload_content_mutations',true);
    // let form = new FormData();
    // form.append("content",JSON.stringify(payload));
    // let url = ``;
    // axios.post(url,form).then( (res) => {
    //   console.log(res.data);
    //   commit('upload_content_mutations',res.data);
    // }).catch( error => {
    //   console.log('failed', error);
    // });
  }
}

export default actions;
