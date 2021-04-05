<template>
  <v-container class="wrap">
    <v-row justify="center" align="center">
      <v-col class="image" md="6" cols="12" v-if="catId == this.catDetail.id">
        <h2 class="text-center">{{ catDetail.name }}</h2>
        <img :src="`/storage/catImages/${catDetail.image}`" />
      </v-col>
      <v-col md="9" cols="12" class="cat-detail">
        <dl>
          <dt>掲載者</dt>
          <dd>{{ catPostedUserData.name }}</dd>
          <dt>現在所在地</dt>
          <dd>{{ catPostedUserData.region }}</dd>
          <hr />
          <dt>性別</dt>
          <dd>{{ catDetail.gender }}</dd>
          <dt>年齢</dt>
          <dd>{{ catDetail.age }}歳</dd>
          <!-- <dt>去勢</dt>
          <dd>している</dd>
          <dt>ワクチン</dt>
          <dd>接種済み</dd> -->

          <hr />
        </dl>
        <div class="content-wrap">
          <div class="detail-title">募集経緯</div>
          <p>{{ catDetail.background }}</p>
        </div>
        <hr />
        <div class="content-wrap">
          <div class="detail-title">性格・特徴</div>
          <p>{{ catDetail.personality }}</p>
        </div>
        <hr />
        <div class="chat-btn" v-if="catDetail.user_id != user.id">
          <router-link
            v-if="catDetail"
            :to="{
              name: 'chat',
              params: { chatUserId: catDetail.user_id, userId: user.id },
            }"
          >
            <v-btn color="#F6BBA6" width="250" height="50">里親を申し出る・質問をする</v-btn>
          </router-link>
        </div>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  data: () => ({}),
  computed: {
    catDetail() {
      return this.$store.getters['cat/detailCatData'];
    },
    catId() {
      return this.$route.params.catId;
    },
    catPostedUserData() {
      return this.$store.getters['cat/postedUserData'];
    },
    user() {
      return this.$store.getters['auth/user'];
    },
  },
  mounted() {
    this.catDatailGet();
  },
  watch: {
    catDetail: function(catDetail, undefind) {
      this.catPostedUserDataGet();
    },
  },

  methods: {
    catDatailGet() {
      this.$store.dispatch('cat/catDatailGet', this.$route.params.catId);
    },
    catPostedUserDataGet() {
      this.$store.dispatch('cat/postedUserDetail', this.catDetail.user_id);
    },
  },
};
</script>

<style scoped>
.wrap {
  margin-top: 60px;
  margin-bottom: 150px;
}

.image img {
  background-size: cover;
  background-position: center;
  width: 100%;
  border-radius: 10px;
  margin-bottom: 20px;
}

.cat-detail {
  border: 1px solid #e2e0cb;
  padding: 0;
}

hr {
  margin: 0;
}

dl {
  width: 100%;
  margin: 0;
}

dl dt {
  width: 20%;
  padding: 15px 0 15px 20px;
}

dl dd {
  width: 29%;
  padding: 15px 20px;
  margin: 0;
}

dl dt,
dl dd {
  display: inline-block;
}

dl dt,
.detail-title {
  background-color: #f6bba6;
}

.detail-title {
  font-size: 14px;
  font-weight: bold;
  width: 20%;
  padding: 15px 0px 15px 20px;
  display: flex;
  align-items: center;
}

.content-wrap {
  display: flex;
}

.content-wrap p {
  padding: 15px 20px;
  margin: 0;
  width: 80%;
  white-space: pre;
}

.chat-btn {
  padding: 20px;
  display: flex;
  justify-content: center;
}

@media screen and (max-width: 480px) {
  dl dt {
    width: 100%;
    padding: 15px 0 15px 20px;
  }

  dl dd {
    width: 100%;
    padding: 15px 20px;
    margin: 0;
  }

  .content-wrap{
    display: block;
  }
  
  .detail-title {
    width: 100%;
  }

  .content-wrap p {
    width: 100%;
  }
}
</style>
