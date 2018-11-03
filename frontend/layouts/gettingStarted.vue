<template>
    <v-app>
        <v-toolbar
            :clipped-left="clipped"
            fixed
            app
        >
            <v-toolbar-title v-text="title"/>
            <v-spacer></v-spacer>
            <v-btn v-for="item in toolbarItems" :key="item.title" :class="item.class" :outline="item.outline">
                <nuxt-link :to="item.link">{{item.title}}</nuxt-link>
            </v-btn>
        </v-toolbar>
        <v-content>
            <v-container>
                <nuxt />
            </v-container>
        </v-content>

        <v-footer
            :fixed="fixed"
            app
        >
            <span>&copy; 2017</span>
        </v-footer>
    </v-app>
</template>

<script>
  export default {
    data() {
      return {
        title: 'Zlack',
        fixed: false,
        toolbarItems: [
          {class: 'elevation-0', outline: false, link: '/', title: '製品'},
          {class: 'elevation-0', outline: false, link: '/', title: '料金プラン'},
          {class: 'elevation-0', outline: false, link: '/', title: 'サポート'},
          {class: 'elevation-0', outline: true, link: '/', title: '参加中のワークスペース'}
        ],
      }
    }
  }
</script>
