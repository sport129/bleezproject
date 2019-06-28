<template>
  <div>
    <v-navigation-drawer
      app
      left
      fixed
      clipped
      v-model="drawerLeft"
    >
      <template v-if="dataLeft.processing">
        <v-layout align-center justify-center column fill-height>
          <v-progress-circular
            :size="70"
            :width="7"
            color="white"
            indeterminate
            style="margin-top:100px;"
          ></v-progress-circular>
          <h3 class="mt-3">Buscando Informações ...</h3>
        </v-layout>
      </template>
      <template v-if="!dataLeft.processing">
        <v-list dense class="pt-3" v-if="!isFullScreenWindow">
          <section v-for="(type, i) in dataLeft.filters" :key="i" class="mb-3">
            <v-subheader class="mt-0 list-subheader">{{ type.label.toUpperCase() }}</v-subheader>
            <v-list dense class="pt-0">
              <v-list-tile 
                avatar 
                v-for="item in type.items"
                :key="item"
                @click=""
              >
                <v-list-tile-action style="min-width:30px">
                  <v-checkbox />
                </v-list-tile-action>
                <v-list-tile-content>
                  <v-list-tile-title>
                    {{ item.toUpperCase() }}
                  </v-list-tile-title>
                </v-list-tile-content>
              </v-list-tile>
            </v-list>
          </section>
        </v-list>
      </template>
    </v-navigation-drawer>

    <div class="rooms-container">
      <template v-if="dataContent.processing">
        <v-layout align-center justify-center column fill-height>
          <v-progress-circular
            :size="70"
            :width="7"
            color="white"
            indeterminate
          ></v-progress-circular>
          <h3 class="mt-3">Buscando Informações ...</h3>
        </v-layout>
      </template>
      <template v-if="!dataContent.processing">
        <v-card>
          <v-card-title class="pl-0 pr-0" v-if="dataContent.header.length > 0">
            <v-tooltip bottom>
              <v-btn icon slot="activator" @click.stop="onHandleChangeDahsboard(dataContent.current-1)">
                <v-icon>chevron_left</v-icon>
              </v-btn>
              <span>Item Anterior</span>
            </v-tooltip>
            <v-spacer></v-spacer>
            <span><h2 class="text-xs-center">{{ dataContent.header[dataContent.current] }} <br /> <small>TURNO MANHA</small></h2></span>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
              <v-btn icon slot="activator" @click.stop="onHandleChangeDahsboard(dataContent.current+1)">
                <v-icon>chevron_right</v-icon>
              </v-btn>
              <span>Próximo Item</span>
            </v-tooltip>
          </v-card-title>
          <v-divider></v-divider>
          <v-card-text>
            <section class="mb-4">
              <v-layout row wrap>
                <v-flex xs6 
                  v-for="(blockOfLessons, blockName) in dataContent.items[stateCurrentHeader]" 
                  :key="blockName" 
                  class="pr-4 mb-3"
                >
                  <v-layout>
                    <v-subheader class="rooms-subheader pl-0">BLOCO {{ blockName }}</v-subheader>
                  </v-layout>
                  <v-layout row wrap>
                    <v-flex 
                      xs2 
                      v-for="(lessonItem, j) in blockOfLessons" 
                      :key="j" 
                      class="rooms-item elevation-2"
                      :class="'room-item-'+lessonItem[0].room_code"
                    >
                      <v-layout column align-center>
                        <v-flex class="pt-2"><v-icon>room</v-icon></v-flex>
                        <v-flex style="font-size:12px;font-weight:bold">SALA {{ lessonItem[0].room_code }}</v-flex>
                        <v-flex style="font-size:11px;color:#ececec">COD: {{ lessonItem[0].discipline_code }}</v-flex>
                      </v-layout>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </v-layout>
            </section>
            <section>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:grey;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">NÃO TEM AULA ALOCADA</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:#d68624;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">AULA NÃO INICIADA</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:#1c1cec;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">AULA EM ANDAMENTO</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:#b70000;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">PROFESSOR FALTOU</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:green;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">AULA FINALIZADA COM SUCESSO</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:#520a52;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">AULA COM OCORRÊNCIA ACADÊMICA</v-flex>
              </v-layout>
              <v-layout row wrap>
                <v-flex xs1 style="flex-basis:30px!important">
                  <v-icon style="color:#131212;font-size:40px">stop</v-icon>
                </v-flex>
                <v-flex class="pt-2">AULA COM OCORRÊNCIA TÉCNICA</v-flex>
              </v-layout>
            </section>
          </v-card-text>
        </v-card>
      </template>
    </div>

    <v-fab-transition>
      <v-btn
        fab
        fixed
        dark
        right
        bottom
        color="primary"
        :style="!isFullScreenWindow?'bottom:90px;':''"
        @click.stop="onHandleFullScrenWindow()"
      >
        <v-icon>fullscreen</v-icon>
      </v-btn>
    </v-fab-transition>
    <v-fab-transition>
      <v-btn
        right
        fab
        dark
        fixed
        bottom
        color="primary"
        style="bottom:20px;"
        v-if="!isFullScreenWindow"
        @click.stop="onHandleChangeFilter(!drawerLeft)"
        @keyup.esc="myMethod"
      >
        <v-icon>menu</v-icon>
      </v-btn>
    </v-fab-transition>
  </div>
