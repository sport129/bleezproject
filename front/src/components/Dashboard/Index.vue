<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-flex>
          <h2 class="mb-5 text-xs-center">Lista de Produtos Cadastrados</h2>
          <template>
            <v-data-table
              :headers="headers"
              :items="listagemProducts"
              class="elevation-1"
            >
              <template slot="items" slot-scope="props">
                <td>{{props.item.id}}</td>
                <td>{{props.item.nome}}</td>
                <td>{{props.item.preco}}</td>
                <td>{{props.item.descricao}}</td>
                <td class="text-xs-center">
                  <v-btn icon small color="primary" dark @click="addImgae(props.item)">
                    <v-icon>wallpaper</v-icon>
                  </v-btn>
                </td>
                <td>{{props.item.created_at}}</td>
                <td class="text-xs-center">
                  <v-btn icon small color="secondary" dark @click="editProduct(props.item)">
                    <v-icon>settings</v-icon>
                  </v-btn>
                </td>
                <td class="text-xs-center">
                  <v-btn icon small color="red" dark @click="openDialogExclude(props.item)">
                    <v-icon>remove_circle</v-icon>
                  </v-btn>
                </td>
              </template>
            </v-data-table>
          </template>
      </v-flex>

      <v-flex>
        <v-btn icon dark color="primary" small @click="dialogNewProduct = true">
          <v-icon>add</v-icon>
        </v-btn>
        Cadastrar Novo Produto
      </v-flex>

      <v-dialog
        v-model="modalEditProduct"
        width="600"
        persistent
      >
        <v-card>
          <v-card-title
            class="headline lighten-2 white--text"
            primary-title
            style="background-color: #582EFF !important;"
          >
            Editar Produto
            <v-spacer></v-spacer>
            <v-btn icon dark @click="closeDialogUpdate()">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            <v-text-field
              v-model="productSelected.id"
              label="Id Do Produto"
              :disabled="disableText"
            >
            </v-text-field>
            <v-text-field
              v-model="productSelected.nome"
              label="Nome Do Produto"
            >
            </v-text-field>
            <v-text-field
              v-model="productSelected.preco"
              label="Preço Do Produto"
              :rules="[() => verificatorNumberBank() || 'Valor Digitado Errado']"
            >
            </v-text-field>
            <v-text-field
              v-model="productSelected.descricao"
              label="Descrição Do Produto"
            >
            </v-text-field>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="success" @click="atualizarProduto()" :loading="btnProcessing" :disabled="disableFormBtn">
              Atualizar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

      <v-dialog
        v-model="dialogExcludProduct"
        width="400"
        persistent
      >
        <v-card-title
          class="headline lighten-2 white--text"
          primary-title
          style="background-color: #582EFF !important;"
        >
          Excluir Produto
        </v-card-title>
        <v-card-text class="text-xs-center" style="background-color: white;">
          Você Tem Certeza que Quer Excluir Esse Produto?
        </v-card-text>
        <v-card-actions style="background-color: white;"> 
          <v-btn color="primary" @click="prepareComponent">
            Cancelar
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn color="error" @click="excluirProduto" :loading="btnexcluir">
            Excluir
          </v-btn>
        </v-card-actions>
      </v-dialog>

      <v-dialog
        v-model="dialogNewProduct"
        width="600"
        persistent
      >
        <v-card>
          <v-card-title
            class="headline grey lighten-2 white--text"
            primary-title
            style="background-color: #582EFF !important;"
          >
            Cadastrar Novo Produto
            <v-spacer></v-spacer>
            <v-btn icon dark @click="prepareComponent">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-card-text>
            </v-text-field>
            <v-text-field
              v-model="newProduct.nome"
              label="Nome Do Produto"
            >
            </v-text-field>
            <v-text-field
              v-model="newProduct.preco"
              label="Preço Do Produto"
              :rules="[() => verificatorNumberBank() || 'Valor Digitado Errado']"
            >
            </v-text-field>
            <v-text-field
              v-model="newProduct.descricao"
              label="Descrição Do Produto"
            >
            </v-text-field>
            <div>
              <input 
                multiple
                hidden
                id="fileAttachments"
                ref="attachments"
                type="file" 
                @change="onHandleAddedAttachments()" 
              >
            </div>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="success" @click="cadastrarProduto()" :loading="btnProcessing" :disabled="disableFormBtn">
              Cadastrar Produto
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>


      <v-dialog 
        v-model="modalUploadImagProduct"
        width="600"
        persistent
      >
        <v-card>
          <v-card-title
            class="headline grey lighten-2 white--text"
            primary-title
            style="background-color: #582EFF !important;"
          >
            Imagems do Produto
            <v-spacer></v-spacer>
            <v-btn icon dark  @click="adicionarImagem()">
              <v-icon>add</v-icon>
            </v-btn>
            <v-btn icon dark  @click="prepareComponent">
              <v-icon>close</v-icon>
            </v-btn>
          </v-card-title>
          <v-container
            fluid
            grid-list-xs
          > 
            <v-layout row wrap>
              <v-flex xs12 v-if="imageSelected === ''">
                <v-card>
                  <v-flex xs12>
                    <div style="font-size: 14px;">
                    <h2><center>NÃO EXISTE IMAGEM CADASTRADAS A ESSE PRODUTO</center></h2>
                    </div>
                  </v-flex>
                </v-card>
              </v-flex>
              <v-flex xs12 v-else class="text-xs-center" >
                <v-container
                  fluid
                  grid-list-xs
                > 
                <v-layout row wrap>
                  <v-flex xs4 v-for="img in imageSelected">
                    <v-card hover>
                      <img :src="img.linkimg" width="150" @click="zoomimg(img.linkimg)"/>
                    </v-card>
                  </v-flex>
                </v-layout>
                </v-container>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>
      </v-dialog>

      <v-dialog
        v-model="zoomImgDialog"
        width="900"
      >
        <v-card-title
          class="headline grey lighten-2"
          primary-title
        >
          <v-btn icon dark color="primary" @click="zoomImgDialog = false, imgZoomLink = ''">
              <v-icon>close</v-icon>
            </v-btn>
        </v-card-title>
        <v-card class="text-xs-center">
          <img :src="imgZoomLink" width="80%"/>
        </v-card>
      </v-dialog>
    </v-layout>                           
  </v-container>
