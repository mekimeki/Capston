<template lang="html">
  <v-layout row>
   <v-flex xs12 sm12 md12 >
     <div>
       <v-list two-line>
         <template v-for="(item, index) in items">
           <v-subheader
             v-if="item.header"
             :key="item.header"
           >
           <v-icon color="teal lighten-1">chat</v-icon>
             {{ item.header }}
           </v-subheader>

           <v-divider
             v-else-if="item.divider"
             :key="index"
             :inset="item.inset"
           ></v-divider>

           <v-list-tile
             v-else
             :key="item.title"
             avatar
             @click=""
           >
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
   data () {
     return {
       items: [
         { header: 'COMMENT' },
         {
           avatar: 'https://image.fmkorea.com/files/attach/new/20180910/3655109/981948811/1260633089/38e9f5a6ede7952d202d95ed4522df68.jpg',
           title: 'Brunch this weekend?',
           subtitle: "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
         },
         { divider: true, inset: true },
         {
           avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
           title: 'Brunch this weekend?7',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'http://res.heraldm.com/phpwas/restmb_jhidxmake.php?idx=5&simg=201903201622487407634_20190320162617_01.jpg',
           title: 'Oui oui8',
           subtitle: "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
         },
         {
           avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
           title: 'Summer BBQ7 <span class="grey--text text--lighten-1">4</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
           title: 'Summer BBQ6 <span class="grey--text text--lighten-1">4</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'http://cgeimage.commutil.kr/phpwas/restmb_allidxmake.php?idx=3&simg=2018051223324807406482b2d7606183101228234.jpg',
           title: 'Summer BBQ3 <span class="grey--text text--lighten-1">4</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'http://res.heraldm.com/phpwas/restmb_jhidxmake.php?idx=5&simg=201903281504096221490_20190328150454_01.jpg',
           title: 'Summer BBQ2 <span class="grey--text text--lighten-1">4</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'https://image.fmkorea.com/files/attach/new/20190125/3655109/981948811/1548830905/d81cabc2813bf8962010b9661eae8931.jpg',
           title: 'Summer BBQ4 <span class="grey--text text--lighten-1">4</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
         {
           avatar: 'https://image.fmkorea.com/files/attach/new/20181007/3655109/981948811/1310171823/5203a7f3d025dd493959c9594f319548.jpg',
           title: 'Summer BBQ1 <span class="grey--text text--lighten-1">5</span>',
           subtitle: "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
         },
         { divider: true, inset: true },
       ]
     }
   }
 }
</script>

<style lang="css" scoped>

</style>
