<template lang="html">
<v-layout row wrap class="pa-3">
    <v-flex xl12 md12 sm12>
        <v-layout>
            <v-flex xl8 md8 sm8>
                <video_></video_>
                <subtitle_></subtitle_>
                <capture_></capture_>
                <v-card flat>
                    <v-card-title>
                        <v-icon midum left color="teal lighten-1">local_offer</v-icon>
                        <span class="headline font-weight-light-bold">{{explain.title}}</span>
                    </v-card-title>
                    <v-card-title>
                        <v-icon color="teal lighten-1">person</v-icon>
                        <span>123@gmail.com</span>
                    </v-card-title>
                    <v-card-text class="title font-weight">
                        {{explain.content}}
                    </v-card-text>
                </v-card>
                <comment_></comment_>
            </v-flex>

            <v-flex xl4 sm4 md4>
                <content_></content_>
            </v-flex>
        </v-layout>
    </v-flex>
    <v-flex xl12 sm12 sm12>
        <v-layout>

            <v-flex xs4 sm4 md4>
                <v-layout row wrap>
                    <div>
                        <v-flex xs12 sm12 md12 v-for="i in 5">
                        </v-flex>
                    </div>
                </v-layout>
            </v-flex>
        </v-layout>
    </v-flex>
</v-layout>
</template>

<script>
import {
    mapActions
} from 'vuex';
import video_ from '@/components/video_/Video2';
import capture_ from '@/components/video_/Capture';
import subtitle_ from '@/components/video_/Subtitle';
import content_ from '@/components/video_/Contents';
import comment_ from '@/components/video_/Comment';
export default {
    name: "video_see",
    components: {
        video_, // video_pk video url request  = video url
        capture_,
        subtitle_, // video_pk subtitle url request = subtitlel
        content_, // video_pk content url request = content
        comment_,
    },
    data() {
        return {
            explain: {
                title: '',
                content: '',
            }
        }
    },
    methods: {
        ...mapActions(['video_explain_action']),
    },
    mounted: function () {
        this.video_explain_action(this.$route.query.video).then(result => {
            console.log(result);
            this.explain.title = result.title;
            this.explain.content = result.explain;
        });
    }
}
</script>

<style lang="css" scoped>
#scroll_div {
    overflow: scroll;
    height: 800px;
}
</style>