</template>

<script>
export default {
  data () {
    return {
      listagemProducts: [],
      headers: [
        {text: 'Id Produto', align: 'center', value: 'id', sortable: false},
        {text: 'Nome do Produto', align: 'center', value: 'nome', sortable: false},
        {text: 'Preço do Produto', align: 'center', value: 'preco', sortable: false},
        {text: 'Descrição do Produto', align: 'center', value: 'descricao', sortable: false},
        {text: 'Visualizar Imagem', align: 'center', value: 'imagem', sortable: false},
        {text: 'Cadastrado no Dia', align: 'center', value: 'created_at', sortable: false},
        {text: 'Editar Produto', align: 'center', value: 'edit', sortable: false},
        {text: 'Excluir Produto', align: 'center', value: 'excluir', sortable: false}
      ],
      modalUploadImagProduct: false,
      newProduct: {
        nome: '',
        preco: '',
        descricao: '',
        imagem: new FormData()
      },
      files: '',
      modalEditProduct: false,
      dialogExcludProduct: false,
      productSelected: [],
      btnProcessing: false,
      dialogNewProduct: false,
      disableText: true,
      imageSelected: [],
      zoomImgDialog: false,
      imgZoomLink: '',
      btnexcluir: false
    }
  },
  mounted () {
    this.$axios.defaults.headers.common['Authorization'] = `Bearer ${this.$store.state.auth.credentials.token}`
    this.prepareComponent()
  },
  methods: {
    async addImgae (item) {
      const response = await this.$serviceAuth.getImages(item)
      if (response.status === 200) {
        this.productSelected = item
        this.imageSelected = response.data.documents
        this.modalUploadImagProduct = true
      } else {
        this.productSelected = item
        this.imageSelected = ''
        this.modalUploadImagProduct = true
      }
    },
    async prepareComponent () {
      this.productSelected = []
      this.modalEditProduct = false
      this.listagemProducts = []
      this.btnProcessing = false
      this.dialogExcludProduct = false
      this.dialogNewProduct = false
      this.modalUploadImagProduct = false
      this.imageSelected = []
      this.btnexcluir = false
      this.newProduct = {
        nome: '',
        preco: '',
        descricao: '',
        imagem: new FormData()
      }
      const response = await this.$serviceAuth.getProducts()
      if (response.status === 200) {
        this.listagemProducts = response.data.documents
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      } else {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      }
    },
    async onHandleAddedAttachments () {
      const regex = /image/
      this.files = this.$refs.attachments.files
      for (let key in this.files) {
        if (regex.test(this.files[key].type)) {
          this.newProduct.imagem.append('file', this.files[key])
          this.newProduct.imagem.append('dados', JSON.stringify({produto: this.productSelected}))
          await this.$serviceAuth.upimagem(this.newProduct.imagem)
          this.newProduct.imagem = new FormData()
        } else {
          this.newProduct.imagem = new FormData()
        }
      }
      this.addImgae(this.productSelected)
      // this.newProduct.imagem.append('dados', JSON.stringify({produto: this.productSelected}))
    },
    async editProduct (produto) {
      const response = await this.$serviceAuth.getProduct(produto)
      if (response.status === 200) {
        this.productSelected = response.data.documents
        this.modalEditProduct = true
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      } else {
        this.modalEditProduct = false
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
      }
    },
    async adicionarImagem () {
      document.getElementById('fileAttachments').click()
    },
    async atualizarProduto () {
      const response = await this.$serviceAuth.attProduct(this.productSelected)
      if (response.status === 200) {
        this.btnProcessing = true
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.prepareComponent()
        }, 2000)
      } else {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.btnProcessing = true
          this.prepareComponent()
        }, 2000)
      }
    },
    async excluirProduto () {
      this.btnexcluir = true
      const response = await this.$serviceAuth.deletProduct(this.productSelected)
      if (response.status === 200) {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.prepareComponent()
        }, 1000)
      } else {
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.prepareComponent()
        }, 1000)
      }
    },
    async cadastrarProduto () {
      const response = await this.$serviceAuth.novoProduto(this.newProduct)
      if (response.status === 200) {
        this.btnProcessing = true
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.prepareComponent()
        }, 1000)
      } else {
        this.btnProcessing = true
        this.$store.dispatch('setToast', { color: 'white', visible: true, content: response.data.message })
        setTimeout(() => {
          this.btnProcessing = false
        }, 1000)
      }
    },
    async onHandleOpenDialogToAddFiles () {
      document.getElementById('fileAttachments').click()
    },
    verificatorNumberBank () {
      const regex = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,2})?)$/
      if (regex.test(this.newProduct.preco) || regex.test(this.productSelected.preco)) {
        return true
      } else {
        return false
      }
    },
    openDialogExclude (produto) {
      this.dialogExcludProduct = true
      this.productSelected = produto
    },
    zoomimg (img) {
      this.imgZoomLink = img
      this.zoomImgDialog = true
    },
    closeDialogUpdate () {
      this.prepareComponent()
    }
  },
  computed: {
    disableFormBtn: function () {
      if ((this.newProduct.nome !== '' && this.newProduct.preco !== '' && this.newProduct.descricao !== '') || (this.productSelected.nome !== '' && this.productSelected.preco !== '' && this.productSelected.descricao !== '')) {
        if (!this.verificatorNumberBank()) {
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