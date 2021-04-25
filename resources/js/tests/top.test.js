import top from "../everyonePage/top.vue";

const { mount } = require("@vue/test-utils");

test("top.vueテスト", () => {
  const component = mount(top);
  console.log("top.vue OK");
});