<template lang="html">
<v-layout pl-0 pt-5 justify-start row wrap>
    <v-flex xs12 sm6 md4 v-for="(pic,i) in pics" :key="(pic, i)">
        <v-card flat>
            <span class="pl-4 title font-weight-black" v-if="i == 0">등록한 채널</span>
            <span class="pl-4 title font-weight-black" v-if="i != 0"></span>
            <v-container>
                <v-layout row wrap>
                    <v-flex v-for="n in 9" :key="n" xs4>
                        <v-card flat>
                            <v-card flat height="100px" v-if="n==1" v-bind:color="pic.color" router :to="{name:'click'}">
                                <span class="mainName"><div class="pt-3 pl-3">{{pic.category1}}</div></span>
                                <span class="subName"><div class="pt-2 pl-3">{{pic.category2}}</div ></span>
                            </v-card>
                            <v-img v-if="n!=1" :src="`http://192.168.0.19/movie/`+`${Math.floor(Math.random() * 47)}.jpg`" height="100px"></v-img>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-card>
    </v-flex>

    <v-layout pl-0 pt-5 justify-start row wrap>
        <v-flex xs12 sm6 md4 v-for="(picture,i) in pictures" :key="(picture, i)">
            <v-card flat>
                <span class="pl-4 title font-weight-black" v-if="i == 0"></span>
                <span class="pl-4 title font-weight-black" v-if="i != 0"></span>
                <v-container>
                    <v-layout row wrap>
                        <v-flex v-for="n in 9" :key="n" xs4>
                            <v-card flat>
                                <v-card flat height="100px" v-if="n==1" v-bind:color="picture.color" router :to="{name:'click'}">
                                    <span class="mainName"><div class="pt-3 pl-3">{{picture.category1}}</div></span>
                                    <span class="subName"><div class="pt-2 pl-3">{{picture.category2}}</div ></span>
                                </v-card>
                                <v-img v-if="n!=1" :src="`http://192.168.0.19/movie/`+`${Math.floor(Math.random() * 47)}.jpg`" height="100px"></v-img>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
        </v-flex>
    </v-layout>

</v-layout>
</template>

<script>
export default {
    data: () => ({
        pics: [{
                category1: "영어",
                category2: "비지니스/회화",
                color: "red accent-3",
            },
            {
                category1: "영어",
                category2: "전쟁/SF",
                color: "deep-purple accent-3"
            },
            {
                category1: "영어",
                category2: "여행/관광/서비스",
                color: "blue accent-3"
            },
        ],
        pictures: [{
                category1: "영어",
                category2: "비지니스/회화",
                color: "deep-orange accent-3",
            },
            {
                category1: "영어",
                category2: "전쟁/SF",
                color: "indigo accent-3"
            },
            {
                category1: "영어",
                category2: "여행/관광/서비스",
                color: "teal darken-1"
            },
        ],
    })
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
