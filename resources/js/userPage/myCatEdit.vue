<template>
  <v-container class="wrap">
    <h2 class="text-center mb-5">🐈猫の編集🐈</h2>
    <div v-if="catData">
      <v-text-field
        v-model="catData.name"
        type="text"
        label="お名前"
        :rules="nameRules"
        outlined
      ></v-text-field>
      <v-select
        :items="ageData"
        item-text="age"
        item-value="age"
        label="年齢"
        :rules="ageRules"
        v-model="catData.age"
        outlined
        required
      ></v-select>
      <v-textarea
        counter
        label="募集経緯"
        :rules="backgroundRules"
        v-model="catData.background"
        outlined
      ></v-textarea>
      <v-textarea
        counter
        label="性格・特徴"
        :rules="personalityRules"
        v-model="catData.personality"
        outlined
      ></v-textarea>
      <v-select
        :items="genderData"
        item-text="name"
        item-value="name"
        label="性別"
        :rules="genderRules"
        v-model="catData.gender"
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
      <p>
        <img
          v-if="!confirmedImageShow"
          :src="`/storage/catImages/${beforeCatImage}`"
          height="200"
          width="250"
        />
        <v-img v-else-if="confirmedImageShow" :src="confirmedImage" height="200" width="250" />
      </p>
      <div class="btn-wrap">
        <v-btn class="save-btn" @click="catDataUpdate" color="#F6BBA6" width="250" height="50">
          保存
        </v-btn>
      </div>
    </div>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    catData: '',
    beforeCatImage: '',
    confirmedImage: '',
    confirmedImageShow: false,
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
    personalityRules: [
      v => !!v || '性格・特徴を入力してください。',
      v => v.length <= 250 || ' 250文字までです。 ',
    ],
    backgroundRules: [
      v => !!v || '募集経緯を入力してください。',
      v => v.length <= 250 || ' 250文字までです。 ',
    ],
    genderRules: [v => !!v || '性別を入力してください。'],
    imageRules: [v => !!v || '画像を選択してください。'],
  }),
  computed: {
    editCatData() {
      return (
        (this.catData = this.$store.getters['cat/editCatData']),
        (this.beforeCatImage = this.catData.image)
      );
    },
  },
  mounted() {
    this.$store.dispatch('cat/catEditDataGet', this.$route.params.catId);
    this.$store.subscribe(mutations => {
      if (mutations.type === 'cat/setCatEditData') {
        this.catData = this.$store.getters['cat/editCatData'];
        this.beforeCatImage = this.catData.image;
      }
    });
  },

  methods: {
    confirmImage(e) {
      if (e[0]) {
        this.catData.image = e[0];
        this.createImage(this.catData.image);
        this.confirmedImageShow = true;
      } else {
        this.confirmedImageShow = false;
        this.catData.image = 'null';
      }
    },

    createImage(image) {
      let reader = new FileReader();
      reader.readAsDataURL(image);
      reader.onload = e => {
        this.confirmedImage = e.target.result;
      };
    },

    catDataUpdate() {
      let updateFormData = new FormData();
      updateFormData.append('id', this.catData.id);
      updateFormData.append('name', this.catData.name);
      updateFormData.append('age', this.catData.age);
      updateFormData.append('personality', this.catData.personality);
      updateFormData.append('background', this.catData.personality);
      updateFormData.append('gender', this.catData.gender);
      updateFormData.append('image', this.catData.image);
      this.$store.dispatch('cat/catDataUpdate', updateFormData);
    },
  },
};
</script>

<style scoped>
.wrap {
  margin: 100px auto;
}

.btn-wrap {
  width: 100%;
  display: flex;
  justify-content: center;
}
</style>
