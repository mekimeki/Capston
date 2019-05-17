<template lang="html">
  <div>
    <!-- <div class="check_card" v-show="card_check.cotnent">문법카드가 추가되었습니다.</div>
    <div class="check_card pa-2" v-show="card_check.word">단어카드가 추가되었습니다.</div> -->
    <v-tabs slider-color="teal lighten-1" class="ma-1" grow>
        <v-tab v-for="mark in b_getter" :key="mark.name" ripple>
            {{ mark.tab }}
            <span class="pl-2"></span><input style="width:30px;" class="check_card"  v-show="mark.tab ==='문법'" v-model="card_check.content_num"/>
            <input style="width:30px;" class="check_card"  v-show="mark.tab === '단어'" v-model="card_check.word_num"/>
        </v-tab>
        <v-tab-item v-for="(mark, i) in b_getter" :key="i">
          <div id="scroll_div">
            <div class="" v-if="mark.name === 'content'">

              <v-card v-for="(tent, i) in mark.content" :key="i" v-if="i< check_content" class="ma-1">
                <!-- v-if="i< content_check" 때문에 카드 추가 할때 안됨 -->
                <v-card-title primary-title>
                  <div class="content_card">
                    <h4 class="headline mb-0" v-if="!(mark.name === 'subtitleBook')">{{tent.title}}</h4>
                    <img :src="bi_getter[i]" alt="" v-if="mark.name === 'subtitleBook'" width="200" height="100" crossOrigin = "Anonymous">
                    <div>
                      <input type="text" name="" value="" v-model="tent.textArea">
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn flat small color="teal lighten-1" v-on:click="click_update_share(tent,mark.name,i)">
                    <v-icon>check</v-icon>참여
                  </v-btn>
                  <v-btn flat small color="teal lighten-1" v-on:click="click_history(tent.title)">
                    <v-icon>check</v-icon>히스토리
                  </v-btn>
                </v-card-actions>
              </v-card>

            </div>

            <div class="" v-else-if="mark.name === 'word'">
              <v-card v-for="(tent, i) in mark.content" :key="i" v-if="i< check_word" class="ma-1">
                <!-- v-if="i< content_check" 때문에 카드 추가 할때 안됨 -->
                <v-card-title primary-title>
                  <div class="word_card">
                    <h4 class="headline mb-0" v-if="!(mark.name === 'subtitleBook')">{{tent.title}}</h4>
                    <img :src="bi_getter[i]" alt="" v-if="mark.name === 'subtitleBook'" width="200" height="100" crossOrigin = "Anonymous">
                    <div>
                      <input type="text" name="" value="" v-model="tent.textArea">
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>

                </v-card-actions>
              </v-card>
            </div>

            <div class="" v-else>
              <v-card v-for="(tent, i) in mark.content" :key="i">
                <v-card-title primary-title>
                  <div>
                    <h4 class="headline mb-0" v-if="!(mark.name === 'subtitleBook')">{{tent.title}}</h4>
                    <img :src="bi_getter[i]" alt="" v-if="mark.name === 'subtitleBook'" width="200" height="100">
                    <div>
                      <input type="text" name="" value="" v-model="tent.textArea">
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn flat small color="teal lighten-1" v-on:click="click_bookmark(i,tent,mark.name,$event)">
                    <v-icon>check</v-icon>SAVE
                  </v-btn>
                </v-card-actions>
              </v-card>
            </div>

          </div>
          <v-card class="ma-2" v-show="mark.name === 'content'">
            <v-card-title primary-title>
              <v-layout row wrap>
                <v-flex xl12 sm12 md12>
                  <v-text-field
                    height="20"
                    label="문법"
                    v-model="share.title"
                  ></v-text-field>
                </v-flex>
                <v-flex xl12 sm12 md12>
                  <v-text-field
                    height="20"
                    label="문법설명"
                    v-model="share.content"
                  ></v-text-field>
                </v-flex>
              </v-layout>
            </v-card-title>
            <v-card-actions>
              <v-btn right flat small color="teal lighten-1" v-on:click="click_share(share.title,share.content,mark.name)">
                <v-icon>check</v-icon>참여
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-tab-item>
    </v-tabs>

      <v-layout row justify-center>
      <v-dialog v-model="dialog" scrollable max-width="300px">
        <template v-slot:activator="{ on }">
        </template>
        <v-card>
          <v-card-title>HISTORY</v-card-title>
          <v-divider></v-divider>
          <v-card-text style="height: 300px;">
            <v-card v-for="(content,i) in history_content" :key="i">
              <v-card-title primary-title>
                <div>
                  <h4 class="headline mb-0">{{ content.voca }}</h4>
                  <h5>{{ content.explain }}</h5>
                  <v-icon color="teal lighten-1">ballot</v-icon>{{i}}
                </div>
              </v-card-title>
            </v-card>
          </v-card-text>
          <v-divider></v-divider>
          <!-- <v-card-actions>
            <v-layout justify-end>
              <v-btn color="teal lighten-1" flat @click="dialog = false">
                <v-icon>
                  close
                </v-icon>
              </v-btn>
            </v-layout>
          </v-card-actions> -->
        </v-card>
      </v-dialog>
    </v-layout>

  </div>
</template>

