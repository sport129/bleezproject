<template>
  <v-app id="inspire">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <!-- top --> 
    <v-toolbar
      app
      style="background-color: #582EFF;"
      fixed
      clipped-left
      clipped-right
      v-if="stateAuth.logged"
    >
      <!-- top info -->

        <img src="/static/img/scenes/bleez-e-commerce.png" alt="Logo" > 
        <v-flex xs1 style="margin-left:20px;"> 
          <v-toolbar-title
           class="toolbar-title ml-0 white--text" >{{ statePage.title }}
          </v-toolbar-title>
        </v-flex>
        <v-spacer></v-spacer>
        <v-btn icon @click="registerUserDialog = true" style="color:white" >
          <v-icon>person_add</v-icon>
        </v-btn>
        <v-btn icon @click="onHandleLogoutProcess()" style="color:white" >
          <v-icon>exit_to_app</v-icon>
        </v-btn>
      <!-- *** -->

    </v-toolbar>

  <!-- *** -->

    <!-- SE LOGADO  -->
    <v-content v-if="stateAuth.logged">
      <v-container fluid class="pa-0">
        <router-view />
      </v-container>
    </v-content>
    <!-- *** -->

    <!-- SE NÃO LOGADO -->
    <router-view  v-if="!stateAuth.logged" /> 
    <!-- *** -->

    <!--  DIALOG PARA LOGOUT-->
    <template v-if="stateAuth.logged">
      <div class="text-xs-center">
        <v-dialog
          v-model="registerUserDialog"
          width="500"
          persistent
        > 
          <v-card>
            <v-card-title
              class="headline lighten-2 white--text"
              primary-title
              style="background-color: #582EFF !important;"
            >
              Cadastrar Usuário
              <v-spacer></v-spacer>
              <v-btn icon dark @click="closeDialogRegisterUser()">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <v-text-field
                v-model="payloadRegisterUser.username"
                label="Username"
              >
              </v-text-field>
              <v-text-field
                v-model="payloadRegisterUser.password"
                label="Senha"
                :rules="[() => verifyPass() || 'Senha deve conter minimo 6 digitos']"
                :type="show1 ? 'text' : 'password'"
              ></v-text-field>
              <v-text-field
                v-model="confirmpass"
                :rules="[() => verifyPasswordEqual() || 'Senhas Não Conferem']"
                label="Confirmar Senha"
                :type="show1 ? 'text' : 'password'"
              >
              </v-text-field>
              <v-text-field
                :rules="[() => validateEmail() || 'Digite um Email valido']"
                v-model="payloadRegisterUser.email"
                label="E-mail"
              >
              </v-text-field>
              <v-text-field
                v-model="confirmemail"
                label="Confirmar E-mail"
                :rules="[() => verifyemailequal() || 'E-mails não conferem']"
              >
              </v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="success" @click="onHandleRegisterProcess()" :loading="btnProcessing" :disabled="disableFormBtn">
                Cadastrar Usuario
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        
        <v-dialog
          v-model="logout.dialog"
          width="500"
          persistent
        >
          <v-card>
            <v-card-title style="font-size:20px;">Encerrar Sessão</v-card-title>
            <v-divider></v-divider>
            <v-card-text style="height:100px">
              <v-layout justify-center align-center fill-height>
                Deseja realmente sair ?
              </v-layout>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
              <v-btn
                flat
                color="grey"
                @click="onHandleLogoutCancel()"
              >
                Cancelar
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn
                flat
                color="green"
                @click="onHandleLogoutProcess()"
              >
                Sair
              </v-btn>
            </v-card-actions>
            <v-layout v-if="logout.processing" align-center justify-center column class="card-logout-processing">
              <v-progress-circular
                :size="70"
                :width="2"
                indeterminate
                color="primary"
              ></v-progress-circular>
            </v-layout>
          </v-card>
        </v-dialog>
      </div>
    </template>
    <!-- *** -->

    <intranet-shareds-toast />
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      dialog: false,
      appName: 'Intranet',
      drawerLeft: true,
      drawerRight: false,
      menuOptions: false, // menu
      logout: {
        stage: 0,
        dialog: false,
        processing: false
      },
      registerUserDialog: false,
      payloadRegisterUser: {
        username: '',
        password: '',
        email: ''
      },
      confirmemail: '',
      confirmpass: '',
      btnProcessing: false
    }),
    methods: {
      closeDialog () {
        this.dialog = false
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: 'Usuário cadastrado com sucesso' })
      },
      closeDialogRegisterUser () {
        this.payloadRegisterUser = {
          username: '',
          password: '',
          email: ''
        }
        this.confirmemail = ''
        this.confirmpass = ''
        this.btnProcessing = false
        this.registerUserDialog = false
      },
      verifyemailequal () {
        if (this.payloadRegisterUser.email !== this.confirmemail) {
          return false
        } else {
          return true
        }
      },
      verifyPasswordEqual () {
        if (this.payloadRegisterUser.password !== this.confirmpass) {
          return false
        } else {
          return true
        }
      },
      verifyPass () {
        if (this.payloadRegisterUser.password.length < 6) {
          return false
        } else {
          return true
        }
      },
      validateEmail () {
        const regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        if (regex.test(String(this.payloadRegisterUser.email).toLowerCase())) {
          return true
        } else {
          return false
        }
      },
      async onHandleRegisterProcess () {
        this.btnProcessing = true
        const response = await this.$serviceAuth.registerUser(this.payloadRegisterUser)
        if (response.status === 200) {
          this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
          this.closeDialogRegisterUser()
        } else {
          this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
          this.closeDialogRegisterUser()
        }
      },
      async redirectTo (item) {
        this.$router.push(item.href)
      },
      onHandleLogoutCancel () {
        this.logout = {
          stage: 0,
          dialog: false
        }
      },
      async onHandleLogoutProcess () {
        if (this.logout.stage === 0) {
          this.logout.stage = 1
          this.logout.dialog = true
          return false
        }
        if (this.logout.stage === 1) {
          this.logout.processing = true
          this.$store.dispatch('userSignOut')
          this.$router.push('/')
          this.logout.processing = false
          this.logout.stage = 0
          this.logout.dialog = false
        }
      },
      openToast ({ content }) {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content })
      },
      async sleep (timeout) {
        return new Promise(resolve => setTimeout(resolve, timeout))
      }
    },
    computed: {
      stateAuth () {
        return this.$store.getters.auth
      },
      statePage () {
        return { title: this.$route.meta.title }
      },
      disableFormBtn: function () {
        if (this.payloadRegisterUser.username !== '' && this.payloadRegisterUser.password !== '' && this.payloadRegisterUser.email !== '') {
          if (!this.validateEmail()) {
            return true
          }
          if (!this.verifyPass()) {
            return true
          }
          if (!this.verifyPasswordEqual()) {
            return true
          }
          if (!this.verifyemailequal()) {
            return true
          }
          return false
        } else {
          return true
        }
      }
    }
  }
