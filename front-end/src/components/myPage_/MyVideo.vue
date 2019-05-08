<template>
<v-container pa-0>
    <v-layout wrap row fill-height>
        <v-flex class="px-3 py-3" v-for="i in 12" :key="i" xs12 sm4 md2 flexbox>
            <v-card color="white" flat>
                <v-img :src="require(`@/assets/Start/service3.jpg`)" aspect-ratio="1.5"></v-img>
                <div>
                    <p class="mb-0" >일본 영화/코미디</p>
                    <span class="mb-0 mr-3">345회</span>
                    <span class="mb-0">좋아요1256</span>
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

        }
    }
}
</script>
