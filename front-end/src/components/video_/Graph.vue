<template>
  <div id="box">
    <v-layout row wrap>
      <v-sheet
        class="d-flex mt-auto"
        color="orange"
        width="60"
      >
        <sheet-footer>
          orange
        </sheet-footer>
      </v-sheet>
      <span>원본그래프</span>
      <v-sheet
        class="d-flex mt-auto"
        color="#42b3f4"
        width="60"
      >
        <sheet-footer>
          #42b3f4
        </sheet-footer>
      </v-sheet>
      <span>내그래프</span>
    </v-layout>
    <div class="graph_box_1" row wrap>
      <v-sparkline
        class="graph"
        id="graph_1"
        :value="origin_value"
        :gradient="gradient[2]"
        :smooth="10"
        :padding="10"
        :line-width="1"
        :stroke-linecap="round"
        :gradient-direction="Top"
        auto-draw
        line-width="2"
      ></v-sparkline>
    </div>
    <div class="graph_box_2" row wrap>
      <v-sparkline
        class="graph"
        id="graph_2"
        :value="record_value"
        :gradient="gradient[1]"
        :smooth="10"
        :padding="10"
        :line-width="1"
        :stroke-linecap="round"
        :gradient-direction="Top"
        auto-draw
        line-width="2"
      ></v-sparkline>
    </div>
  </div>
</template>

<script>
  import {mapActions, mapGetters} from 'vuex';
  const gradients = [
    ['#222'],
    ['#42b3f4'],
    ['orange', 'orange', 'orange'],
    ['purple', 'violet'],
    ['#00c6ff', '#F0F', '#FF0'],
    ['#f72047', '#ffd200', '#1feaea']
  ];
  export default {
    data(){
      return{
        Top:'top',
        round:'round',
        gradient: gradients,
        origin_value:[],
        record_value:[],
      }
    },
    methods:{
      ...mapActions(['graph_origin_action']),
    },
    mounted:function(){
    },
    computed:{
      ...mapGetters({
        g_getter:'graph_orign_getter',
        r_getter:'graph_record_getter',
      }),
    },
    watch:{
      g_getter:function(data){
        // this.g_getter
        this.origin_value = this.g_getter;
        console.log("g_getter",this.g_getter);
      },
      r_getter:function(data){
        this.record_value = this.r_getter;
        console.log("r_getter",this.r_getter);
      }
    }
  }
</script>

<style media="screen">
#box{
  height: 400px;
  margin-bottom: -30%;
  /* border-radius: 10px;
  border:3px solid rgb(9, 164, 251); */
}
.graph_box_1{

  position: relative;
  width:100%;
  z-index:1;

}
.graph_box_2{

  position: relative;
  top:-150px;
  width:100%;
  z-index:2;
}
div:hover .graph{
}
</style>
