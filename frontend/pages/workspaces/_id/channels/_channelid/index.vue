<template>
    <div>
        <v-layout
                column
                justify-center
                align-center>
            <!--<v-flex xs12>-->
            <!--<pre>-->
            <!--{{channel}}-->
            <!--</pre>-->
            <!--</v-flex>-->
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

            <v-jumbotron height="auto" style="margin-bottom: 100px;">
                <v-list three-line>
                    <!-- メッセージ一覧 -->
                    <template v-for="(message, index) in channel.messages">
                        <span v-if="message.id == hoveredMessageId" class="action-buttons">
                            <v-btn-toggle>
                                <v-tooltip top>
                                  <v-btn slot="activator" flat>
                                    <v-icon>feedback</v-icon>
                                  </v-btn>
                                  <span>リアクションする</span>
                                </v-tooltip>
                                <v-tooltip top>
                                  <v-btn slot="activator" flat>
                                    <v-icon>chat</v-icon>
                                  </v-btn>
                                  <span>スレッドを開始する</span>
                                </v-tooltip>
                                <v-tooltip top>
                                  <v-btn slot="activator" flat>
                                    <v-icon>arrow_forward</v-icon>
                                  </v-btn>
                                  <span>メッセージを共有する</span>
                                </v-tooltip>
                                <v-tooltip top>
                                  <v-btn slot="activator" flat>
                                    <v-icon>star_border</v-icon>
                                  </v-btn>
                                  <span>メッセージにスターを付ける</span>
                                </v-tooltip>
                                <v-menu offset-y>
                                    <v-btn
                                    slot="activator"
                                    icon
                                    >
                                        <v-icon>more_horiz</v-icon>
                                    </v-btn>
                                    <v-list>
                                        <v-list-tile>
                                            <v-list-tile-title><v-icon>edit</v-icon> メッセージを編集する</v-list-tile-title>
                                        </v-list-tile>
                                        <!-- todo: とりあえず、自分のメッセージだけ削除できるようにしておく -->
                                        <v-list-tile v-if="message.user.id == Iam.id">
                                            <v-list-tile-title @click.prevent="openDeleteDialog(message)"><v-icon>delete_forever</v-icon> メッセージを削除する</v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>
                        </v-btn-toggle>
                        </span>
                        <v-list-tile
                            :key="message.id"
                            avatar
                            @click=""
                            @mouseover="showActionButton(message.id)"
                            class="message-wrapper"
                        >
                            <v-list-tile-avatar>
                                <v-icon>accessibility_new</v-icon>
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title class="subheading"><span class="font-weight-bold">{{message.user.name}}</span>
                                    <small class="grey--text lighten-1">{{message.created_at}}</small>
                                </v-list-tile-title>
                                <p class="black--text">{{message.body}}</p>
                            </v-list-tile-content>
                        </v-list-tile>
                    </template>
                </v-list>
            </v-jumbotron>

            <pre>
                {{channel.messages}}
            </pre>

            <!-- 削除モーダル -->
            <v-dialog
                v-model="deleteDialog"
                max-width="290"
            >
                <v-card>
                    <v-card-title class="headline">メッセージを削除する</v-card-title>

                    <v-card-text>
                        このメッセージを本当に削除しますか？削除後は元に戻すことはできません。
                    </v-card-text>

                    <v-card-text>
                        {{tryDeleteMessage.body}}
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn
                            color="green darken-1"
                            flat="flat"
                            @click="deleteDialog = false, tryDeleteMessage = {}"
                        >
                            キャンセル
                        </v-btn>

                        <v-btn
                            color="red darken-1"
                            flat="flat"
                            @click="deleteMessage(tryDeleteMessage.id)"
                        >
                            削除
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
        <v-footer
            fixed
            height="auto"
        >
            <v-layout
                justify-end
                row
                wrap
            >
                <v-flex xs9 offset-xs-3 id="message-post-field">
                    <v-form @submit.prevent="createMessage">
                        <v-layout row wrap justify-end align-center>
                            <v-flex xs10>
                                <v-textarea
                                    v-model="form.messageBody"
                                    outline
                                    name="input-7-4"
                                    auto-grow
                                    rows="1"
                                ></v-textarea>
                            </v-flex>
                            <v-flex xs2>
                                <v-btn type="submit" color="success">送信</v-btn>
                            </v-flex>
                        </v-layout>
                    </v-form>
                </v-flex>
            </v-layout>
        </v-footer>
    </div>
</template>

<script>
  export default {
    middleware: ['auth'], // ログインしてなければ、ログインページにリダイレクト
    data() {
      return {
        channel: [],
        form: {
          messageBody: ''
        },
        hoveredMessageId: '', // マウスオーバーされているメッセージのid
        showOtherActionMenuId: '', // 表示するその他のアクションメニューの親メッセージid

        deleteDialog: false,

        // 削除しようとしているメッセージ
        tryDeleteMessage: {}

      }
    },
    async asyncData({$axios, params}) {
      let {data} = await $axios.$get(`/workspaces/${params.id}/channels/${params.channelid}`);
      return {
        channel: data
      }
    },
    methods: {
      async createMessage() {
        await this.$axios.$post(`/workspaces/${this.$route.params.id}/channels/${this.$route.params.channelid}/messages`, {body: this.form.messageBody});
        this.form.messageBody = '';
      },

      // ホバーしているときのみアクションボタングループを表示する
      showActionButton(messageId) {
        this.hoveredMessageId = messageId;
      },

      // 削除ダイアログを表示する
      openDeleteDialog(message) {
        this.deleteDialog = true;
        this.tryDeleteMessage = message;
      },

      // メッセージを削除する
      async deleteMessage(messageId) {
        await this.$axios.$delete(`/workspaces/${this.$route.params.id}/channels/${this.$route.params.channelid}/messages/${messageId}`);

        // todo: あとで、リアクションとか
      }
    },
  }
</script>

<style scoped>
    .v-footer {
        background-color: rgba(0, 0, 0, 0);
    }

    #message-post-field {
        background-color: white;
    }

    .message-wrapper {
        position: relative;
    }

    .action-buttons {
        position: absolute;
        right: 0;
        z-index: 1000;
    }

</style>