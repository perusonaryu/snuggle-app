<template>
  <v-container>
    <div class="chat" v-if="user">
      <div class="message-list">
        <h4 v-if="chatUserData">{{ chatUserData.name }}さん</h4>
        <div v-for="messageData in messageList" :key="messageData.id">
          <div v-if="messageData.send_user === user.id" class="send-message">
            <p class="message">
              {{ messageData.message }}
            </p>
            <p class="datetime">{{ messageData.created_at | datetime }}</p>
          </div>
          <div v-else class="receive-message">
            <p class="chat-user-name">{{ chatUserData.name }}</p>
            <p class="message">
              {{ messageData.message }}
            </p>
            <p class="datetime">{{ messageData.created_at | datetime }}</p>
          </div>
        </div>
      </div>

      <p v-if="messageError" class="error-message">メッセージを入力してください！</p>
      <div class="d-flex">
        <v-text-field v-model="message" solo label="メッセージ" clearable></v-text-field>
        <v-btn @click="send" color="#E2E0CB" height="48">送信</v-btn>
      </div>
      
    </div>
  </v-container>
</template>

<script>
import moment from 'moment';
export default {
  data: () => ({
    message: '',
    messageError:false,
    messageList: '',
  }),
  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
    chatUserData() {
      return this.$store.getters['cat/postedUserData'];
    },
  },
  mounted() {
    if (this.user) {
      this.messageDataGet(this.user.id, this.$route.params.chatUserId);
    } else {
      this.$store.dispatch('auth/fetchUser');
    }
    this.messageReceive();
    this.chatUserGet(this.$route.params.chatUserId);
  },
  watch: {
    user: function(userData, undefind) {
      this.messageDataGet(userData.id, this.$route.params.chatUserId);
    },
  },
  filters: {
    datetime: function(date) {
      return moment(date).format('YYYY/MM/DD HH:mm');
    },
  },
  methods: {
    send() {
      if(this.message){
        this.messageError = false;
        axios
          .post('api/send', {
            sendId: this.user.id,
            receiveId: this.$route.params.chatUserId,
            message: this.message,
          })
          .then(result => {
            this.messageList.push({
              message: this.message,
              send_user: this.user.id,
            });
            this.message = '';
          })
          .catch(error => {
            console.log(error);
          });

      }else{
        this.messageError = true;
      }
    },
    chatUserGet(chatUserId) {
      this.$store.dispatch('cat/postedUserDetail', chatUserId);
    },
    messageDataGet(userId1, userId2) {
      axios.get('api/messages/' + userId1 + '/' + userId2).then(result => {
        this.messageList = result.data.message;
      });
    },
    messageReceive() {
      const token = this.$store.getters['auth/token'];
      Echo.options.auth.headers['Authorization'] = `Bearer ${token}`;

      Echo.private('message.' + this.$route.params.userId).listen('.message-sent', e => {
        this.messageList.push({
          message: e.message,
          send_user: e.send_user,
        });
      });
    },
  },
};
</script>

<style scoped>
p {
  margin: 0;
}

.chat {
  max-width: 500px;
  margin: 100px auto 100px;
}

.message {
  border: 1px solid black;
  border-radius: 10px;
  display: inline-block;
  padding: 5px;
  max-width: 50%;
  word-break: break-all;
}

.send-message {
  text-align: right;
}

.receive-message,
.send-message {
  margin-bottom: 10px;
}

.chat-user-name,
.datetime {
  font-size: 10px;
}

.error-message{
  color:red;
  font-size:12px;
}
</style>
