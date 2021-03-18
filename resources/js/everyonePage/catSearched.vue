<template>
  <v-container class="text-center wrap">
    <h2>猫を探す</h2>

    <p class="error-text" v-if="error">文字を入力してください！</p>
    <v-select
      :items="prefectures"
      item-text="name"
      item-value="name"
      label="地域で検索"
      v-model="searchWord"
      outlined
      @change="search"
    ></v-select>

    <v-row v-if="catsSearchedData.length > 0" class="content">
      <v-col
        cols="12"
        md="4"
        lg="4"
        v-for="catData in catsSearchedData"
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
          <like-check v-if="user.id != catData.user_id" class="check-btn" :catId="catData.id" :userId="user.id" />
        </div>
      </v-col>
    </v-row>
    <h3 v-else>該当する猫はいません。</h3>
  </v-container>
</template>

<script>
import prefectureData from '../prefectureData.json';
export default {
  data: () => ({
    catsData: '',
    searchWord: '',
    error: false,
    prefectures: [],
  }),

  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
    catsSearchedData() {
      return this.catsData;
    },
    allCatsData() {
      return this.$store.getters['cat/allCatData'];
    },
  },
  mounted() {
    this.prefectures = prefectureData;
    this.allCatsDataGet();
    const token = this.$store.getters['auth/token'];
    if (token && token != 'null') {
      this.$store.dispatch('auth/fetchUser');
    }
  },

  watch: {
    allCatsData: function(allCatsData, undefind) {
      this.catsData = allCatsData;
    },
  },

  methods: {
    allCatsDataGet() {
      this.$store.dispatch('cat/allCatsData');
    },
    search() {
      if (this.searchWord == '全て') {
        axios
          .get('api/search', { params: '' })
          .then(result => {
            this.catsData = result.data.searchedCatsData;
            this.error = false;
          })
          .catch(error => {
            console.log(error);
          });
      } else if (this.searchWord) {
        axios
          .get('api/search', { params: this.searchWord })
          .then(result => {
            this.catsData = result.data.searchedCatsData;
            this.error = false;
          })
          .catch(error => {
            console.log(error);
          });
      } else {
        this.error = true;
      }
    },
  },
};
</script>

<style scoped>
.wrap {
  margin-top: 60px;
  margin-bottom: 100px;
}

.content {
  margin: 20px 0;
}

.error-text {
  color: red;
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

<style>
.v-select__slot .v-label {
  top: auto;
  margin: 0;
}
</style>
