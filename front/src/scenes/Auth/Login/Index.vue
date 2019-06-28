<template>
  <div class="auth--container" style="color:#fff">
    <v-container class="container fluid auth-content" fluid align-center fill-height>
      <v-layout
        v-layout
        align-center
        column
        justify-center
      >
        <intranet-auth-login />
      </v-layout>
    </v-container>
    <div class="auth--cap"></div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      processing: false
    }
  },
  mounted () {
    if (this.stateAuth.logged) {
      this.processing = true
      setTimeout(() => { this.$router.push('/professor/dashboard') }, 2000)
    }
  },
  computed: {
    stateAuth () {
      return this.$store.getters.auth
    }
  }
}
</script>



<style>
html, body {
  padding: 0;
  margin: 0;
  overflow: auto !important;
}

.container--desktop {
  padding-right: 100px;
}

.auth--container {
  height: 100%;
}

.auth--cap { 
  height: 100%;
  color: rgba(255,255,255,0.2);
  background: url(/static/img/scenes/background.png),#1e558b;
  background-position: center 10%;
  background-size: cover;
}

.auth-content {
  position: fixed;
}
</style>
