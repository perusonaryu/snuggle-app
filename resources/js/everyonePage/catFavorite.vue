<template>
  <v-container class="wrap">
    <h4 class="text-center">🐈お気に入り猫🐈</h4>
    <v-row>
      <v-col
        cols="12"
        md="4"
        lg="4"
        v-for="catData in catsData"
        :key="catData.name"
        class="cat-detail"
      >
        <v-img :src="`/storage/catImages/${catData.image}`" class="cat-image">
          <router-link
            :to="{
              name: 'catDetail',
              params: { catId: catData.id },
            }"
          >
          </router-link>
        </v-img>
        <div class="cat-content">
          <p class="text-center cat-name">{{ catData.name }}</p>
          <like-check class="check-btn" :catId="catData.id" :userId="$route.params.userId" />
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    catsData: '',
  }),

  mounted() {
    this.favolitCatsDataGet();
  },

  methods: {
    favolitCatsDataGet() {
      axios.get('api/favorite/cats/' + this.$route.params.userId).then(result => {
        this.catsData = result.data.favolitCatsData;
      });
    },
  },
};
</script>

<style scoped>
.wrap {
  margin-top: 80px;
  margin-bottom: 100px;
}

.cat-detail a {
  display: inline-block;
  width: 100%;
  height: 100%;
  border-radius: 50%;
}

.cat-detail .cat-name {
  margin-top: 16px;
}

.cat-image {
  width: 260px;
  height: 260px;
  border-radius: 50%;
  margin: 0 auto;
}

.cat-image:hover {
  opacity: 0.8;
}

.cat-content {
  width: 270px;
  position: relative;
  margin: 0 auto;
}

.check-btn {
  left: 0;
  bottom: -8px;
  position: absolute;
}
</style>
