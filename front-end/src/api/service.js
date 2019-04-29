import axios from 'axios';//axios
import router from '../router';//router

export default class Service {
  constructor(domain){
    this.domain = domain;//back-end URL address
    this.form = new FormData();
  }
  service_post(url,form){
    return axios.post(url,form)
    .then(res=>res.data)
    .catch(res=>{
      // router.push({name:'main'});
      alert("service err");
    });
  }
  service_post_up(url,form,config){//update post
    return axios.post(url,form,config)
    .then(res=>res.data)
    .catch(res=>{
      // router.push({name:'upload'})
      alert("service err");
    });
  }
  service_get(url){
    return axios.get(url)
    .then(res=>res.data)
    .catch(res=>{
      // router.push({name:'main'});
      alert("service err");
    });
  }
  login(request,data){
    this.form.append("email",data.email);
    this.form.append("password",data.password);
    return this.service_post(this.domain+request,this.form);
  }
  login_check(request,data){
    this.form.append("token",data);
    return this.service_post(this.domain+request,this.form);
  }
  video_link(request,data){
    return this.service_get(this.domain+request+data);
  }
  subtitle_answer(request,data){
    this.form.append('video_pk',data.video);
    this.form.append('firstTime',data.firstTime);
    this.form.append('lastTime',data.lastTime);
    return this.service_post(this.domain+request,this.form);
  }
  subtitle_open(request,data){
    return this.service_get(request);
  }
  content_answer(request){
    return this.service_get(request);
  }
  capture_image(request,data){
    return 'imageNum';
    //capture image
  }
  csrf_check(request){
    return this.service_get(this.domain+request);
  }
  upload(request,data,_token,token,video_pk,config){
    if(video_pk){
      this.form.append("subtitle",data);//file data
      this.form.append("video_pk",video_pk);
    }else{
      this.form.append("video",data);//file data
    }
    this.form.append("_token",_token);//csrf token
    this.form.append("token",token);//jwt token
    return this.service_post_up(this.domain+request,this.form,config);
  }
  video_cut_upload(request,data,config){
    this.form.append('video_pk',data.video_pk);
    this.form.append('firstTime',data.firstTime);
    this.form.append('lastTime',data.lastTime);
    return this.service_post_up(this.domain+request,this.form,config);
  }
  subtitle_upload(request,data,config){
    this.form.append("data",JSON.stringify(data.content));
    this.form.append("video_pk",data.video);
    return this.service_post_up(this.domain+request,this.form,config);
  }
  content_upload(request,data){
    this.form.append("content",JSON.stringify(data));
    return this.service_post(this.domain+request,this.form);
  }
  subtitle_word(request,data){
    this.form.append('data',data);
    return this.service_post(request,this.form);
  }
  search(request,data){
    this.from.append('data',data);
    return this.service_post(request,this.from);
  }

}
