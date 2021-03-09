<template>
  <v-container>
    <h2 class="text-center mb-5">猫を登録</h2>
    <div v-if="catData">
      <v-text-field v-model="catData.name" type="text" label="お名前" outlined></v-text-field>
      <!-- <v-text-field v-model="catData.age" type="text" label="年齢" outlined></v-text-field> -->
      <v-select
        :items="ageData"
        item-text="age"
        item-value="age"
        label="年齢"
        v-model="catData.age"
        outlined
        required
      ></v-select>
      <v-text-field v-model="catData.personality" type="text" label="性格" outlined></v-text-field>
      <v-select
        :items="genderData"
        item-text="name"
        item-value="name"
        label="性別"
        v-model="catData.gender"
        outlined
        required
      ></v-select>
      <v-file-input
        multiple
        label="猫画像"
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

      <v-btn @click="catDataUpdate">
        保存
      </v-btn>
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
      updateFormData.append('gender', this.catData.gender);
      updateFormData.append('image', this.catData.image);
      this.$store.dispatch('cat/catDataUpdate', updateFormData);
    },
  },
};
</script>

<style></style>
