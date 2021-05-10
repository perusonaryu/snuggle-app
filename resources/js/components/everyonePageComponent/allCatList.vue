<template>
  <div class="wrap">
    <v-row v-if="CatsData">
      <v-col
        cols="12"
        md="4"
        lg="4"
        v-for="catData in CatsData"
        :key="catData.name"
        class="cat-detail"
      >
        <v-img
          :src="`https://snuggle-app.s3.ap-northeast-1.amazonaws.com/${catData.image}`"
          v-if="catData.image.match('catImages')"
          class="cat-image"
        >
          <router-link
            :to="{
              name: 'catDetail',
              params: { catId: catData.id },
            }"
          >
          </router-link>
        </v-img>

        <v-img :src="`/storage/catImages/${catData.image}`" v-else class="cat-image">
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
          <like-check
            v-if="userId != catData.user_id"
            class="check-btn"
            :catId="catData.id"
            :userId="userId"
          />
        </div>
      </v-col>
    </v-row>
    <div class="text-center">
      <v-pagination
        v-model="page"
        :length="lastPage"
        @input="getCats"
        circle
        color="#f6bba6"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
export default {
  data: () => ({
    CatsData: '',
    page: 1,
    lastPage: 1,
  }),
  props: ['userId'],

  mounted() {
    this.$store.dispatch('cat/topCatsData');
    this.$store.subscribe(mutations => {
      if (mutations.type === 'cat/setAllCatData') {
        const result = this.$store.getters['cat/allCatData'];
        this.CatsData = result.data;
        this.lastPage = result.last_page;
      }
    });

    const url = new URL(window.location.href);
    const params = url.searchParams;
    if (params.get('page') != 'null') {
      this.page = parseInt(params.get('page'));
      this.getCats(this.page);
    }else{
      this.getCats(this.page);
    }
  },
  methods: {
    getCats(page) {
      axios
        .get('api/cats/topdata', {
          params: {
            page: parseInt(page),
          },
        })
        .then(res => {
          const result = res.data.catsData;
          this.CatsData = result.data;

          let url = '/';
          if (this.page > 1) {
            url += '?page=' + this.page;
          }
          window.history.pushState(null, null, url);
        })
        .catch(error => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.wrap {
  margin-top: 40px;
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
