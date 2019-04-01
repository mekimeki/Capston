<template lang="html">

  <v-layout>
    <v-container>
      <v-layout justify-start>
        <v-btn
          color="pink"
          dark
          @click.stop="drawer = !drawer"
        >
          Menu
        </v-btn>
      </v-layout>
    </v-container>

    <v-navigation-drawer
      v-model="drawer"
      absolute
      temporary
    >
      <v-list class="pa-1">
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <img src="">
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>사용자</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>

      <v-list class="pt-0" dense>
        <v-divider></v-divider>

        <v-list-tile
          v-for="item in items"
          :key="item.title"
          @click=""
        >
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>

          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-flex xs12 sm6 md12 pa-5>
      <v-text-field
        label="Search"
      ></v-text-field>
    </v-flex>
  </v-layout>
</template>

<script>
export default {
  data() {
    return {
      drawer : null,
      items: [
        { title: '마이페이지', icon: 'face' },
        { title: '영상 관리', icon: 'video_library' },
        { title: '영상 제작', icon: 'video_call' },
        { title: '퀴즈', icon: 'border_color' },
        { title: '좋아하는 영상', icon: 'favorite' },
        { title: 'Go語집', icon: 'import_contacts' },
        { title: '성적 관리', icon: 'insert_chart' }
      ]
    }
  }
}
</script>

<style lang="css" scoped>
</style>
