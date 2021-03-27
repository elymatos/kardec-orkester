<template>
  <div class="container--homepage">
    <span class="homepage--dots"></span>
    <div class="homepage-img--main">
      <div class="homepage-img--wrapper">
      </div>
      <div class="homepage--img--overlay"></div>
    </div>
    <div class="text1">
      <span class="welcome">Welcome to</span>
      <span class="webtool">CARMA</span>
        <span class="welcome">Constructional Analysis using Relations among Multiple AVMs</span>
    </div>
    <div class="text2 p-grid">
      <div v-if="true">
        <!-- show login when not authenticated -->
        <button class="btnAuth0">
          <a @click="login">Sign In</a>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Home',
  methods: {
    // Log the user in
    login() {
      this.$auth.loginWithRedirect();
    },
  }
}
</script>
