import axios from 'axios';
import Service from '../api/service'

const service = new Service('http://172.26.3.143/');


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
        // alert("준비 끝 났습니다.");
        console.log("준비끝");
        commit('video_cut_mutation',true);
      }
    }).catch( error => {
      console.log('failed', error);
    });
  },

  quest_actions : ({ commit },payload) => {
    return service.quiz_quest('api/quiz',payload);
  },

  quest_post_actions : ({commit},payload) =>{
    service.token_('get-token').then(result =>{
      if(result){
        return service.quiz_post('api/quiz',payload,result);
      }
    }).catch(result =>{
      alert('_token error');
    });
  },

  // word_delete_actions : ({ commit }, payload) =>{
  //   service.token_('get-token').then(result => {
  //     console.log(result)
  //     if(result) {
  //       return service.word_delete_post('api/deletedWord',payload,result);
  //     }
  //   }).catch(result => {
  //     alert('word delete error')
  //   })
  // },

 


}

export default actions;
