<template>
    <v-layout
        column
        justify-center
        align-center>
        <v-flex xs12>
            <pre>
                {{channel}}
            </pre>
        </v-flex>
        <v-jumbotron>
            <v-container fill-height>
                <v-layout align-center>
                    <v-flex>
                        <h3 class="display-3">#{{channel.name}}</h3>

                        <span class="subheading">Lorem ipsum dolor sit amet, pri veniam forensibus id. Vis maluisset molestiae id, ad semper lobortis cum. At impetus detraxit incorrupte usu, repudiare assueverit ex eum, ne nam essent vocent admodum.</span>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-jumbotron>

        <v-jumbotron xs12>
            <div>
                <v-list three-line>
                    <template v-for="(message, index) in channel.messages">
                        <v-list-tile
                            :key="message.id"
                            avatar
                            @click=""
                        >
                            <v-list-tile-avatar>
                                <v-icon>accessibility_new</v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title class="subheading"><span class="font-weight-bold">{{message.user.name}}</span>  <small class="grey--text lighten-1">{{message.created_at}}</small></v-list-tile-title>
                                <p class="black--text">{{message.body}}</p>
                            </v-list-tile-content>
                        </v-list-tile>
                    </template>
                </v-list>
            </div>
        </v-jumbotron>
    </v-layout>
</template>

<script>
  export default {
    middleware: ['auth'], // ログインしてなければ、ログインページにリダイレクト
    data() {
      return {
        channel: [],
      }
    },
    async asyncData({ $axios, params }) {
      let { data } = await $axios.$get(`/workspaces/${params.id}/channels/${params.channelid}`);
      return {
        channel: data
      }
    },
  }
</script>
