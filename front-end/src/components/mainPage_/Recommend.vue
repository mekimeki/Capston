<template lang="html">
<v-container fluid fill-height>
    <v-layout pl-2 pt-4 justify-start row wrap>

        <v-flex xs12 sm6 md4 v-for="(pic,i) in pics" :key="(pic, i)">
            <v-card flat>
                <span class="pl-4 title font-weight-black" v-if="i == 0">추천영상</span>
                <span class="pl-4 title font-weight-black" v-if="i != 0"></span>
                <v-container>
                    <v-layout row wrap>
                        <v-flex v-for="n in 9" :key="n" xs4>
                            <v-card flat>
                                <v-card flat height="100px" v-if="n==1" v-bind:color="pic.color" router :to="{name:'click'}">
                                    <span class="mainName"><div class="pt-3 pl-3">{{pic.category1}}</div></span>
                                    <span class="subName"><div class="pt-2 pl-3">{{pic.category2}}</div ></span>
                                </v-card>
                                <v-img v-if="n!=1" :src="`http://172.26.3.30/movie/`+`${Math.floor(Math.random() * 47)}.jpg`" height="100px"></v-img>
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
import {
    mapActions
} from 'vuex';
export default {

    data() {
        return {
            pics: [{
                    category1: "영어",
                    category2: "액션/스릴러",
                    color: "red accent-3",
                },
                {
                    category1: "영어",
                    category2: "전쟁/SF",
                    color: "deep-purple accent-3"
                },
                {
                    category1: "영어",
                    category2: "로맨스",
                    color: "blue accent-3"
                }
            ],
        }
    },

    methods: {
        ...mapActions(['recommend_action']),
    },
    mounted: function () {
        window.scrollTo(0, 0);
        console.log("recommend");
        this.recommend_action().then(result => {
            console.log('picture data and recommend', result);
        });

    },

};
</script>

<style lang="css" scoped>
.mainName {
    color: white;
    font-size: 1.6rem;
    font-weight: 600;
}

.subName {
    color: white;
    font-size: 1rem;
}
</style>
