const getters = {
  video_getter: (state) => {
    return state.video;
  },
  subtitle_getter: (state) =>{
    return state.subtitle;
  },
  subtitle_buffer_getter: (state) =>{
    return state.subtitle_buffer;
  },
  subtitle_preview_getter: (state) =>{
    return state.subtitle_preview;
  },
  content_preview_getter: (state) =>{
    return state.content_preview;
  },
  bookmark_getter: (state) =>{
    return state.bookmark;
  },
  bookmark_image_getter: (state) =>{
    return state.bookmark_image;
  },
  seek_bar_getter: (state) =>{ //input[range] element getter
    return state.seek_bar;
  },
  login_getters: (state) =>{
    return state.login;
  },
  upload_getters: (state) =>{
    return state.upload;
  },
  video_cut_getters: (state) =>{
    return state.video_cut;
  }
}

export default getters;
