<template>
  <div class="header">
    <router-link
      class="logo"
      :to="{
        name: 'topPage',
      }"
    >
      <img src="/storage/nekologo3.png" />
    </router-link>
    <ul>
      <!-- <li v-if="!authCheck">
        <router-link  :to="{ name: 'userRegister' }">
          新規登録
        </router-link>
      </li> -->

      <li v-if="authCheck">
        <router-link :to="{ name: 'userPage' }">
          マイページ
        </router-link>
      </li>
      <li v-if="authCheck">
        <router-link :to="{ name: 'catRegister' }">
          猫登録
        </router-link>
      </li>
      <li v-if="authCheck">
        <router-link :to="{ name: 'chatList' }">
          チャットリスト
        </router-link>
      </li>
      <li>
        <router-link
          :to="{
            name: 'catSearched',
          }"
        >
          猫を探す
        </router-link>
      </li>
      <li v-if="authCheck">
        <a @click="logout">
          ログアウト
        </a>
      </li>
      <li v-if="!authCheck" class="login">
        <router-link :to="{ name: 'userLogin' }">
          ログイン
        </router-link>
      </li>
      <div v-if="authCheck">
        <span class="user-name">
          {{ user.name }}
        </span>
        さん
      </div>
    </ul>
  </div>
</template>

<script>
export default {
  data: () => ({
    authCheck: false,
  }),
  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
  },
  mounted() {
    const token = this.$store.getters['auth/token'];

    if (token && token != 'null') {
      this.$store.dispatch('auth/fetchUser');
      this.authCheck = true;
    } else {
      this.authCheck = false;
    }
  },
  watch: {
    user: function(userData, undefind) {
      if (userData) {
        this.authCheck = true;
      } else {
        this.authCheck = false;
      }
    },
  },
  methods: {
    logout() {
      this.$store.dispatch('auth/logout').then(() => {
        if (this.$route.path != '/') this.$router.push({ name: 'topPage' });
      });
    },
  },
};
</script>

<style scoped>
ul {
  margin: 0;
  padding: 0;
}

.header {
  display: flex;
  justify-content: space-between;
  position: fixed;
  width: 100%;
  z-index: 5;
  background: rgba(255, 255, 255, 0.7);
}

.header .logo {
  margin: 10px 20px;
  width: 272px;
  height: 50px;
}

.header .logo:hover {
  opacity: 0.7;
}

.header .logo img {
  width: 100%;
  height: 100%;
}

.header ul {
  display: flex;
  list-style: none;
  align-items: center;
  margin: 0;
}

.header ul li {
  height: 100%;
  width: 140px;
}

.header ul li a {
  color: #333333;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.header ul li:hover {
  background-color: #dae2db;
}

.header .login{
  background-color: #F6BBA6;
}

.header .login:hover{
  background-color: #F6BBA6;
  opacity: 0.6;
}

.user-name {
  font-weight: bold;
}


</style>
