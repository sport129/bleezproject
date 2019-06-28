<template>
  <v-app id="inspire">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <!-- top --> 
    <v-toolbar
      app
      dark
      fixed
      clipped-left
      clipped-right
      v-if="stateAuth.logged"
    >
      <!-- botão do menu -->

        <v-toolbar-side-icon @click=" stateMenu.visible=true">
          <v-icon style="color:white !important">reorder</v-icon>
        </v-toolbar-side-icon>

      <!-- *** --> 

      <!-- top info -->

        <img src="/static/img/logos/logo.png" alt="Logo" width="170"> 
        <v-flex xs1 style="margin-left:20px;"> 
          <v-toolbar-title
           class="toolbar-title ml-0" >{{ statePage.title }}
          </v-toolbar-title>
        </v-flex>
        <v-spacer></v-spacer>
        <v-btn icon @click="onHandleLogoutProcess()" style="color:white" >
          <v-icon>exit_to_app</v-icon>
        </v-btn>
      <!-- *** -->

    </v-toolbar>

  <!-- *** -->

  <!--  MENU -->
    <v-navigation-drawer
      fixed
      temporary
      v-model="stateMenu.visible"
      v-if="stateAuth.logged"
      class="bar-options"
      style="color:white; background:rgba(0,0,0,0.4)" 
      dark
    >
     
      <template>
        
         <!-- PERFIL MENU -->
        <v-list>
          <v-list-tile>
            <v-list-tile-avatar>
              <img src="/static/img/avatar/troll.png">
            </v-list-tile-avatar>
            <v-list-tile-content>
              <v-list-tile-title>{{stateAuth.client.name}}</v-list-tile-title>
              <v-list-tile-title style="font-size:8pt; margin-top:-5px;">{{stateAuth.client.email}}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </v-list>
      <!-- *** -->

        <v-list style="color:white">
          <template v-for="item in stateMenu.items">
            <v-divider v-if="item.divider" v-bind:inset="item.inset" :key="item.id"></v-divider>
            <v-list-tile v-else @click.stop="redirectTo(item)" :key="item.id" :class="item.selected?'menu-selected':''">
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title>{{ item.title }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
         
        </v-list>
      </template>
    </v-navigation-drawer>
    <!-- FIM MENU -->

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
      stateMenu: {
        visible: false,
        processing: true,
        items: [
          { id: 1, selected: true, icon: 'insert_chart', title: 'Dashboard', href: '/index' },
          //  { id: 2, selected: false, icon: 'perm_identity', title: 'Novo usuário', href: '/cadastros' },
          //  { id: 3, selected: false, icon: 'build', title: 'Limpar erros', href: '/dashboard' },
          { id: 3, selected: false, icon: 'error', title: 'Problem Report', href: '/reports' },
          { divider: true, inset: false }
        ]
      }
    }),
    methods: {
      closeDialog () {
        this.dialog = false
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: 'Usuário cadastrado com sucesso' })
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
          const response = await this.$serviceAuth.signOut()
          if (response.status === 200) {
            await this.sleep(1000)
            this.logout.processing = false
            this.openToast({ content: response.data.message })
            this.$store.dispatch('userSignOut')
            this.$router.push('/')
            this.logout = {
              stage: 0,
              dialog: false,
              processing: false
            }
          }
          if (response.status > 200) {
            await this.sleep(1000)
            this.logout.processing = false
            this.openToast({ content: response.data.message })
          }
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
