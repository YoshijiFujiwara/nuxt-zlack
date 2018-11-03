<template>
    <v-layout
        column
        justify-center
        align-center>
        <v-flex xs12 sm8>
            <div>
                <v-form @submit.prevent="selectWorkspace">
                    <v-card>
                        <v-card-title primary-title>
                            <div>
                                <h2 class="display-1 mb-3 font-weight-bold">ワークスペースにサインインする</h2>
                                <p>​参⁠加⁠し⁠て⁠い⁠る⁠ワ⁠ー⁠ク⁠ス⁠ペ⁠ー⁠ス⁠の​<span class="font-weight-bold">Zlack URL</span> を入力してください。</p>

                                <v-layout>
                                    <v-text-field
                                        v-model=""
                                        type="text"
                                        required
                                        placeholder="your-workspace-url"
                                        outline
                                    ></v-text-field>
                                    <span id="zlackcom">.zlack.com</span>
                                </v-layout>
                            </div>
                        </v-card-title>

                        <v-card-actions>
                            <v-btn
                                    block
                                    color="success"
                                    dark
                                    type="submit"
                            >続行する&nbsp;<v-icon>arrow_right_alt</v-icon></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
  export default {
    layout: 'gettingStarted',
    data(){
      return {
        form: {

        },
        errors: {},
      }
    },
    methods: {
      selectWorkspace() {
        axios.post('/api/auth/select_workspace', this.form)
          .then(res => this.$router.push(`/signin-workspace/${res.data.data.id}`))
          .catch(error => console.log(error));
      },
    }
  }
</script>

<style>
    #zlackcom {
        font-size: 30px;
        padding-bottom: 0px;
    }
</style>