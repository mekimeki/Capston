<template>
<div id="box">
    <v-layout row wrap>
        <v-sheet color="orange" width="65">
            <sheet-footer>
                <br />
        </sheet-footer>
        </v-sheet>
        <div class="pt-1 pl-1 pr-4" style="font-size:1.3rem; font-weight:600;">원본 그래프</div>
        <v-sheet color="#42b3f4" width="60">
            <sheet-footer>
                <br />
        </sheet-footer>
        </v-sheet>
        <div class="pt-1 pl-1" style="font-size:1.3rem; font-weight:600;">나의 그래프</div>
        <span class="ml-5 pl-5" style="color:red; font-size:1.5rem; font-weight:600;" v-if="score!=0">
        {{score}}점
      </span>
    </v-layout>

    <div class="graph_box_1" row wrap>
        <v-sparkline class="graph" id="graph_1" :value="origin_value" :gradient="gradient[2]" :smooth="10" :padding="10" :line-width="1" :stroke-linecap="round" :gradient-direction="Top" auto-draw line-width="2"></v-sparkline>
    </div>
    <div class="graph_box_2" row wrap>
        <v-sparkline class="graph" id="graph_2" :value="record_value" :gradient="gradient[1]" :smooth="10" :padding="10" :line-width="1" :stroke-linecap="round" :gradient-direction="Top" auto-draw line-width="2"></v-sparkline>
    </div>
</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
const gradients = [
    ['#222'],
    ['#42b3f4'],
    ['orange', 'orange', 'orange'],
    ['purple', 'violet'],
    ['#00c6ff', '#F0F', '#FF0'],
    ['#f72047', '#ffd200', '#1feaea']
];
export default {
    data() {
        return {
            Top: 'top',
            round: 'round',
            gradient: gradients,
            origin_value: [],
            record_value: [],
            score: 0,
        }
    },
    methods: {
        ...mapActions(['graph_origin_action']),
    },
    mounted: function () {},
    computed: {
        ...mapGetters({
            g_getter: 'graph_orign_getter',
            r_getter: 'graph_record_getter',
            s_getter: 'graph_score_getter',
        }),
    },
    watch: {
        g_getter: function (data) {
            // this.g_getter
            this.origin_value = this.g_getter;
            console.log("g_getter", this.g_getter);
        },
        r_getter: function (data) {
            if (!this.r_getter) {
                alert('다시 녹음해 주세요');
            } else {
                this.record_value = this.r_getter;
                this.score = this.s_getter;
                console.log("r_getter", this.r_getter);
            }
        }
    }
}
</script>

<style>
#box {
    height: 400px;
    margin-bottom: -30%;
    /* border-radius: 10px;
  border:3px solid rgb(9, 164, 251); */
}

.graph_box_1 {

    position: relative;
    width: 100%;
    z-index: 1;

}

.graph_box_2 {

    position: relative;
    top: -150px;
    width: 100%;
    z-index: 2;
}

div:hover .graph {}
</style>
