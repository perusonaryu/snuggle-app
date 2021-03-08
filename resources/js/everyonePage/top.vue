<template>
  <div>
    <div class="top-image">
      <img src="/storage/cat-top-image.jpg" alt="" />
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
  height: 500px;
  position: relative;
}

.top-image img {
  background-size: cover;
  object-fit: cover;
  width: 100%;
  height: 100%;
}

.top-image form {
  position: absolute;
  top: 50%;
  left: 25%;
  width: 50%;
}
</style>

<style></style>
