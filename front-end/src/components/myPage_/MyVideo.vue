<template>
<v-container pa-0>
    <v-layout wrap row fill-height>
        <v-flex class="px-1 py-4 pt-5" v-for="(name,i) in names" :key="(name,i)" xs12 sm4 md2 flexbox>
            <v-card color="white" flat router :to="{name:'v-video',query:{video:name.video_pk}}">
                <v-img :src="name.pic_add" aspect-ratio="1.5"></v-img>
                <div>
                    <p class="videoTitle mt-2 mb-1">{{ name.v_tt }}</p>
                    <span class="mr-3">10회</span>
                    <span>좋아요10</span>
                    <p class="mb-0">{{ name.upload_dt }}</p>
                </div>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {
            names : [],
        }
    },
    mounted() {
        var baseURI = "http://172.26.3.30/api/myVideo";
        var form = new FormData();
        form.append("id","123@gmail.com");
        axios
            .post(baseURI, form)
            .then(res => {
                this.names = res.data.video.video;
                console.log("beforeCreate OK",this.names);
            })
            .catch(error => {
                console.log("failed", error);
            });
    
}
}
</script>
<style>
.videoTitle {
    color: black;
    font-size: 1.3rem;
    font-weight: 550;
}
</style>
