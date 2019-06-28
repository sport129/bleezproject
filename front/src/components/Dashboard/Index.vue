<template>
  <v-container grid-list-md text-xs-center>
    <v-layout row wrap>
      <v-flex>
          <template>
            {{listagemProducts}}
            <v-data-table
              :headers="headersTable"
              :items="listagemProducts"
              class="elevation-1"
            >
              <template v-slot:items="props">
                {{props}}
                <td class="text-xs-right">{{ props }}</td>
                <!-- <td class="text-xs-right">{{ props.item.calories }}</td>
                <td class="text-xs-right">{{ props.item.fat }}</td>
                <td class="text-xs-right">{{ props.item.carbs }}</td>
                <td class="text-xs-right">{{ props.item.protein }}</td>
                <td class="text-xs-right">{{ props.item.iron }}</td> -->
              </template>
            </v-data-table>
          </template>
      </v-flex>
    </v-layout>                           
  </v-container>
</template>

<script>
export default {
  data () {
    return {
      listagemProducts: [],
      headersTable: [
        {text: 'Id Produto', align: 'left', value: 'id'},
        {text: 'Nome do Produto', align: 'left', value: 'nome'},
        {text: 'Preço do Produto', align: 'left', value: 'preco'},
        {text: 'Descrição do Produto', align: 'left', value: 'descricao'},
        {text: 'Imagem', align: 'left', value: 'imagem'},
        {text: 'Cadastrado no Dia', align: 'left', value: 'created_at'}
      ]
    }
  },
  mounted () {
    this.$axios.defaults.headers.common['Authorization'] = `Bearer ${this.$store.state.auth.credentials.token}`
    this.prepareComponent()
  },
  methods: {
    async prepareComponent () {
      const response = await this.$serviceAuth.getProducts()
      if (response.status === 200) {
        this.listagemProducts = response.data.documents
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      } else {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      }
    }
  }
}
</script>