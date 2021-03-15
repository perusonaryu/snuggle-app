<template>
  <v-container class="wrap">
    <v-row justify="center" align="center">
      <v-col class="image" md="6" cols="12" v-if="catId == this.catDetail.id">
        <h2 class="text-center">{{ catDetail.name }}</h2>
        <img :src="`/storage/catImages/${catDetail.image}`" />
      </v-col>
      <v-col md="9" cols="12" class="cat-detail">
        <dl>
          <dt>掲載者のお名前</dt>
          <dd> {{ catPostedUserData.name }} </dd>
          <dt>現在所在地</dt>
          <dd>{{ catPostedUserData.region }}</dd>
          <hr />
          <dt>性別</dt>
          <dd>{{ catDetail.gender }}</dd>
          <dt>年齢</dt>
          <dd>{{ catDetail.age }}歳</dd>
          <hr>
          <dt>去勢</dt>
          <dd>している</dd>
          <dt>ワクチン</dt>
          <dd>接種済み</dd>

          <hr />
        </dl>
        <div class="content-wrap">
          <div class="detail-title">募集経緯</div>
          <p>
            子猫がひとりぼっちでいるところを見てしまったえさやりさんが
            しばらくは餌もやらず見守っていたそうですが こんなに小さい子が 回りに親も兄弟もおらず
            がんばっているのに居てもたってもいれず ついに餌をあげてしまったとのことです。
            餌をあげたからには 責任を持ちたいけれど
            自宅にはどうにもこうにも迎えることができないのでどうしたらよいかと相談をうけました。
          </p>
        </div>
        <hr />
        <div class="content-wrap">
          <div class="detail-title">性格・特徴</div>
          <p>
            {{ catDetail.personality }}
          </p>
        </div>
        <hr>
        <div class="chat-btn">
          <router-link
            v-if="catDetail"
            :to="{
              name: 'chat',
              params: { chatUserId: catDetail.user_id,userId:user.id },
            }"
          >
            <v-btn color="#F6BBA6" width="250" height="50">里親を申し出る・質問をする</v-btn>
          </router-link>
        </div>
        <!-- <v-row class="cat-detail">
          <v-col class="" md="4" cols="12"> </v-col>
          <v-col md="8" cols="12">
            <dl>
              <dt>現在所在地</dt>
              <dd>{{ catPostedUserData.region }}</dd>
              <dt>雌雄</dt>
              <dd>{{ catDetail.gender }}</dd>
              <dt>現在所在地</dt>
              <dd>{{ catPostedUserData.region }}</dd>
            </dl>
            <h4>掲載者</h4>
            <div class="user_information">
              <p>掲載者： {{ catPostedUserData.name }}</p>
              <p>所在県： {{ catPostedUserData.region }}</p>
              <p>自己紹介など： {{ catPostedUserData.introduction }}</p>
            </div>
            <router-link
              v-if="catDetail"
              :to="{
                name: 'chat',
                params: { chatUserId: catDetail.user_id },
              }"
            >
              <v-btn text>連絡をする</v-btn>
            </router-link>
          </v-col>
        </v-row> -->
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
    user(){
      return this.$store.getters['auth/user'];
    }
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
  margin-bottom: 100px;
}

.image img {
  background-size: cover;
  background-position: center;
  width: 100%;
  border-radius: 10px;
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

.detail-title {
  font-size: 14px;
  font-weight: bold;
  width: 10%;
}

.content-wrap {
  padding: 20px;
  display: flex;
}

.content-wrap p {
  padding-left: 50px;
  margin: 0;
  width: 80%;
}

.chat-btn{
  padding:20px;
  display: flex;
  justify-content: center;
}


</style>
