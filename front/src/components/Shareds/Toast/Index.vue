<template>
  <div>
    <v-snackbar
      v-model="stateToast.visible"
      :bottom="stateToast.y === 'bottom'"
      :left="stateToast.x === 'left'"
      :multi-line="stateToast.mode === 'multi-line'"
      :right="stateToast.x === 'right'"
      :timeout="stateToast.timeout"
      :top="stateToast.y === 'top'"
      :vertical="stateToast.mode === 'vertical'"
      :color="stateToast.color === 'black' ? 'black white--text' : 'white black--text'"
    >
      {{ stateToast.content }}
      <v-btn
        flat
        :color="stateToast.color === 'black' ? 'white' : 'black'"
        @click="onHandleClose()"
      >
        <v-icon>close</v-icon>
      </v-btn>
    </v-snackbar>
  </div>
</template>

<script>
  export default {
    data: () => ({
    }),
    methods: {
      onHandleClose () {
        this.$store.dispatch('setToast', { visible: false, content: '' })
      }
    },
    computed: {
      stateToast () {
        return this.$store.getters.toast
      }
    }
  }
</script>