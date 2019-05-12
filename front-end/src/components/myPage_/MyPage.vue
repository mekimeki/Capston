<template>
<v-container>
    <v-layout lign-start justify-start row fill-height pa-5 wrap>
        <v-flex class="pl-5 ml-5" xs12 sm12 md3>
            <v-list-tile-avatar size="180">
                <v-img class="elevation-6 ml-5" :src="require(`@/assets/Start/service1.jpg`)"></v-img>
                <v-card-title primary-title>
                    <div class="ml-3">
                        <div class="headline">SOMIN1234</div>
                        <div class="subheading"><span>구독자수 </span><span> 568</span></div>
                        <div></div>
                    </div>
                </v-card-title>
            </v-list-tile-avatar>
        </v-flex>

        <v-flex pt-3 white xs12 sm12 md12>
            <template>
                <v-tabs color="white" icons-and-text>
                    <v-tabs-slider color="red"></v-tabs-slider>
                    <v-tab href="#tab-1">
                        영상
                    </v-tab>
                    <v-tab href="#tab-2">
                        성적
                    </v-tab>
                    <v-tab href="#tab-3">
                        출석
                    </v-tab>
                    <v-tab href="#tab-4">
                        개인정보
                    </v-tab>
                    <v-tab-item v-for="i in 4" :key="i" :value="'tab-' + i">
                        <v-card flat>
                            <v-card-text v-if="i==1">
                                <myVideo_></myVideo_>
                            </v-card-text>
                            <v-card-text v-else-if="i==2">
                                <myQuizScore_></myQuizScore_>
                                <mySpeakScore_></mySpeakScore_>
                            </v-card-text>
                            <v-card-text v-else-if="i==3">
                                <myCalendar_></myCalendar_>
                            </v-card-text>
                            <v-card-text v-else>
                                <myData_></myData_>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </template>

        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import myVideo_ from "@/components/myPage_/MyVideo";
import myQuizScore_ from "@/components/myPage_/MyQuizScore";
import mySpeakScore_ from "@/components/myPage_/MySpeakScore";
import myCalendar_ from "@/components/myPage_/MyCalendar";
import myData_ from "@/components/myPage_/MyData";



export default {
    components: {
        myVideo_,
        myQuizScore_,
        mySpeakScore_,
        myCalendar_,
        myData_,
        
    },
    data() {
        return {
            model: 'tab-2',
            text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
        }
    }
}
</script>
