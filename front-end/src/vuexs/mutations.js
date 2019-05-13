const mutations = {
  video_mutation: (state, payload) => {
    state.video = payload;
  },
  subtitle_mutation: (state, payload) => {
    state.subtitle = payload;
  },
  subtitle_buffer_mutation: (state, payload) => {
    state.subtitle_buffer = payload;
  },
  subtitle_preview_mutation: (state, payload) => {
    state.subtitle_preview = payload;
  },
  upload_percent_mutation:(state,payload) => {
    state.percent = payload;
  },
  capture_mutation: (state,payload) => {
    state.capture = payload;
  },
  audio_mutation: (state,payload) => {
    state.audio = payload;
  },
  capture_data_mutation: (state,payload) =>{
    state.capture_data = payload;
  },
  content_preview_content_mutation: (state, payload) =>{
    if(typeof(payload.number) === 'boolean'){
      state.content_preview[0].content.push(payload.content);
    }else if(typeof(payload.number) === 'number'){
      state.content_preview[0].content.splice(payload.number,1);
    }
  },
  content_preview_word_mutation: (state, payload) =>{
    if(typeof(payload.number) === 'boolean'){
      state.content_preview[1].content.push(payload.content);
    }else if(typeof(payload.number) === 'number'){
      state.content_preview[1].content.splice(payload.number,1);
    }
  },
  bookamrk_mutation: (state,payload) =>{
    if (payload.indexOf('#') != -1) {
      payload = payload.split('#');
      state.bookmark[2].content.push({
        'title':payload[0],
        'textArea':payload[1],
      });
    }
    else{
      state.bookmark[3].content.push({
        'title':state.video.currentTime,
        'textArea':payload,
      });
    }
  },
  bookmark_image_mutation: (state,payload) =>{
    state.bookmark_image.push(payload);
  },
  content_mutation: (state, payload) =>{
    state.content = payload;
  },
  seek_bar_mutation: (state,payload) => {//seek bar mutation
    state.seek_bar = payload;
  },
  login_mutation: (state,payload) => {
    state.login = payload;
  },
  upload_mutation: (state,payload) => { //upload
    if(payload.video_pk){
      state.upload.video = payload.video_pk;
    }else if(payload.subtitle_pk){
      state.upload.subtitle = payload.subtitle_pk;
    }
  },
  video_cut_mutation: (state,payload) => {
    console.log('cut 2',payload);
    state.upload.firstTime = payload.firstTime;
    state.upload.lastTime = payload.lastTime;
  },
  upload_subtitle_mutations: (state,payload) =>{
    state.upload.subtitle_ = payload;
  },
  upload_content_mutations: (state,payload) =>{
    state.upload.content = payload;
  },
  share_content_mutation:(state,payload) =>{
    let number = state.bookmark[0].content.length;
    let check = true;
    for (let i = 0; i < number; i++) {
      console.log("??");
      if(payload.time.toFixed(1) < state.bookmark[0].content[i].firstTime){
        state.bookmark[0].content.splice(i,0,{
          "pk": payload.pk,
          "title": payload.title,
          "firstTime": payload.time,
          "lastTime": payload.time +2,
          "textArea": payload.content,
        });
        state.video.currentTime = payload.time-2;
        check = false;
        console.log(state.bookmark[0].content,"확인");
        break;
      }
    }
    if (check) {
      state.bookmark[0].content.push({
        "pk": payload.pk,
        "title": payload.title,
        "firstTime": payload.time,
        "lastTime": payload.time +2,
        "textArea": payload.content,
      });
      state.video.currentTime = payload.time-2;
    }
  },
  share_word_mutation:(state,payload) =>{
    let number = state.bookmark[1].content.length;
    console.log(number);
    let check = true;
    for (let i = 0; i < number; i++) {
      console.log("??");
      if(payload.time.toFixed(1) < state.bookmark[1].content[i].firstTime){
        state.bookmark[1].content.splice(i,0,{
          "pk": payload.pk,
          "title": payload.title,
          "firstTime": payload.time,
          "lastTime": payload.time +2,
          "textArea": payload.content,
        });
        check = false;
        console.log(state.bookmark[1].content,"확인");
        state.video.currentTime = payload.time-2;
        break;
      }
    }
    if (check) {
      state.bookmark[1].content.push({
        "pk": payload.pk,
        "title": payload.title,
        "firstTime": payload.time,
        "lastTime": payload.time +2,
        "textArea": payload.content,
      });
      state.video.currentTime = payload.time-2;
    }
  },
  share_content_update_mutation: (state,payload)=>{
    state.bookmark[0].content[payload.num].pk = payload.vo_pk;
  },
  graph_origin_mutations: (state,payload) =>{
    state.graph_origin = payload.analy;
  },
  graph_record_mutations: (state,payload) =>{
    console.log("mutations",payload);
    state.graph_record = payload.recordAnaly;
    state.graph_score = payload.score;
  },
  subtitle_record_mutation: (state,payload) =>{
    state.subtitle_record = payload;
  },
  graph_reset_mutation: (state,payload) =>{
    state.graph_score = 0;
    state.graph_origin = [];
    state.graph_record = [];
  }
}

export default mutations;
