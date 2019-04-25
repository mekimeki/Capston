<template lang="html">
  <v-container fluid fill-height>
    <v-layout pl-2 pt-3 justify-start row wrap>

      <v-flex xs12 sm6 md4 v-for="(pic,i) in pics" :key="(pic, i)" >
        <v-card flat>
          <span class="pl-4 title font-weight-black" v-if="i == 0">추천영상</span>
          <span class="pl-4 title font-weight-black" v-if="i != 0"></span>
          <v-container>
            <v-layout row wrap>
              <v-flex
                v-for="n in 9"
                :key="n"
                xs4
              >
                <v-card flat>
                  <v-card flat height="100px" v-if="n==1" v-bind:color="pic.color" >
                    <span class="mainName"><div class="pt-3 pl-3">{{pic.category1}}</div></span>
                    <span class="subName"><div class="pt-2 pl-3">{{pic.category2}}</div ></span>
                  </v-card>
                  <v-img
                    v-if="n!=1"
                    :src="`https://unsplash.it/150/300?image=${Math.floor(Math.random() * 100) + 1}`"
                    height="100px"
                  ></v-img>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>  
      </v-flex>
      <!-- called register page -->
        <router-view></router-view>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data : () => ({
    pics : [
      { category1 : '일본어', category2:'비지니스/회화', color:'red accent-3' },
      { category1 : '일본어', category2:'의학/건강관련', color:'green accent-3' },
      { category1 : '일본어', category2:'여행/관광/서비스', color:'light-blue accent-3' },
      
    ]
  })
  
}
</script>

<style lang="css" scoped>
.mainName {
  color : white;
  font-size : 1.6rem;
  font-weight : 600 ;
}
.subName {
  color : white;
  font-size : 1rem;
}
</style>