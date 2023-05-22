<template>
  <div class="k-lista-cliente">
    <v-card class="card">
      <v-card-title>
        <h2>Clientes</h2>
        <v-spacer></v-spacer>
        <v-btn @click="incluir" color="success">Incluir</v-btn>
      </v-card-title>
    </v-card>
    <v-card class="card">
      <v-card-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Pesquisar"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table lazy :headers="headers" :items="desserts" :search="search" :loading="loading">
        <template v-slot:items="props">
          <td>{{ props.item.nome }}</td>
          <td class="justify-center layout px-0">
            <v-icon class="mr-2" color="info" @click="editItem(props.item)">edit</v-icon>
            <v-icon color="red" @click="deleteItem(props.item, props)">delete</v-icon>
            <v-btn color="primary" small @click="modalEndereco(props.item)">+ Endereço</v-btn>
          </td>
        </template>

        <template v-slot:no-results>
          <v-alert
            :value="true"
            color="error"
            icon="warning"
          >Sua pesquisa por "{{ search }}" não retornou resultados.</v-alert>
        </template>

        <template v-slot:no-data>
          <div class="sem-dados">Nenhum cliente cadastrado :(</div>
        </template>
      </v-data-table>

      <v-dialog v-model="visibled" persistent max-width="290">
        <v-card>
          <v-card-text>Deseja excluir esse cliente ?</v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="black" flat @click="visibled = false">Não</v-btn>
            <v-btn color="blue" flat @click="confirmacaoExclusao">Sim</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>

    <k-editar-cliente v-model="showModalEditarCliente" :item="item" @editSucess="onEditItem"/>
    <k-endereco-cliente v-show="showModalEndereco" v-model="showModalEndereco" :itemCliente="item"/>
  </div>
</template>

<script>
import ServiceCliente from "../services/Cliente";
import VueRouter from "vue-router";
import EditarCliente from "./EditarCliente";
import EnderecoCliente from "./EnderecoCliente";
import LocalStorage from "../utils/LocalStorage";

export default {
  name: "k-lista-cliente",
  components: {
    EditarCliente,
    EnderecoCliente
  },
  data() {
    return {
      search: "",
      clientes: [],
      headers: [
        {
          text: 'Nome',
          value: "nome"
        },
        { text: "Ações", value: "name", sortable: false }
      ],
      desserts: [],
      visibled: false,
      itemExclusao: null,
      showModalEditarCliente: false,
      item: null,
      showModalEndereco: false,
      enderecos: null,
      sessionUser: LocalStorage.get("SESSION_KABUM") || { token: "" }
    };
  },
  methods: {
    incluir() {
      this.$router.push("/cadClientes");
    },
    editItem(item) {
      this.item = item;
      this.showModalEditarCliente = true;
    },
    deleteItem(item) {
      this.visibled = true;
      this.itemExclusao = item;
    },
    confirmacaoExclusao() {
      ServiceCliente.removerCliente(this.itemExclusao.id).then(response => {
        const { status, message } = response.data;

        if (status != "NOT_FOUND") {
          this.visibled = false;

          this.loadList();

          this.itemExclusao = null;
        } else {
          alert(message);
        }
      });
    },
    loadList() {
      const { usuarioid } = this.sessionUser.session;

      if (!usuarioid) {
        this.$router.push("/");
        return false;
      }

      this.loading = true;
      ServiceCliente.listAll(usuarioid).then(response => {
        const { clientes, message } = response.data;

        this.desserts = [];
        this.desserts = clientes;
        this.loading = false;
        if (response.data.status === "ERROR") {
          alert(message || "Erro ao carregar clientes");
          return false;
        }
      });
    },
    onEditItem(data) {
      this.loadList();
    },
    modalEndereco(item) {
      this.item = item;
      this.showModalEndereco = true;
    }
  },
  created() {
    this.loadList();
  }
};
</script>

<style style="css">
.card {
  margin: 20px;
}

.sem-dados {
  color: #ff0000;
  text-align: center;
}
</style>
