<template>
<v-container>
    <v-layout wrap>

        <v-flex sm12 xs12 md12 class="mb-3 ml-3">

            <span>
                <v-btn @click="$refs.calendar.prev(), minusMonth()" fab flat small>
                    <v-icon dark>keyboard_arrow_left</v-icon>
                </v-btn>
            </span>
            <span class="pt-2 title font-weight-regular">{{count}}월</span>
            <span>
                <v-btn @click="$refs.calendar.next(), plusMonth()" fab flat small>
                    <v-icon dark>keyboard_arrow_right</v-icon>
                </v-btn>
            </span>

            <v-sheet height="500">
                <v-calendar ref="calendar" v-model="start" :type="type" :end="end" color="primary"></v-calendar>
            </v-sheet>
        </v-flex>

    </v-layout>
</v-container>
</template>

<script>
export default {
    data() {
        return {
            type: 'month',
            start: '2019-01-01',
            end: '2019-01-06',
            count: '1'
        }
    },
    methods: {
        minusMonth() {
            if (this.count == 1) {
                this.count = 13
            } else if (this.count < 0) {
                this.count = 12
            }
            this.count -= 1

        },
        plusMonth() {
            if (this.count == 1) {
                this.count = 1
            } else if (this.count > 11) {
                this.count = 0
            }
            this.count += 1
        }

    }
}
</script>
