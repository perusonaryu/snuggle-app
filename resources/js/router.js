import Vue from 'vue'
import VueRouter from 'vue-router'


// ページコンポーネントをインポートする
import Register from './auth/Register.vue'
import Login from './auth/Login.vue'

import userPage from './userPage/userPage.vue'
import userProfileEdit from './userPage/userProfileEdit.vue'
import catRegister from './userPage/catRegister.vue'
import myCatEdit from './userPage/myCatEdit.vue'

import topPage from './everyonePage/top.vue'
import catDetail from './everyonePage/catDetail.vue'
import chat from './everyonePage/chat.vue'
import chatList from './everyonePage/chatList.vue'
import catSearched from './everyonePage/catSearched.vue'
import catFavorite from './everyonePage/catFavorite.vue'



// ルータをインストール
Vue.use(VueRouter)


// パスとコンポーネントのマッピング
const routes = [
  //トップページ
  {
    path:'/',
    component:topPage,
    name:'topPage',
  },

  //猫詳細ページ
  {
    path:'/catDetail:catId',
    component:catDetail,
    name:'catDetail',
  },

  //ユーザー登録画面
  { 
    path: '/userRegister', 
    component: Register ,
    name:'userRegister'
  },

  //ログイン画面
  { 
    path: '/userLogin', 
    component: Login ,
    name: 'userLogin',
  },

  //マイページ
  { 
    path: '/userPage', 
    component:userPage,
    name: 'userPage', 
  },

  //ユーザー情報編集画面
  {
    path:'/userProfileEdit',
    component:userProfileEdit,
    name:'userProfileEdit'
  },

  //猫登録画面
  {
    path:'/catRegister',
    component:catRegister,
    name:'catRegister',
  },

  //猫編集ページ
  {
    path:'/myCatEdit:catId',
    component:myCatEdit,
    name:'myCatEdit'
  },

  //チャットリスト
  {
    path:'/chatList',
    component:chatList,
    name:'chatList',
  },
  
  //チャット画面
  {
    path:'/chat:chatUserId:userId',
    component:chat,
    name:'chat',
  },

  //猫検索結果画面
  {
    path:'/catSearched',
    component:catSearched,
    name:'catSearched',
  },
  //お気に入り猫画面
  {
    path:'/catFavorite:userId',
    component:catFavorite,
    name:'catFavorite',
  }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})




// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router