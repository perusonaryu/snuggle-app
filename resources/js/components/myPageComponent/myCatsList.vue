<template>
  <v-row justify="space-between">
    <v-col v-for="catData in myCats" :key="catData.name" md="6">
      <v-card class="mx-auto" max-width="400" outlined>
        <v-list-item three-line>
          <v-list-item-avatar rounded="50%" size="100">
            <v-img
              :src="`https://snuggle-app.s3.ap-northeast-1.amazonaws.com/${catData.image}`"
              v-if="catData.image.match('catImages')"
            ></v-img>
            <v-img :src="`/storage/catImages/${catData.image}`" v-else></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline mb-1">
              {{ catData.name }}
            </v-list-item-title>
            <v-list-item-subtitle v-if="catData.age.length <= 1">
              {{ catData.age }}さい
            </v-list-item-subtitle>
            <v-list-item-subtitle v-else> {{ catData.age }} </v-list-item-subtitle>
            <v-list-item-subtitle> 性格：{{ catData.personality }} </v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>

        <v-card-actions>
          <router-link
            :to="{
              name: 'myCatEdit',
              params: { catId: catData.id },
            }"
          >
            <v-btn outlined rounded text>
              編集
            </v-btn>
          </router-link>
          <v-spacer></v-spacer>
          <v-dialog transition="dialog-top-transition" max-width="600" class="delete-dialog">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="red" outlined rounded text v-bind="attrs" v-on="on">削除</v-btn>
            </template>
            <template v-slot:default="dialog">
              <v-card>
                <v-toolbar color="red" dark class="text-h5 mb-5">本当に削除しますか？</v-toolbar>
                <v-card-text>
                  <div class="d-flex justify-center">
                    <v-btn color="red" outlined rounded text @click="catDelete(catData.id)"
                      >はい</v-btn
                    >
                    <v-btn outlined rounded text @click="dialog.value = false">いいえ</v-btn>
                  </div>
                </v-card-text>
              </v-card>
            </template>
          </v-dialog>
          <!-- <v-btn outlined rounded text color="red" @click="catDelete(catData.id)">
            削除
          </v-btn> -->
        </v-card-actions>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
export default {
  data: function() {
    return {};
  },

  props: ['userId'],

  computed: {
    myCats() {
      return this.$store.getters['cat/myCatsList'];
    },

    user() {
      return this.$store.getters['auth/user'];
    },
  },
  watch: {
    user: function(user, undefind) {
      const token = this.$store.getters['auth/token'];
      this.$store.dispatch('cat/myCatsListGet', { userId: user.id, token: token });
    },
  },
  mounted() {},

  methods: {
    catDelete(catId) {
      const token = this.$store.getters['auth/token'];
      axios
        .delete('api/cat/delete/' + catId, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then(result => {
          this.$store.dispatch('cat/myCatsListGet', { userId: this.user.id, token: token });
          dialog.value = false;
        });
    },
  },
};
</script>

<style scoped>
.delete-dialog {
  height: 400px;
}
</style>