<script>
import { mapActions, mapGetters} from 'vuex';
import { log } from 'util';
export default {
  data(){
    return{
      video:"",//video
      video_time_check_c:"",//video time checks
      video_time_check_w:"",
      check:0,//content check
      check_word:0,
      check_content:0,
      share:{
        title:"",
        content:"",
      },
      dialog:false,
      history_content:[],
      card_check:{
        word:false,
        word_num:0,
        content:false,
        content_num:0,
      }
    }
  },
  methods:{
    ...mapActions(['content_answer_action','content_action','content_view_action','bookmark_save_subtitle_action','bookmark_save_word_action','share_content_action','share_word_action','history_action','share_content_update_action']),
    click_share(title,content,name){
      if(confirm("참여 하시겠습니까?")){
        let data = {
          'time':this.video.currentTime,
          'pk':this.$route.query.video,
          'title': title,
          'content': content,
        }
        if(name === 'content'){
          this.share_content_action(data);
        }else{
          this.share_word_action(data);
        }
      }
    },
    click_update_share(data,name,num){
      if(confirm("참여 하시겠습니까?")){
        let data_s = {
          'vo_pk':data.pk,
          'voca':data.title,
          'video_pk':this.$route.query.video,
          'explain':data.textArea,
          'time':data.firstTime,
          'num':num,
        }
        this.share_content_update_action(data_s);
      }else{

      }
    },
    click_history(title){
      this.dialog =true;
      this.history_action(title).then(result=>{
        this.history_content = result;
      });
    },
    click_bookmark(num,value,name,evt){
      if(evt.target.innerHTML === '저장됨'){
        alert('이미 저장 되었습니다.');
      }else{
        if(name == 'subtitleBook'){
          console.log('????',value);
          let data = {
            'video_pk':this.$route.query.video,
            'title': value.title,
            'explain': value.textArea,
            'picture': this.bi_getter[num],
          }
          this.bookmark_save_subtitle_action(data).then(result=>{
            console.log("bookmark check1",result);
            evt.target.innerHTML = '저장됨';
            // alert("저장되었습니다.");
          });
        }else if(name == 'wordBook'){//word
          let data = {
            'email': this.l_getter.email,
            'title':value.title,
          }
          this.bookmark_save_word_action(data).then(result=>{
            console.log("bookmark check2",result);
            // alert("저장되었습니다.");
            evt.target.innerHTML = '저장됨';
          });
        }
      }
    },
    check_view(data,view,time){
      for (let i = 0; i < view.content.length; i++) {
        if(data.toFixed(1) === view.content[i].firstTime.toFixed(1)){
          time = 1+ i;
          document.getElementById('scroll_div').scrollTop = document.getElementById('scroll_div').scrollHeight;
        }
      }
    },
  },
  mounted:function(){
    this.video = this.v_getter;//video element getter

    this.content_view_action(this.$route.query.video).then(result=>{
      console.log('content',result);
        for (let i = 0; i < result.voca.length; i++) {
          this.b_getter[0].content.push({
            "pk":result.voca[i][3],
            "title":result.voca[i][2][0],
            "firstTime":result.voca[i][1][0],
            "lastTime":result.voca[i][1][1],
            "textArea":result.voca[i][2][1],
          });
        }
        for (let i = 0; i < result.word.length; i++) {
          this.b_getter[1].content.push({
            "pk":result.word[i][3],
            "title":result.word[i][2][0],
            "firstTime":result.word[i][1][0],
            "lastTime":result.word[i][1][1],
            "textArea":result.word[i][2][1],
          });
        }
        setInterval(() => {
          this.video_time_check_c = this.video.currentTime;
          this.video_time_check_w = this.video.currentTime;
        }, 100);
    })
  },
  updated:function(){

  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      cp_getter:'capture_getter',
      c_getter:'content_getter',
      b_getter:'bookmark_getter',
      bi_getter:'bookmark_image_getter',
      l_getter: 'login_getters',
    }),
  },
  watch:{
    video_time_check_c: function(data){
      for (let i = 0; i < this.b_getter[0].content.length; i++) {
        if(data.toFixed(1) === this.b_getter[0].content[i].firstTime.toFixed(1)){
          this.check_content = 1+ i;
          this.card_check.content = true;
          this.card_check.content_num++;
          setTimeout(()=>{
            let content_card = document.getElementsByClassName("content_card");
            content_card[i].style.border = "4px solid #EF5350";
            content_card[i].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            setTimeout(()=>{
              content_card[i].style.border = "";
              this.card_check.content = false;
            },1000);
          },100);
        }
      }
    },
    video_time_check_w: function(data){
      for (let i = 0; i < this.b_getter[1].content.length; i++) {
        if(data.toFixed(1) === this.b_getter[1].content[i].firstTime.toFixed(1)){
          this.check_word = 1+ i;
          this.card_check.word = true;
          this.card_check.word_num++;
          setTimeout(()=>{
            let word_card = document.getElementsByClassName("word_card");
            word_card[i].style.border = "4px solid #EF5350";
            word_card[i].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'start' });
            setTimeout(()=>{
              word_card[i].style.border = "";
              this.card_check.word = false;
            },1000);
          },100);
        }
      }
    }
  },
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:650px;
}
.check_card{
  text-align: center;
  color:white;
  font-size:1.2rem;
  background: rgb(245, 33, 33);
  width:100%;
  border-radius: 20%;
}
</style>
