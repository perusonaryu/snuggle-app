<template>
  <v-container class="wrap">
      <h4 class="text-center">🐈お気に入り猫🐈</h4>
      <v-row>


      </v-row>
  </v-container>
</template>

<script>
export default {
    data: () => ({
      catsData:''
    }),

    mounted() {
      this.favolitCatsDataGet();
    },

    methods: {
      favolitCatsDataGet(){
        axios.get('api/favorite/cats/' + this.$route.params.userId)
        .then( result => {
          this.catsData = result.data.favolitCatsData;
        })
      }
    },
    
}
</script>

<style scoped>
.wrap{
  margin-top: 80px;
}
</style>