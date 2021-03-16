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
    <ul >
      <li>
        <router-link
          :to="{
            name: 'catSearched',
          }"
        >
          猫を探す
        </router-link>
      </li>
      <li v-if="!authCheck"  class="login">
        <router-link :to="{ name: 'userLogin' }">
          ログイン
        </router-link>
      </li>
      <v-menu v-if="authCheck">
        <template v-slot:activator="{ attrs, on }">
          <v-btn
            height="70"
            width="120"
            tile
            depressed
            color="#f6bba6"
            v-bind="attrs"
            v-on="on"
          >
            <v-img
              class="user-image"
              height="50"
              width="50"
              :src="`/storage/userImages/${user.image}`"
            >
            </v-img>
            <v-icon right dark>
              mdi-chevron-down
            </v-icon>
          </v-btn>
        </template>

        <v-list width="200" color="#E2E0CB">
          <v-list-item class="list-item">
            <router-link :to="{ name: 'userPage' }">
              マイページ
            </router-link>
          </v-list-item>
          <v-list-item class="list-item">
            <router-link :to="{ name: 'catRegister' }">
              猫登録
            </router-link>
          </v-list-item>
          <v-list-item class="list-item">
            <router-link :to="{ 
              name: 'catFavorite',
              params: { userId:user.id },
            }">
              お気に入り猫
            </router-link>
          </v-list-item>
          
          <v-list-item class="list-item">
            <router-link :to="{ name: 'chatList' }">
              チャットリスト
            </router-link>
          </v-list-item>
          <v-list-item class="list-item">
            <a @click="logout">
              ログアウト
            </a>
          </v-list-item>
        </v-list>
      </v-menu>
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
      if (userData && userData != 'null') {
        this.authCheck = true;
      } else {
        this.authCheck = false;
      }
    },
  },
  methods: {
    logout() {
      this.$store.dispatch('auth/logout');
    },
  },
};
</script>

<style scoped>
a{
  color: black;
}

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
  width: 270px;
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

.header .login {
  background-color: #f6bba6;
}

.header .login:hover {
  background-color: #f6bba6;
  opacity: 0.6;
}



.user-image {
  border-radius: 50%;
}

.list-item{
  display: flex;
  justify-content: center;
  align-items: center;
}

.list-item a{
  display: flex;
  justify-content: center;
  align-items: center;
  color: black;
  width: 200px;
  height: 48px;
}

.list-item:hover {
  background: white;
  opacity: 0.7;
}
</style>
