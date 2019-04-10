import axios from 'axios';

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
  login_page_actions : ({commit},payload) => {//login page move
    commit('login_page_mutation',payload);
  },
  upload_actions : ({commit},payload,check) => {
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
  video_cut_actions : ({commit},payload) => {
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

export default actions;
