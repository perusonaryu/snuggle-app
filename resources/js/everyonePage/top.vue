<template>
  <div class="wrap">
    <div class="top-image">
      <img src="/cat-top-image.png" alt="" />
      <p class="register-btn" v-if="!userData">
        <router-link :to="{ name: 'userRegister' }">
          新規登録の方はこちら
        </router-link>
      </p>
    </div>
    <div class="adoption">
      <div class="adoption-title">
        <h2>里親募集</h2>
        <p>ADOPTION</p>
      </div>
      <div class="adoption-text">
        <p>
          伴侶動物との暮らしを考える。
        </p>
        <p>
          受け入れたこの親になるという事。<br class="sp" />
          未来の楽しい暮らしを想像しながら、<br class="sp" />
          あなたが引き取る子を選んでください。<br class="sp" />
        </p>
      </div>
    </div>

    <v-container>
      <all-cat-list :userId="userData.id" />
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({}),
  computed: {
    userData() {
      return this.$store.getters['auth/user'];
    },
  },
  mounted() {
    const token = this.$store.getters['auth/token'];
    if (token && token != 'null') {
      this.$store.dispatch('auth/fetchUser');
    }
  },
  methods: {},
};
</script>

<style scoped>
.wrap {
  margin: 0 0 50px;
}

.top-image {
  width: 100%;
  position: relative;
}

.top-image img {
  object-fit: cover;
  width: 100%;
  height: 730px;
}

.register-btn {
  width: 280px;
  height: 70px;
  background-color: #f6bba6;
  position: absolute;
  top: 25%;
  right: 5%;
}

.register-btn a {
  color: white;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 20px;
}

.register-btn:hover {
  opacity: 0.8;
}

.adoption {
  background-color: #e2e0cb;
  text-align: center;
  padding: 46px 0px 120px;
}

.adoption-title h2 {
  color: #f6bba6;
}

.adoption-text {
  margin-top: 60px;
  font-size: 16px;
}

.adoption-text .sp {
  display: none;
}

.adoption-text p + p {
  margin-top: 40px;
}

@media screen and (max-width: 480px) {
  .top-image img {
    object-fit: cover;
    width: 100%;
    height: 300px;
  }

  .register-btn {
    width: 200px;
    height: 50px;
    top: 60%;
  }

  .register-btn a {
    font-size: 15px;
  }

  .adoption{
    padding-bottom:50px;
  }

  .adoption-text {
    margin-top: 30px;
  }
  .adoption-text p {
    margin-right: 10px;
    margin-left: 10px;
  }

  .adoption-text .sp {
    display: block;
  }
}
</style>

<style></style>
