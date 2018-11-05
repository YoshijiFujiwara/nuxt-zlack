<template>
  <v-app>
    <v-navigation-drawer
      :mini-variant="miniVariant"
      :clipped="clipped"
      v-model="drawer"
      fixed
      app
      dark
      class="brown darken-1"
    >
      <v-list>
        <!-- ワークスペース名 -->
        <v-list-tile>
          <v-list-tile-action>
            <v-icon>group_work</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="workspace.name" />
          </v-list-tile-content>
        </v-list-tile>

        <!-- チャンネルリスト -->
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>チャンネル</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-icon>add</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <div class="pl-2">
          <v-list-tile v-for="(channel, index) in workspace.channels" :key="index">
              <v-list-tile-content :class="channelListClass(channel.id)" @click="moveToChannel(channel.id)">
                <v-list-tile-sub-title># {{channel.name}}</v-list-tile-sub-title>
              </v-list-tile-content>
          </v-list-tile>
        </div>

        <!-- ダイレクトメッセージ -->
        <v-list-tile>
          <v-list-tile-content>
            <v-list-tile-title>ダイレクトメッセージ</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action>
            <v-icon>add</v-icon>
          </v-list-tile-action>
        </v-list-tile>
        <div class="pl-2">
          <v-list-tile v-for="(user, index) in workspace.users" :key="index">
            <v-list-tile-content :class="userListClass(user.id)" @click="moveToUserDM(user.id)">
              <v-list-tile-sub-title># {{user.name}} <span v-if="user.name == Iam.name">(自分)</span></v-list-tile-sub-title>
            </v-list-tile-content>
          </v-list-tile>
        </div>
      </v-list>

      <!-- メンバーを招待する -->
      <v-list-tile>
        <v-list-tile-action>
          <v-icon>add</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title class="white--text">メンバーを招待する</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-navigation-drawer>
    <v-toolbar
      :clipped-left="clipped"
      fixed
      app
    >
      <!--<v-toolbar-side-icon @click="drawer = !drawer" />-->
      <!--<v-btn-->
        <!--icon-->
        <!--@click.stop="miniVariant = !miniVariant"-->
      <!--&gt;-->
        <!--<v-icon v-html="miniVariant ? 'chevron_right' : 'chevron_left'" />-->
      <!--</v-btn>-->
      <!--<v-btn-->
        <!--icon-->
        <!--@click.stop="clipped = !clipped"-->
      <!--&gt;-->
        <!--<v-icon>web</v-icon>-->
      <!--</v-btn>-->
      <!--<v-btn-->
        <!--icon-->
        <!--@click.stop="fixed = !fixed"-->
      <!--&gt;-->
        <!--<v-icon>remove</v-icon>-->
      <!--</v-btn>-->
      <v-toolbar-title v-text="workspace.name"/>
      <!--<v-btn-->
        <!--icon-->
        <!--@click.stop="rightDrawer = !rightDrawer"-->
      <!--&gt;-->
        <!--<v-icon>menu</v-icon>-->
      <!--</v-btn>-->
    </v-toolbar>
    <v-content>
      <v-container class="pb-0 px-0">
        <nuxt/>
      </v-container>
    </v-content>
    <v-navigation-drawer
      :right="right"
      v-model="rightDrawer"
      temporary
      fixed
    >
      <v-list>
        <v-list-tile @click.native="right = !right">
          <v-list-tile-action>
            <v-icon light>compare_arrows</v-icon>
          </v-list-tile-action>
          <v-list-tile-title>Switch drawer (click me)</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
  </v-app>
</template>

<script>
  export default {
    data() {
      return {
        clipped: false,
        drawer: true,
        fixed: false,
        items: [
          { icon: 'apps', title: 'Welcome', to: '/' },
          { icon: 'bubble_chart', title: 'Inspire', to: '/inspire' }
        ],
        miniVariant: false,
        right: true,
        rightDrawer: false,
        title: 'Vuetify.js',

        workspace: {},
      }
    },
    async created() {
      let {data} = await this.$axios.$get(`/workspaces/${this.$route.params.id}`);
      this.workspace = data;
    },
    methods: {
      moveToChannel(channelId) {
        this.$router.push(`/workspaces/${this.$route.params.id}/channels/${channelId}`)
      },
      moveToUserDM(userId) {
        this.$router.push(`/workspaces/${this.$route.params.id}/users/${userId}`)
      },

      channelListClass(channelId) {
        if (this.$route.params.channelid !== undefined) {
          if (this.$route.params.channelid == channelId) {
            return 'selected';
          }
        }
        return 'clickable';
      },

      userListClass(userId) {
        if (this.$route.params.userid) {
          if (this.$route.params.userid == userId) {
            return 'selected';
          }
        }
        return 'clickable';
      },
    },
  }
</script>

<style scoped>
  .clickable {
    cursor: pointer;
  }
  .clickable:hover {
    background-color: saddlebrown; /*todo: あとでいい感じのいろに*/
  }
  .selected {
    background-color: #3f9ae5;
  }
</style>