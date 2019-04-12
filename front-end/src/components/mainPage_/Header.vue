<template lang="html">
  <v-layout pt-5>

    <v-navigation-drawer
      v-model="drawer"
      fixed
      clipped
      app
      :width="200"
    >
      <v-list dense >
        <v-list-tile v-for=" (item,n) in items" :key="item.text" :to="`${ item.link }`" >
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>
              {{ item.text }}
            </v-list-tile-title>

          </v-list-tile-content>
        </v-list-tile>

        <v-layout
        white
        fixed
        :height="10"
        >
      <v-card
        flat
        tile
        class="black--text text-xs-center"
      >
        <v-divider></v-divider>
        <v-card-text>メキメキ組</v-card-text>
        <v-card-text>
          이수재,
          김소민,
          김승연,
          조혜경,
          최찬민
        </v-card-text>
        <v-divider></v-divider>
        <v-card-text class="black--text">
          2019年Capston Project<strong>Go語</strong>
        </v-card-text>
      </v-card>
    </v-layout>

      </v-list>
    </v-navigation-drawer>

    <v-toolbar
      color="white"
      dense
      fixed
      clipped-left
      app
    >
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-toolbar-title class="mr-5 align-center">
        <span class="title">GO語</span>
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-layout row align-center style="max-width: 650px">
        <v-text-field
          :append-icon-cb="() => {}"
          placeholder="검색"
          sigle-line
          append-icon="search"
          color="gray"
          hide-details

        ></v-text-field>
          <v-layout justify-center > 
            <v-spacer></v-spacer>
            <v-icon color="gray darken-2">video_call</v-icon>
            <v-spacer></v-spacer>
            <v-icon color="gray darken-2">notifications</v-icon>
            <router-link to="/log/login">
              <v-icon color="gray darken-2">account_circle</v-icon>
            </router-link>
          </v-layout>
      </v-layout>
    </v-toolbar>


  </v-layout>
</template>

<script>
  export default {
    data: () => ({
      drawer: null,
      items: [
        { text: '홈페이지', icon: 'home' , link:'/' },
        { text: '영상 관리', icon: 'video_library', link:'video' },
        { text: '영상 제작', icon: 'video_call', link:'video' },
        { text: '퀴즈', icon: 'border_color', link:'qselect' },
        { text: '좋아하는 영상', icon: 'favorite', link:'video' },
        { text: 'Go語집', icon: 'import_contacts'},
        { text: '성적 관리', icon: 'insert_chart', link:'video' }
      ],
    }),
    props: {
      source: String
    },
  }
</script>
