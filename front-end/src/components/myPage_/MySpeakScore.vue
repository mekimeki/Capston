<template>
<v-container>
    <v-layout pt-5>
        <v-flex xs12>
            <h2>나의 100LS 결과</h2>
            <!-- <h3>Line Chart</h3> -->
            <line-chart :width="20" :height="6"></line-chart>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import LineChart from '@/components/myPage_/SpeakChart.vue'

export default {
    name: 'VueChartJS',
    components: {
        LineChart,

    }
}
</script>

<style scoped>

</style>
