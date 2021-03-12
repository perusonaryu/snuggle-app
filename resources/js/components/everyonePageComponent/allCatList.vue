<template>
  <div>
    <v-row v-if="AllCatData">
      <v-col
        cols="12"
        md="4"
        lg="4"
        v-for="catData in AllCatData"
        :key="catData.name"
        class="cat-detail"
      >
        <!-- <v-card class="mx-auto" width="100%" outlined>
          <v-list-item three-line>
            <router-link
              :to="{
                name: 'catDetail',
                params: { catId: catData.id },
              }"
            >
              <v-list-item-avatar rounded="50%" size="150">
                <v-img :src="`/storage/catImages/${catData.image}`"></v-img>
              </v-list-item-avatar>
            </router-link>
            <v-list-item-content>
              <v-list-item-title class="headline mb-1">
                {{ catData.name }}
              </v-list-item-title>
              <v-list-item-subtitle> {{ catData.age }}さい </v-list-item-subtitle>
              <v-list-item-subtitle> 性格：{{ catData.personality }} </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>

          <v-card-actions>
            <like-check class="check-btn" :catId="catData.id" :userId="userId"  />
          </v-card-actions>
        </v-card> -->

        <v-img :src="`/storage/catImages/${catData.image}`" class="cat-image">
          <router-link
            :to="{
              name: 'catDetail',
              params: { catId: catData.id },
            }"
          >
          </router-link>
        </v-img>
        <p class="text-center cat-name"> {{ catData.name }} </p>
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
    this.$store.dispatch('cat/allCatsData');
    this.$store.subscribe(mutations => {
      if (mutations.type === 'cat/setAllCatData') {
        this.AllCatData = this.$store.getters['cat/allCatData'];
      }
    });
  },
};
</script>

<style scoped>
.cat-detail a {
  display: inline-block;
  width: 100%;
  height:100%;
  border-radius: 50%;
}

.cat-detail .cat-name{
  margin-top: 16px;
}

.cat-image {
  width: 260px;
  height: 260px;
  border-radius: 50%;
  margin: 0 auto;
}

.cat-image:hover{
  opacity:0.8;
}

.check-btn {
  z-index: 3;
}
</style>
