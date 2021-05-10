import top from "../everyonePage/top.vue";
import { shallowMount, createLocalVue } from '@vue/test-utils';
import Vuex from "vuex"

const localVue = createLocalVue()
localVue.use(Vuex)

let wrapper
let store
let actions
let mutations
let state
let getters

beforeEach(() => {
  actions = {
    
  }
  mutations = {}
  state = {
    entries: {
      sales: 1000,
      cost:  500
    }
  },
  getters = {
    entries(state) { return state.entries }
  },
  store = new Vuex.Store({
    actions,
    mutations,
    state,
    getters
  }),
  wrapper = shallowMount(top, {
    store,
    localVue,    
  })
})

afterEach(() => {
  wrapper.destroy();
})

describe('Testing App component', () => {
    it('is a Vue instance', () => {
      expect(wrapper.isVueInstance).toBeTruthy()
    })
})