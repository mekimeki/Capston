<template lang="html">
  <div class="">
    <v-tabs color="white" slider-color="red" >
      <v-tab v-for="content in contents" ripple>
        <v-btn>
          {{ content.name }}
        </v-btn>
      </v-tab>
      <v-tab-item v-for="content in contents">
        <v-card flat>
          <div id="scroll_div">
            <div v-for="(tent, i) in content.content">
              <v-textarea
                outline
                name="input-7-4"
                label="Outline textarea"
                v-model="tent.textArea"
              >
              </v-textarea>
              <v-btn>삭제</v-btn>
              <b-btn>추가</b-btn>
            </div>
          </div>
          <v-textarea
            outline
            name="input-7-4"
            label="Outline textarea"
            v-model="search"
          >
          </v-textarea>
          <v-btn v-on:click="click_search(content.name,search)">
            검색
          </v-btn>
        </v-card>
      </v-tab-item>
    </v-tabs>
    <v-btn>SAVE</v-btn>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  data(){
    return{
      contents:[//book mark
        {name:'content',content:[]},
        {name:'word',content:[]},
      ],
      search:"",
    }
  },
  methods:{
    ...mapActions(['search_action','upload_content_actions']),
    click_search(name,search){
      //axios 요청
      console.log(name);
      console.log(search);
      this.search_action('');
    },
    click_save(){
      this.content_action('');
    }
  },
  mounted:function(){
  }
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:500px;
}
</style>
