<template lang="html">
<v-layout row>
    <v-flex xs12 sm12 md12>
        <div>
            <v-list two-line>
                <template v-for="(item, index) in items">
                    <v-subheader v-if="item.header" :key="item.header">
                        <v-icon color="teal lighten-1">chat</v-icon>
                        {{ item.header }}
                    </v-subheader>

                    <v-divider v-else-if="item.divider" :key="index" :inset="item.inset"></v-divider>

                    <v-list-tile v-else :key="item.title" avatar @click="">
                        <v-list-tile-avatar>
                            <img :src="item.avatar">
            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title v-html="item.title"></v-list-tile-title>
                                <v-list-tile-sub-title v-html="item.subtitle"></v-list-tile-sub-title>
                            </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </div>
    </v-flex>
</v-layout>
</template>

<script>
export default {
    data() {
        return {
            items: [{
                    header: '댓글'
                },
                {
                    avatar: 'https://image.fmkorea.com/files/attach/new/20180910/3655109/981948811/1260633089/38e9f5a6ede7952d202d95ed4522df68.jpg',
                    title: '김소민',
                    subtitle: "감동적이에요?"
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
                    title: '김승연',
                    subtitle: "재미있네요 ^^"
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'http://res.heraldm.com/phpwas/restmb_jhidxmake.php?idx=5&simg=201903201622487407634_20190320162617_01.jpg',
                    title: '오늘의퀴이이이이이즈!',
                    subtitle: "오늘 처음 와 봤는데 재미있네요."
                },
                {
                    avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
                    title: '김승연',
                    subtitle: "4등이다."
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
                    title: '김승연',
                    subtitle: "유니스 누나는 왜 이쁠까."
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
                    title: '김승연',
                    subtitle: "이 시간으로 이동 . "
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'http://res.heraldm.com/phpwas/restmb_jhidxmake.php?idx=5&simg=201903281504096221490_20190328150454_01.jpg',
                    title: '이수재',
                    subtitle: "애들이 말을 안들어요."
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    avatar: 'https://image.fmkorea.com/files/attach/new/20190125/3655109/981948811/1548830905/d81cabc2813bf8962010b9661eae8931.jpg',
                    title: '최찬민',
                    subtitle: "재미 없네요."
                },
                {
                    divider: true,
                    inset: true
                },
                {
                    divider: true,
                    inset: true
                },
            ]
        }
    }
}
</script>

<style lang="css" scoped>

</style>