</template>
<script>
export default {
  name: 'AcademicTeacherOfflineDashboardIndex',
  data: () => ({
    dataLeft: {
      items: {},
      filters: {},
      processing: false
    },
    dataContent: {
      items: [],
      header: [],
      current: 0,
      processing: false
    },
    drawerLeft: false,
    isFullScreenWindow: false
  }),
  mounted () {
    this.prepareComponent()
  },
  methods: {
    async prepareComponent () {
      this.dataLeft.processing = true
      this.dataContent.processing = true
      const response = await this.$serviceFrequencyOffline.fetchData()
      if (response.data.status_code === 200) {
        this.dataLeft.filters = response.data.documents.filters
        this.dataContent.items = response.data.documents.lessons
        this.dataContent.header = Object.keys(response.data.documents.lessons)
      }
      await this.sleep(100)
      this.dataLeft.processing = false
      this.dataContent.processing = false
    },
    async onHandleChangeDahsboard (index) {
      const lengthItems = this.dataLeft.filters.affiliates.items.length
      if (index === -1) index = lengthItems - 1
      if (index === lengthItems) index = 0
      this.dataContent.current = index
      this.dataContent.processing = true
      await this.sleep(2000)
      this.dataContent.processing = false
    },
    async onHandleFullScrenWindow () {
      if (
        !document.fullscreenElement &&
        !document.mozFullScreenElement &&
        !document.webkitFullscreenElement &&
        !document.msFullscreenElement
      ) {
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen()
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen()
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen()
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(
            Element.ALLOW_KEYBOARD_INPUT
          )
        }
        this.drawerLeft = false
        this.isFullScreenWindow = true
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen()
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen()
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen()
        } else if (document.webkitExitFullscreen) {
          document.webkitExitFullscreen()
        }
        this.drawerLeft = true
        this.isFullScreenWindow = false
      }
    },
    async onHandleChangeFilter (value = false) {
      this.drawerLeft = value
    },
    async sleep (timeout) {
      return new Promise(resolve => setTimeout(resolve, timeout))
    }
  },
  computed: {
    stateAuth () {
      return this.$store.getters.auth
    },
    stateCurrentHeader () {
      return this.dataContent.header[this.dataContent.current]
    }
  }
}
</script>

<style scoped>
.border {
  border: 1px solid;
}
.rooms-container {
  height: 100vh;
  max-height: calc(100vh - 64px);
}
.rooms-subheader {
  font-size: 19px;
  font-weight: bold;
}
.rooms-item {
  height: 75px;
}
.room-item-004, .room-item-005 {
  background-color: #131212;
}

.room-item-001, .room-item-003, .room-item-006, .room-item-008 {
  background-color: #d68624;
}
.room-item-008 {
  background-color: #131212;
}
.room-item-002, .room-item-004, .room-item-005, .room-item-009, .room-item-010 {
  background-color: #1c1cec;
}
</style>


