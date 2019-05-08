<template lang="html">
  <div>
    <v-tabs color="white" slider-color="black" class="ma-2">
        <v-tab v-for="mark in b_getter" :key="mark.name" ripple>
          <v-btn color="orange" fab small>
            {{ mark.name }}
          </v-btn>
        </v-tab>
        <v-tab-item v-for="(mark, i) in b_getter" :key="i">
          <div id="scroll_div">
            <div class="" v-if="mark.option === 'share'">

              <v-card v-for="(tent, i) in mark.content" :key="i" v-if="i< content_check" class="ma-1">
                <!-- v-if="i< content_check" 때문에 카드 추가 할때 안됨 -->
                <v-card-title primary-title>
                  <div>
                    <h4 class="headline mb-0" v-if="!(mark.name === 'subtitleBook')">{{tent.title}}</h4>
                    <img :src="bi_getter[i]" alt="" v-if="mark.name === 'subtitleBook'" width="200" height="100" crossOrigin = "Anonymous">
                    <div>
                      <input type="text" name="" value="" v-model="tent.textArea">
                    </div>
                  </div>
                </v-card-title>
                <v-card-actions>
                  <v-btn flat small color="orange" v-on:click="click_share(tent.textArea,tent.textArea)">
                    <v-icon>check</v-icon>share
                  </v-btn>
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
                    <v-btn flat small color="blue" v-on:click="click_bookmark(i,tent)">
                      <v-icon>check</v-icon>bookmark
                    </v-btn>
                </v-card-actions>
              </v-card>

            </div>

          </div>
          <!-- <v-card class="ma-2" v-show="mark.name === 'content'||mark.name === 'word'">
            <v-card-title primary-title>
              <v-text-field
                height="20"
                label="TITLE"
                v-model="share.title"
              ></v-text-field>
              <v-text-field
                height="20"
                label="TEXT"
                v-model="share.content"
              ></v-text-field>
            </v-card-title>
            <v-card-actions>
              <v-btn right flat small color="orange" v-on:click="click_share(share.title,share.content)">
                <v-icon>check</v-icon>참여
              </v-btn>
            </v-card-actions>
          </v-card> -->
        </v-tab-item>


    </v-tabs>

  </div>
</template>

<script>
import { mapActions, mapGetters} from 'vuex';
export default {
  data(){
    return{
      video:"",//video
      video_time_check:'',//video time checks
      content_check:0,//content check
      word_check:0,
      share:{
        title:"TITLE",
        content:"CONTENT",
      },
    }
  },
  methods:{
    ...mapActions(['content_answer_action','content_action','share_action','content_view_action','bookmark_save_action']),
    click_share(title,content){

      if(confirm("Are you sure?")){
        // this.share_action('').then(result=>{
        //   console.log("log",result);
        // });
      }
    },
    click_bookmark(num,value){
      let data = {
        'video_pk':this.$route.query.video,
        'title': value.title,
        'explain': value.textArea,
        'picture': this.bi_getter[num],
      }
      this.bookmark_save_action(data).then(result=>{
        console.log("bookmark check",result);
      });
    },
    check_view(data,view,check){
      for (let i = 0; i < view.content.length; i++) {
        if(data.toFixed(1) === view.content[i].firstTime.toFixed(1)){
          check = 1+ i;
          document.getElementById('scroll_div').scrollTop = document.getElementById('scroll_div').scrollHeight;
        }
      }
    },
  },
  mounted:function(){
    this.video = this.v_getter;//video element getter
    // this.content_answer_action("").then(result=>{//content get
    //   this.content_action(result);
    //   for (let i = 0; i < this.c_getter.length; i++) {
    //     this.b_getter[0].content.push({
    //       "firstTime":this.c_getter[i][1][0],
    //       "lastTime":this.c_getter[i][1][1],
    //       "textArea":this.c_getter[i][2],
    //     });
    //   }
    //   for (let i = 0; i < this.c_getter.length; i++) {
    //     this.b_getter[1].content.push({
    //       "firstTime":this.c_getter[i][1][0],
    //       "lastTime":this.c_getter[i][1][1],
    //       "textArea":this.c_getter[i][2],
    //     });
    //   }
    //   setInterval(() => {
    //     this.video_time_check = this.video.currentTime;
    //   }, 100);
    // });


    this.content_view_action(this.$route.query.video).then(result=>{
      console.log(result);
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
          this.video_time_check = this.video.currentTime;
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
    }),
  },
  watch:{
    video_time_check: function(data){
      this.check_view(data,this.b_getter[0],this.content_check);
      this.check_view(data,this.b_getter[1],this.word_check); // check_time 동시에 증가 되는 문제 해결 해야함
    }
  },
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:500px;
}
</style>
