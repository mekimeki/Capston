<template>
  <v-container pa-5>
    <span class="mainName pl-4">등록 채널</span>
    <span class="pl-3 pt-1 mt-3">영어 > 비지니스/회화</span>
    <v-layout wrap row fill-height>
      <v-flex class="px-1 py-4 pt-5" v-for="(name,i) in names" :key="(name,i)" xs12 sm4 md2 flexbox>
        <v-card router :to="{name:'v-video'}" color="white" flat>
          <v-img
            :src="`http://13.209.125.223/movie/`+`${Math.floor(Math.random() * 47)}.jpg`"
            aspect-ratio="1.5"
          ></v-img>
          <div>
            <p class="videoTitle mt-2 mb-1">{{ name.title }}</p>
            <span class="mr-3">345회</span>
            <span>좋아요1256</span>
            <p class="mb-0">2019.05.03</p>
          </div>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      names: [
        { title: "멜로 영화 명장면" },
        { title: "쇼생크 탈출 하기" },
        { title: "전쟁의 처량함" },
        { title: "E.T 다시 보기" },
        { title: "우리들의 행복한 시간" },
        { title: "미드에서만 볼 수 있는 것" },
        { title: "귀신 나오는 명장면" },
        { title: "충격  총격신" },
        { title: "남자 주인공의 고백" },
        { title: "여자들의 파티" },
        { title: "결혼식 명장면" },
        { title: "비지니스 영어 회화" },
        { title: "귀신 나오는 명장면" },
        { title: "충격  총격신" },
        { title: "남자 주인공의 고백" },
        { title: "여자들의 파티" },
        { title: "결혼식 명장면" },
        { title: "비지니스 영어 회화" },
        { title: "E.T 다시 보기" },
        { title: "우리들의 행복한 시간" },
        { title: "미드에서만 볼 수 있는 것" },
        { title: "귀신 나오는 명장면" },
        { title: "충격  총격신" }
      ]
    };
  }
};
</script>

<style>
.videoTitle {
  color: black;
  font-size: 1.3rem;
  font-weight: 550;
}
.mainName {
  color: black;
  font-size: 1.8rem;
  font-weight: 550;
}
</style>

