<template>
  <div>
    <div class="top-image">
      <img src="/storage/cat-top-image.png" alt="" />
      <p class="register-btn">
      <router-link  :to="{ name: 'userRegister' }" >
          新規登録の方はこちら
        </router-link>
      </p>
    </div>

    <v-container>
      <all-cat-list :userId="userData.id" />
    </v-container>
  </div>
</template>

<script>
export default {
  data: () => ({
    searchWord: '',
  }),
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
  methods: {
    
  },
};
</script>

<style scoped>
.top-image {
  width: 100%;
  position: relative;
}

.top-image img {
  object-fit: cover;
  width: 100%;
  height: 730px;
}

.register-btn{
  width: 280px;
  height: 70px;
  background-color: #F6BBA6;
  position: absolute;
  top:25%;
  right: 5%;
}

.register-btn a{
  color:white;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.register-btn:hover{
  opacity: 0.8;
}

</style>

<style></style>
