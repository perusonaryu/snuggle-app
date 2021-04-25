<template>
  <v-row class="wrap" justify="center" v-if="user">
    <v-col md="6">
      <v-form @submit.prevent="catRegister" ref="form" lazy-validation>
        <h2 class="text-center mb-5">猫を登録</h2>
        <v-text-field
          v-model="form.name"
          type="text"
          label="お名前"
          :rules="nameRules"
          outlined
          required
        ></v-text-field>
        <v-select
          :items="ageData"
          item-text="age"
          item-value="age"
          label="年齢"
          :rules="ageRules"
          v-model="form.age"
          outlined
          required
        ></v-select>
        <v-select
          :items="genderData"
          item-text="name"
          item-value="name"
          label="性別"
          :rules="genderRules"
          v-model="form.gender"
          outlined
          required
        ></v-select>
        <v-select
          :items="castrationSurgery"
          item-text="name"
          item-value="name"
          label="不妊去勢手術"
          :rules="castrationSurgeryRules"
          v-model="form.castrationSurgery"
          outlined
          required
        ></v-select>
        <v-select
          :items="vaccine"
          item-text="name"
          item-value="name"
          label="ワクチン"
          :rules="vaccineRules"
          v-model="form.vaccine"
          outlined
          required
        ></v-select>
        <v-select
          :items="prefectures"
          item-text="name"
          item-value="name"
          label="地域選択"
          v-model="form.region"
          outlined
        ></v-select>
        <v-textarea
          counter
          label="募集経緯"
          :rules="backgroundRules"
          v-model="form.background"
          outlined
          hint="例:家で買い続けることが出来なくなったため..."
        ></v-textarea>
        <v-textarea
          counter
          label="性格・特徴"
          :rules="personalityRules"
          v-model="form.personality"
          outlined
          hint="例:撫でる事も出来て、大人しいです。"
        ></v-textarea>

        <v-file-input
          multiple
          accept="image/png, image/jpeg"
          prepend-icon="mdi-camera"
          label="猫画像"
          :rules="imageRules"
          show-size
          v-on:change="confirmImage"
        ></v-file-input>
      </v-form>
      <p v-if="confirmedImage">
        <v-img width="350" :src="confirmedImage" />
      </p>

      <div class="btn-wrap">
        <v-btn class="save-btn" @click="catRegister" color="#F6BBA6" width="250" height="50">
          保存
        </v-btn>
      </div>
    </v-col>
  </v-row>
</template>

<script>
import prefectureData from '../prefectureData.json';
export default {
  data: () => ({
    form: {
      name: '',
      age: '',
      personality: '',
      gender: '',
      background: '',
      image: '',
      userId: '',
      region: '',
      castrationSurgery: '',
      vaccine: '',
    },
    prefectures: [],
    userData: '',
    confirmedImage: '',
    genderData: [{ name: 'オス' }, { name: 'メス' }],
    castrationSurgery: [{ name: '済' }, { name: '未' }],
    vaccine: [{ name: '済' }, { name: '未' }],
    ageData: [
      { age: '1' },
      { age: '2' },
      { age: '3' },
      { age: '4' },
      { age: '5' },
      { age: '6' },
      { age: '7' },
      { age: '8' },
      { age: '9' },
      { age: '10歳以上' },
    ],
    nameRules: [v => !!v || 'お名前を入力してください。'],
    ageRules: [v => !!v || '年齢を入力してください。'],
    personalityRules: [
      v => !!v || '性格・特徴を入力してください。',
      v => v.length <= 250 || ' 250文字までです。 ',
    ],
    backgroundRules: [
      v => !!v || '募集経緯を入力してください。',
      v => v.length <= 250 || ' 250文字までです。 ',
    ],
    genderRules: [v => !!v || '性別を入力してください。'],
    regionRules: [v => !!v || '地域を入力してください。'],
    castrationSurgeryRules:[v => !!v || '不妊去勢手術を入力してください。'],
    vaccineRules:[v => !!v || 'ワクチンを入力してください。'],
    imageRules: [v => !!v || '画像を選択してください。'],
  }),
  computed: {
    user() {
      return this.$store.getters['auth/user'];
    },
  },
  watch: {
    user: function(user, undefind) {
      this.form.userId = user.id;
    },
  },
  mounted() {
    this.prefectures = prefectureData;
    const token = this.$store.getters['auth/token'];
    if (token && token != 'null') {
      this.$store.dispatch('auth/fetchUser');
    } else {
      this.$router.push({ name: 'userLogin' });
    }
  },

  methods: {
    catRegister() {
      if (this.$refs.form.validate()) {
        let formData = new FormData();
        formData.append('name', this.form.name);
        formData.append('age', this.form.age);
        formData.append('personality', this.form.personality);
        formData.append('background', this.form.background);
        formData.append('image', this.form.image);
        formData.append('gender', this.form.gender);
        formData.append('userId', this.form.userId);
        formData.append('region', this.form.region);
        formData.append('castrationSurgery', this.form.castrationSurgery);
        formData.append('vaccine', this.form.vaccine);

        this.$store.dispatch('cat/register', formData);
      }
    },
    confirmImage(e) {
      this.form.image = e[0];
      this.createImage(this.form.image);
    },

    createImage(image) {
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.confirmedImage = e.target.result;
      };
    },
  },
};
</script>

<style scoped>
.wrap {
  margin-top: 100px;
  margin-bottom: 100px;
}
</style>

<style>
.btn-wrap {
  display: flex;
  justify-content: center;
}
</style>
