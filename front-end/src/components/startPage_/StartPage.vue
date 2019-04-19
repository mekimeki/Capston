<template>
<v-container fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout wrap row>

    <v-flex xs12 sm12 class="pb-2" v-for="i in 1" :key="i">
        <v-card height="130px" color="cyan lighten-3">
        각종 현황
        </v-card>
    </v-flex>

    <v-flex xs12 sm12 class="pb-2" v-for="i in 1" :key="i">
    <v-card color="amber lighten-3">
        <v-img class="start" :src="require(`@/assets/Start/start.jpg`)" aspect-ratio="4.0">
        </v-img>
    </v-card>
    </v-flex>

    <v-flex xs12 sm6 md3 class="pb-2" v-for="i in 4" :key="i">
        <v-card height="130px" color="cyan lighten-3">
        각종 현황
        </v-card>
    </v-flex>

    <v-flex xs12 sm4 class="pb-2" v-for="i in 3" :key="i">
        <v-card height="140px" color="deep-orange lighten-3">
        간단한 차트
        </v-card>
    </v-flex>
    
    </v-layout>
</v-container>
</template>

<script>
export default {

}
</script>

<style lang="css" scoped>
</style>
