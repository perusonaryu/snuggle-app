<template>
  <div class="footer">
    <div class="logo">
      <router-link
        class="logo"
        :to="{
          name: 'topPage',
        }"
      >
        <img src="/nekologo3.png" />
      </router-link>
    </div>
    <p class="copyright text-center">Copyright &copy; snuggle All Rights Reserved</p>
  </div>
</template>

<script>
export default {};
</script>

<style scoped>
.footer {
  width: 100%;
  padding: 5px 0;
  background-color: #f6bba6;
  position: absolute;
  bottom: 0;
}

.logo {
  display: flex;
  justify-content: center;
}

.logo img {
  width: 270px;
  height: 50px;
}

.copyright {
  margin: 0;
  font-size: 12px;
}
</style>
