<template>
  <v-container>
    <div class="chat" v-if="user">
      <div class="message-list">
        <div v-if="chatUserData" class="d-flex align-center mb-5">
          <div>
            <v-img
              class="chat-user-image"
              :src="`/storage/userImages/${chatUserData.image}`"
              width="50"
              height="50"
            ></v-img>
          </div>
          <h4>{{ chatUserData.name }}さん</h4>
        </div>
        <div v-for="messageData in messageList" :key="messageData.id">
          <div v-if="messageData.send_user === user.id" class="send-message">
            <p class="message">{{ messageData.message }}</p>
            <p class="datetime">{{ messageData.created_at | datetime }}</p>
          </div>
          <div v-else class="receive-message">
            <p class="chat-user-name">{{ chatUserData.name }}</p>
            <p class="message">{{ messageData.message }}</p>
            <p class="datetime">{{ messageData.created_at | datetime }}</p>
          </div>
        </div>
      </div>
      <div class="message-text">
        <v-textarea
          solo
          counter
          :rules="messageRules"
          v-model="message"
          label="メッセージ"
        ></v-textarea>
        <div class="d-flex justify-center">
          <v-btn :disabled="messageCheck"  @click="send" class="send-btn" color="#f6bba6" width="200" height="50">送信</v-btn>
        </div>
      </div>
    </div>
  </v-container>
</template>

<script>
import moment from 'moment';
export default {
  data: () => ({
    message: '',
    messageError: false,
    messageList: '',
    messageRules: [
      v => !!v || 'メッセージを入力してください。',
      v => v.length <= 250 || ' 250文字までです。 ',
    ],
  }),
  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
    chatUserData() {
      return this.$store.getters['cat/postedUserData'];
    },
    messageCheck(){
      if(this.message){
        return false;
      }else{
        return true;
      }
      
    }
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
      if (this.message) {
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
      } else {
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

.chat-user-image {
  border-radius: 50%;
}

.message {
  border: 1px solid black;
  border-radius: 10px;
  display: inline-block;
  padding: 5px;
  max-width: 50%;
  word-break: break-all;
  white-space: pre;
  text-align: left;
}

.send-message {
  text-align: right;
}

.send-message .message {
  background: #f6bba6;
}

.receive-message .message {
  background: #e2e0cb;
}

.receive-message,
.send-message {
  margin-bottom: 10px;
}

.chat-user-name,
.datetime {
  font-size: 10px;
}
</style>
