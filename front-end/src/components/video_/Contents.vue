<template lang="html">
  <div class="">
    <v-tabs color="white" slider-color="red" >
      <v-tab v-for="mark in bookmark" ripple>
        {{ mark.name }}
      </v-tab>
      <v-tab-item v-for="mark in bookmark">
        <v-card flat>

          <div id="scroll_div">
            <div v-for="(tent, i) in mark.content">
              <v-textarea
                outline
                name="input-7-4"
                label="Outline textarea"
                v-model="tent.textArea"
                v-on:keyup="keyup_share()"
              >
              </v-textarea>
              <v-btn color="success" v-on:click="click_share(tent.textArea,$event)">
                참여
              </v-btn>
            </div>
          </div>
          <div class="" v-if="mark.name === 'content'">
            <v-textarea
              outline
              name="input-7-4"
              label="Outline textarea"
              v-model="share_content"
            >
            </v-textarea>
            <v-btn color="success" v-on:click="click_share(share_content,$event)">
              참여
            </v-btn>
          </div>
        </v-card>
      </v-tab-item>
    </v-tabs>
  </div>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters} from 'vuex';
export default {
  data(){
    return{
      video:"",//video
      video_time_check:"",//video time checks
      bookmark:[//book mark
        {name:'content',color:'info',mark:'bookmark_border', link:'content' ,content:[]},
        {name:'word',color:'blue-grey',mark:'bookmark', link:'word',content:[]},
        {name:'wordBook',color:'blue-grey',mark:'bookmark', link:'word',content:[]},
        {name:'subtitleBook',color:'info',mark:'bookmark_border', link:'subtitle',content:[]},
      ],
      share_content:"참여하세용",
      text:"fdasfsadfsdafsa",
      active:'fsdaf',
    }
  },
  methods:{
    ...mapActions(['content_answer_action','content_action']),
    keyup_share(){
      console.log("share methods");
    },
    click_share(share,evt){
      if(confirm("정말로 참여 하시겠습니까?")){
        //axios 를 통해서 디비에 저장.
        //content에 추가 저장
      }else{
        console.log("취소");
      }
    },
  },
  mounted:function(){
    this.video = this.v_getter;//video element getter
    this.content_answer_action("").then(result=>{//content get
      this.content_action(result);
      setInterval(() => {
        this.video_time_check = this.video.currentTime;
      }, 100);
    });
    setInterval(()=>{

    });
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      cp_getter:'capture_getter',
      c_getter:'content_getter',
    }),
  },
  watch:{
    video_time_check: function(data){
      for (var i = 0; i < this.c_getter.length; i++) {
        if(data.toFixed(1) === parseInt(this.c_getter[i][1][0]).toFixed(1)){
          this.bookmark[0].content.push({
            "firstTime":this.c_getter[i][1][0],
            "lastTime":this.c_getter[i][1][1],
            "textArea":this.c_getter[i][2],
          });
        }
      }
    }
  },
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:300px;
}
</style>
