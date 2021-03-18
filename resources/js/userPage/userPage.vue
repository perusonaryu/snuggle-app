<template>
  <v-container class="mypage" v-if="userData">
    <v-row>
      <v-col md="4" cols="12" class="userDetail p-0">
        <v-img
          class="user-image"
          width="100%"
          height="300"
          :src="`/storage/userImages/${userData.image}`"
        >
        </v-img>
        <div class="profile">
          <h5 class="">{{ userData.name }}</h5>
          <p>{{ userData.region }}</p>
          <p >
            プロフィール <br />
            <span class="profile-detail">{{userData.introduction}}</span>
          </p>
          <div class="d-flex justify-center">
            <router-link to="/userProfileEdit" class="mr-5">
              <v-btn color="#F6BBA6" width="150" height="50">プロフィール編集</v-btn>
            </router-link>

            <router-link :to="{ name: 'catRegister' }" class="ml-5">
              <v-btn color="#F6BBA6" width="150" height="50">猫登録</v-btn>
            </router-link>
          </div>
        </div>
      </v-col>

      <v-col md="8" cols="12">
        <h4 class="text-center mb-3">🐈登録している猫🐈</h4>
        <my-cats-list :userId="userData.id" />
      </v-col>
    </v-row>

    <div class="mycat-list"></div>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    userId: '',
  }),
  computed: {
    userData() {
      return this.$store.getters['auth/user'];
    },
  },

  methods: {},

  mounted() {
    this.$store.dispatch('auth/fetchUser');
    this.$store.subscribe(mutations => {
      if (mutations.type === 'auth/setUser') {
        const token = this.$store.getters['auth/token'];
        this.userId = this.userData.id;
      }
    });
  },
};
</script>

<style scoped>
.mypage {
  margin-top: 100px;
  margin-bottom: 100px;
}

.userDetail {
  border: 1px solid #e2e0cb;
  border-radius: 10px;
  text-align: center;
}

.user-image {
  border-radius: 10px;
  margin: 0 auto;
}

.profile {
  padding: 10px;
}

.profile-detail{
  white-space: pre;
}
</style>
