<template lang="html">
  <div class="">

    <v-tabs color="white" slider-color="black">
      <v-tab v-for="tent in cp_getter" ripple>
          {{ tent.name }}
      </v-tab>
      <v-tab-item v-for="content in cp_getter">
        <v-card v-for="tent in content.content">
          <v-card-title primary-title>
            <div>
              <h3 class="headline mb-0">{{tent.voca}}</h3>
              <div>
                <input type="text" name="" value="" v-model="tent.explain">
              </div>
            </div>
          </v-card-title>
          <v-card-actions>
            <v-btn flat color="orange">
              <v-icon>check</v-icon>등록됨
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-tab-item>
    </v-tabs>

    <v-btn large fab v-on:click="click_save()">SAVE</v-btn>
    <div class="" v-show="up_getters.content">
      <v-btn large fab v-on:click="move()">다음</v-btn>
    </div>
  </div>
</template>

<script>
import {mapActions,mapGetters} from 'vuex';
export default {
  data(){
    return{
      video:'',
    }
  },
  methods:{
    ...mapActions(['search_content_action','search_word_action','upload_content_action']),
    click_save(){
      let data = {
        video:this.$route.query.video,
        content:this.cp_getter[0].content,
        word:this.cp_getter[1].content,
      }
      this.upload_content_action(data);
    },
    move(){
      this.$router.push({name:'message', query:{video:this.$route.query.video}});
    },
  },
  mounted:function(){
    this.video = this.v_getter;
  },
  computed:{
    ...mapGetters({
      v_getter:"video_getter",
      up_getters:"upload_getters",
      cp_getter:"content_preview_getter",
    }),
  },
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:300px;
}
</style>
