<template lang="html">
<v-app style="background-color:#ffffff" id="inspire">
    <v-content>
        <router-view></router-view>
    </v-content>

    <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" fixed app class="py-2 pl-2" :width="250">
        <v-list dense>
            <template v-for="item in items">
                <v-layout v-if="item.heading" :key="item.heading" row align-center>
                    <v-flex xs6>
                        <v-subheader v-if="item.heading">
                            {{ item.heading }}
                        </v-subheader>
                    </v-flex>
                    <v-flex xs6 class="text-xs-center">
                        <a href="#!" class="body-2 black--text">EDIT</a>
                    </v-flex>
                </v-layout>
                <v-list-group v-else-if="item.children" :key="item.text" v-model="item.model" :prepend-icon="item.model ? item.icon : item['icon-alt']" append-icon="">
                    <template v-slot:activator>
                        <v-list-tile>
                            <v-list-tile-content>
                                <v-list-tile-title>
                                    {{ item.text }}
                                </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </template>
                    <v-list-tile v-for="(child, i) in item.children" :key="i" :to="`${ child.link }`" class="py-1">
                        <v-list-tile-action v-if="child.icon">
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content>
                            <v-list-tile-title cass="py-1">
                                {{ child.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>
                <v-list-tile class="py-1" v-else :key="item.text" :to="`${ item.link }`">
                    <v-list-tile-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            {{ item.text }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-navigation-drawer>
    <v-toolbar :clipped-left="$vuetify.breakpoint.lgAndUp" color="white" app fixed>
        <v-toolbar-title class="ml-0 pl-3">
            <v-flex>
                <v-container px-0 pt-1 pb-2 ma-1>
                    <v-layout row>
                        <v-toolbar-side-icon class="pt-1" @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                        <span class="pl-3 pt-3 title font-weight-black">MEKIMEKI.GO語</span>
                        <span class="pl-3 pt-1 mt-3 caption" >영상을 이용한 어학 학습 서비스</span>
                    </v-layout>
                </v-container>
            </v-flex>
        </v-toolbar-title>

        <!-- <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="search"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field> -->
        <v-spacer></v-spacer>
        <v-btn icon>
            <v-icon color="grey darken-2">video_call</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon color="grey darken-2">notifications</v-icon>
        </v-btn>
        <v-btn icon>
            <v-icon color="grey darken-2">account_circle</v-icon>
        </v-btn>
        <v-btn icon large>
            <v-avatar size="40px" tile>
                <img class="logo"
            :src="require(`@/assets/Start/logo.png`)"
          >
        </v-avatar>
        </v-btn>
    </v-toolbar>
</v-app>
</template>

<script>
export default {
  data: () => ({
    drawer: false,
    items: [
      {
        icon: "home",
        text: "홈페이지",
        link: "main"
      },
      {
        icon: "video_library",
        text: "영상 관리",
        link: "video"
      },
      {
        icon: "video_call",
        text: "영상 제작",
        link: "video"
      },
      {
        icon: "favorite",
        text: "좋아하는 영상",
        link: "video"
      },
      {
        icon: "border_color",
        text: "퀴즈",
        link: "qselect"
      },
      {
        icon: "keyboard_arrow_up",
        "icon-alt": "keyboard_arrow_down",
        text: "단어집",
        model: false,
        children: [
          {
            icon: "import_contacts",
            text: "나의 단어집",
            link: "allWord"
          },
          {
            icon: "import_contacts",
            text: "나의 어휘집",
            link: "allWord"
          },
          {
            icon: "import_contacts",
            text: "나의 대사집",
            link: "allWord"
          },
          {
            icon: "import_contacts",
            text: "추천 Go語집",
            link: "allWord"
          }
        ]
      },
      {
        icon: "help",
        text: "도움말",
        link: "qselect"
      },
      {
        icon: "settings",
        text: "설정",
        link: "qselect"
      }
    ]
  })
};
</script>

<style>
.icon {
  font-size: 50px;
}
</style>
