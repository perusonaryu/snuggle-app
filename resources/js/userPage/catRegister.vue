<template>
  <v-container class="wrap" v-if="user">
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
      <v-text-field
        v-model="form.personality"
        type="text"
        label="性格・特徴"
        :rules="personalityRules"
        outlined
      ></v-text-field>
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
      <v-file-input
        multiple
        label="猫画像"
        :rules="imageRules"
        prepend-inner-icon="mdi-camera"
        prepend-icon
        show-size
        v-on:change="confirmImage"
      ></v-file-input>
    </v-form>
    <p v-if="confirmedImage">
      <img :src="confirmedImage" class="img" />
    </p>

    <v-btn @click="catRegister">
      登録
    </v-btn>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    form: {
      name: '',
      age: '',
      personality: '',
      gender: '',
      image: '',
      userId: '',
    },
    userData: '',
    confirmedImage: '',
    genderData: [{ name: 'オス' }, { name: 'メス' }],
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
    personalityRules: [v => !!v || '性格・特徴を入力してください。'],
    genderRules: [v => !!v || '性別を入力してください。'],
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
        formData.append('image', this.form.image);
        formData.append('gender', this.form.gender);
        formData.append('userId', this.form.userId);
  
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

.img {
  width: 500px;
  height: 300px;
  background-size: cover;
  background-position: center;
}
</style>

<style>
.v-messages__message{
  color: red;
}  
</style>
