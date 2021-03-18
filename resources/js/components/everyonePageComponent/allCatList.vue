<template>
  <div class="wrap">
    <v-row v-if="AllCatData">
      <v-col
        cols="12"
        md="4"
        lg="4"
        v-for="catData in AllCatData"
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
          <like-check v-if="userId != catData.user_id" class="check-btn" :catId="catData.id" :userId="userId" />
        </div>
      </v-col>
    </v-row>
  </div>
</template>

<script>
export default {
  data: () => ({
    AllCatData: '',
  }),
  props: ['userId'],

  mounted() {
    this.$store.dispatch('cat/topCatsData');
    this.$store.subscribe(mutations => {
      if (mutations.type === 'cat/setAllCatData') {
        this.AllCatData = this.$store.getters['cat/allCatData'];
      }
    });
  },
};
</script>

<style scoped>
.wrap{
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
