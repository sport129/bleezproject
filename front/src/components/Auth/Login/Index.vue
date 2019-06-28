<template>
  <section class="student--login" style="color:#fff">
    <v-card 
    style="
    background:rgba(0,0,0,0.5)"
    >
      <v-card-text>
        <form>
          <v-flex>
            <img
              :src="imgLogo"
              alt="Logo"
              class="mb-5"
              width="300"
            />
          </v-flex>
          <v-flex>
            <v-text-field
              solo
              label="Usuário"
              v-model="stateAuth.model.username"
              prepend-inner-icon="account_circle"
            />
            <v-text-field
              solo
              label="Senha"
              type="password"
              v-model="stateAuth.model.password"
              @keyup.enter="onSignIn()"
              prepend-inner-icon="vpn_key"
            />
          </v-flex>
          <v-flex>
            <v-btn
              block
              large
              style ="
              background:#033f6d ;
              color:white ;
              "
              :loading="stateAuth.processing"
              @click.stop="onSignIn()"
            >
              Acessar
            </v-btn>
          </v-flex>
        </form>
      </v-card-text>
    </v-card>
  </section>
</template>

<script>
export default {
  name: 'AuthLoginTraditionalComponent',
  data () {
    return {
      stateAuth: {
        model: {
          username: '',
          password: ''
        },
        processing: false
      }
    }
  },
  methods: {
    async onSignIn () {
      const formValidated = await this.validateForm()
      if (!formValidated) {
        await this.openToast({ message: 'Preencha todos os campos do formulário.' })
        return false
      }
      this.stateAuth.processing = true
      const response = await this.$serviceAuth.signIn(this.stateAuth.model)
      if (response.status === 200) {
        this.openToast({ message: response.data.message })
        await this.sleep(2000)
        const { client, credentials } = response.data.documents
        this.$store.dispatch('userSignIn', {
          client,
          credentials,
          logged: true
        })
        this.$axios.defaults.headers.common['Authorization'] = `Bearer ${credentials.token}`
        this.$router.push('dashboard')
      }
      if (response.status > 200) {
        await this.openToast({ message: response.data.message })
      }
      this.stateAuth.processing = false
    },
    async validateForm () {
      return !(this.stateAuth.model.username === '' || this.stateAuth.model.password === '')
    },
    async openToast ({ message }) {
      this.$store.dispatch('setToast', { color: 'white', visible: true, content: message })
    },
    async sleep (timeout) {
      return new Promise(resolve => setTimeout(resolve, timeout))
    }
  },
  computed: {
    imgLogo () {
      return '/static/img/logos/logo.png'
    }
  }
}
</script>
