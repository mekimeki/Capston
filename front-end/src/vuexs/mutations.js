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
    if(payload){
      state.upload.video = true;
    }else{
      state.upload.subtitle = true;
    }
  },
  video_cut_mutation: (state,payload) => {
    state.upload.firstTime = payload.firstTime;
    state.upload.lastTime = payload.lastTime;
  },
  upload_subtitle_mutations: (state,payload) =>{
    state.upload.subtitle_ = payload;
  },
  upload_content_mutations: (state,payload) =>{
    state.upload.content = payload;
  },
}

export default mutations;
