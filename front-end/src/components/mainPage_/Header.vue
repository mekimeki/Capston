<template lang="html">
  <v-layout>
    <v-navigation-drawer
      app
      v-model="drawer">
      <v-list>
        <!-- menu title -->
        <v-list-tile>
          GO語
        </v-list-tile>
        <!-- line -->
        <v-divider></v-divider>
        <!-- list -s -->
        <v-list-tile v-for=" (item,n) in items" :key="item.text">
          <!-- list -s icon -->
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <!-- list -s title -->
          <v-list-tile-content>
            <v-list-tile-title>
              {{ item.title }}
            </v-list-tile-title>

          </v-list-tile-content>
        </v-list-tile>
        <v-divider class="pa-5"></v-divider>
        <v-list-tile>
          メキメキ組
        </v-list-tile>
        <v-divider></v-divider>
        <v-list-tile>
          이수재,김소민,김승연,조혜경,최찬민
        </v-list-tile>
        <v-list-tile>
          2019年Capston ProjectGo語
        </v-list-tile>
        <v-divider></v-divider>
        <v-btn>
          <v-icon v-on:click="drawer = !drawer">close</v-icon>
        </v-btn>
      </v-list>
    </v-navigation-drawer>



    <!-- nav  -->
    <v-toolbar
      color=""
      img="@/assets/Start/start.jpg"
    >
      <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
      <v-toolbar-title>
        <img src="@/assets/gogo.png" alt="" width="40">
      </v-toolbar-title>
      <v-spacer></v-spacer>
      <v-toolbar-items>
        <v-btn fab flat color="black">
          <v-icon color="gray darken-2" class="pa-3" @click.stop="dialog = true">search</v-icon>
        </v-btn>
        <v-toolbar-items v-if="lg_getter.email&&lg_getter.nickname">
          <v-btn fab flat color="black">
            <v-icon color="gray darken-2" class="pa-3">video_call</v-icon>
          </v-btn>
          <v-btn fab flat color="black">
            <v-icon color="gray darken-2" class="pa-3">notifications</v-icon>
          </v-btn>
          <v-menu transition="slide-x-reverse-transition">
             <template v-slot:activator="{ on }">
               <v-btn fab flat color="black" v-on="on">
                 <v-icon color="gray darken-2" class="pa-3">account_circle</v-icon>
               </v-btn>
             </template>
             <v-list>
              <v-list-tile v-for="item in loginItem" :key="n" @click="">
                <v-list-tile-title v-text="item.title" v-on:click="logout_actions()"></v-list-tile-title>
              </v-list-tile>
             </v-list>
           </v-menu>
        </v-toolbar-items>
        <v-toolbar-items v-else>
          <v-btn fab flat color="black" router :to="{ path:'log/login'}">
            <v-icon color="gray darken-2" class="pa-3">account_circle</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar-items>
    </v-toolbar>
    <!-- modal -->
    <v-dialog v-model="dialog"max-width="600">
      <v-card>
        <v-flex xs12 sm12 md12 class="pa-4">
          <v-text-field
            label="Search"
          ></v-text-field>
        </v-flex>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            flat="flat"
            @click="dialog = false"
          >
           <v-icon>close</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-layout>
</template>

<script>
  import { mapActions,mapGetters } from 'vuex';//vuex actions import
  export default {
    data () {
      return {
        items: [//menu list
          { title: '마이페이지', icon: 'face' , link:'video',},
          { title: '영상 관리', icon: 'video_library', link:'video'},
          { title: '영상 제작', icon: 'video_call', link:'upload'},
          { title: '퀴즈', icon: 'border_color', link:'video'},
          { title: '좋아하는 영상', icon: 'favorite', link:'video'},
          { title: 'Go語집', icon: 'import_contacts', link:'video'},
          { title: '성적 관리', icon: 'insert_chart', link:'video'}
        ],
        drawer:"",//navigation slider button value
        dialog:"",//Search modal
        loginItem: [
          {title:'logout', link:''},
          {title:'nickname'},
        ]
      }
    },
    methods:{
      ...mapActions(['logout_actions']),
    },
    computed:{
      ...mapGetters({
        lg_getter:'login_getters',
      }),

    }
  }
</script>
