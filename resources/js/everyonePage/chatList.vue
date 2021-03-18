<template>
  <v-container class="chat-user-list">
    <v-row justify="center">
      <v-col md="8" cols="12">
        <v-card class="mx-auto" tile>
          <v-list>
            <v-subheader>トークリスト</v-subheader>
            <v-list-item-group color="primary">
              <v-list-item v-for="(chat, i) in chatList" :key="i">
                <chat-list
                  v-if="user.id != chat.user_id_1"
                  :userId="user.id"
                  :chatUserId="chat.user_id_1"
                ></chat-list>
                <chat-list
                  v-else-if="user.id != chat.user_id_2"
                  :userId="user.id"
                  :chatUserId="chat.user_id_2"
                ></chat-list>
                <chat-list
                  v-else-if="user.id == chat.user_id_2 && user.id == chat.user_id_1"
                  :userId="user.id"
                  :chatUserId="chat.user_id_2"
                ></chat-list>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    chatList: '',
  }),
  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
  },
  mounted() {
    this.$store.dispatch('auth/fetchUser');
    this.$store.subscribe(mutations => {
      if (mutations.type === 'auth/setUser') {
        this.chatListDataGet(this.user.id);
      }
    });
  },
  methods: {
    chatListDataGet(userId) {
      axios
        .get('api/messagelist/' + userId)
        .then(result => {
          this.chatList = result.data.chatList;
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.chat-user-list {
  margin-top: 100px;
}
</style>