</script>


<style>
@import url('https://fonts.googleapis.com/css?family=Quicksand');

body, html {
 font-family: 'Quicksand', sans-serif;
}

.alternative-text {
  padding: 10%;
}
#bar-chart {
  height: 100px;
  color:white;
}
#line-chart {
  height: 100px;
  color:white;
}
#pie-chart {
    height: 100px;

}
.alternative-card-top {
  background: rgba(0,0,0,0.8) ;
  color:white;
  min-height: 150px;
  margin-bottom: 10px;
}
.alternative-card-top:hover {
  background: rgba(0,0,0,0.9)
}

.alternative-card-major {
  background: rgba(218,0,0,0.8) ;
  color:white;
  min-height: 150px;
}
.alternative-card-major:hover {
  background: rgba(218,0,0,0.9) ;
}
h1,h2,h3,h4,h5,h6 {
   font-weight:normal;
}
/* .menu-selected {
 
} */
/* .menu-selected i {
} */
.application.theme--light {
  background: #fff;
  color: rgba(0,0,0,1);
}
.container-custom--top {
  background-color: #fff;
}
.radio-group--column {
  padding-top: 0;
}
</style>

<style scoped>
.options {
  min-width: 56px !important;
  padding-bottom: 15px !important;
}
</style>

<style>
html, body {
  margin: 0;
  overflow-y: hidden;
  overflow-x: hidden;
 
}

.container--menu .list-subheader {
  height: 20px;
  opacity: 0.8;
}
.toolbar-title {
  font-weight: none;
  overflow: visible;
      
}
.btn-logo-menu {
  width: 52px;
}
.card-logout-processing {
  position:absolute;
  background-color:#fff;
  opacity:0.7;
  width: 100%;
  top:0px;
  height:100%;
}
/* width */
::-webkit-scrollbar {
    width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
    background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #555; 
}
</style>
