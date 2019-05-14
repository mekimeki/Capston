<template>
<v-container fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout wrap row>
        <v-flex xs12 sm12>
            <v-img :src="require(`@/assets/Start/start.jpg`)" aspect-ratio="3.0"></v-img>
        </v-flex>

        <v-flex xs12 sm12 class="py-4">
            <v-card height="250px" flat>
                <h1 class="pt-5 text-xs-center">{{imformation1}}</h1>
                <h3 class="pt-4 text-xs-center">{{imformation2}}</h3>
                <h3 class="text-xs-center">{{imformation3}}</h3>
                <h3 class="text-xs-center">{{imformation4}}</h3>
            </v-card>
        </v-flex>

        <!--explanaiton of service -->
        <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/service1.jpg`)" aspect-ratio="1.5" @mouseover="hover1=true" @mouseleave="hover1=false" :class="{ active: hover1}">
                <span v-if="hover1">
            <h1 class="pa-2 text-xs-right white--text">사용자 참여형</h1>
            <h1 class="pr-2 text-xs-right white--text">어학 컨텐츠</h1>
            </span>
            </v-img>
        </v-flex>
        <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/service2.jpg`)" aspect-ratio="1.5" @mouseover="hover2=true" @mouseleave="hover2=false" :class="{ active: hover2}">
                <span v-if="hover2">
            <h1 class="pa-2 text-xs-right white--text">즉각적인</h1>
            <h1 class="pr-2 text-xs-right white--text">100LS 가능</h1>
            </span>
            </v-img>
        </v-flex>
        <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/service3.jpg`)" aspect-ratio="1.5" @mouseover="hover3=true" @mouseleave="hover3=false" :class="{ active: hover3}">
                <span v-if="hover3">
            <h1 class="pa-2 text-xs-right white--text">사진으로</h1>
            <h1 class="pr-2 text-xs-right white--text">연상 가능한 어학집</h1>
            </span>
            </v-img>
        </v-flex>
        <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/service4.jpg`)" aspect-ratio="1.5" @mouseover="hover4=true" @mouseleave="hover4=false" :class="{ active: hover4}">
                <span v-if="hover4">
            <h1 class="pa-2 text-xs-right white--text">어학을 위한</h1>
            <h1 class="pr-2 text-xs-right white--text">간편한 영상 편집</h1>
            </span>
            </v-img>
        </v-flex>

        <!--concrete explanation of sevice-->
        <v-flex xs12 sm6 md3 class="pb-4" v-for="explain in explains" :key="explain">
            <v-card flat color="white">
                <v-container fill-height fluid>
                    <v-layout py-3 fill-height>
                        <v-flex xs12 align-center flexbox>
                            <v-layout justify-center>
                                <v-icon color="grey darken-3" x-large>{{explain.icon}}</v-icon>
                            </v-layout>
                            <div class="pa-2 subheading font-weight-black text-xs-center">{{explain.text}}</div>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </v-flex>

        <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/post1.png`)"></v-img>
        </v-flex>
         <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/post2.png`)"></v-img>
        </v-flex>
         <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/post3.png`)"></v-img>
        </v-flex>
         <v-flex xs12 sm6 md3 class="pb-4">
            <v-img :src="require(`@/assets/Start/post4.png`)"></v-img>
        </v-flex>
        

        <v-flex xs12 sm12 class="py-4">
            <v-card flat color="white">
                <v-layout v-for="item in items" :key="item" justify-center>
                    <v-btn flat large :to="`${ item.link }`">
                        <h1>GO語로 이동하기</h1>
                    </v-btn>
                </v-layout>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
export default {
    data: () => ({
        drawer: null,
        hover1: false,
        hover2: false,
        hover3: false,
        hover4: false,
        showComment: false,
        comment: "",
        imformation1: "영상을 이용한 다양한 학습",
        imformation2: "사용자와 함께 참여 할 수 있는 참여형 학습으로 자신이 원하는 영상 무엇이든 편집 가능합니다.",
        imformation3: "100LS를 이용한 말하기와 듣기 연습, 연상퀴즈를 이용한 암기로 학습의 효과를 향샹 시켜줍니다.",
        imformation4: "또한, 자신이 원하는 언어에 맞는 적합한 동영상을 추천해주며, 공동 어휘집을 이용해 수많은 단어를 주고받으면서 공부할 수 있습니다.",

        items: [{
            link: "main"
        }],

        explains: [{
                text: "수많은 유저가 함께 참여할 수 있는 학습",
                icon: "group_add"
            },
            {
                text: "반복 학습으로 말하기/듣기 실력 향상",
                icon: "headset_mic"
            },
            {
                text: "연상 학습법을 이용한 공부법",
                icon: "collections"
            },
            {
                text: "자신이 가지고 있는 모든 동영상을 편집 후 학습 활용",
                icon: "switch_video"
            }
        ],
    }),
    methods: {
        changeComment(a) {
            this.showComment = true;
            this.comment = a;
        }
    }
};
</script>

<style lang="css" scoped>
.active {
    filter: opacity(80);
    -webkit-filter: opacity(0.8);
    height: 100%;
}

.logo {
    max-height: 50px;
    max-width: 50px;
}
</style>
