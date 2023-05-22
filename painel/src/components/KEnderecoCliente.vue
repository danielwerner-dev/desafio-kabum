<template>
  <div class="k-endereco-cliente">
    <v-layout row justify-center>
      <v-dialog max-width="600px" v-model="modal">
        <v-card>
          <v-card-title primary-title>
            <div>
              <div class="headline">Endereço</div>
              <span class="grey--text">
                de
                <strong>{{this.nomeCliente}}</strong>
              </span>
            </div>
          </v-card-title>

          <v-form ref="formEndereco" v-model="valid">
            <v-container>
              <v-layout row wrap>
                <v-flex xs12 md10>
                  <v-text-field label="Endereço" v-model="endereco" required :rules="enderecoRules"></v-text-field>
                </v-flex>
                <v-flex xs12 md2>
                  <v-text-field
                    label="Número"
                    v-model="numero"
                    required
                    :rules="numeroRules"
                    maxlength="5"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 md8>
                  <v-text-field label="Bairro" v-model="bairro" required :rules="bairroRules"></v-text-field>
                </v-flex>
                <v-flex xs12 md4>
                  <v-text-field
                    label="CEP"
                    v-model="cep"
                    required
                    :rules="cepRules"
                    mask="#####-###"
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 md4>
                  <v-select
                    v-model="selectEstado"
                    :items="listaEstados"
                    item-text="text"
                    item-value="value"
                    label="Estado"
                  ></v-select>
                </v-flex>
                <v-flex xs12 md6>
                  <v-select
                    v-model="selectCidade"
                    :items="listaCidades"
                    item-text="text"
                    item-value="value"
                    label="Cidades"
                  ></v-select>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn v-if="!rowSelectedid" color="success" dark flat @click="salvar">Salvar</v-btn>
            <v-btn v-if="rowSelectedid" color="info" dark flat @click="resetData">Limpar</v-btn>
            <v-btn v-if="rowSelectedid" color="error" dark flat @click="editar">Editar</v-btn>
          </v-card-actions>

          <v-card>
            <v-data-table :headers="headers" :items="enderecos" :search="search">
              <template v-slot:items="props">
                <tr @click="selectRow(props.item)">
                  <td>{{ props.item.endereco }}</td>
                  <td>{{ props.item.numero }}</td>
                  <td>{{ props.item.bairro }}</td>
                  <td class="justify-center layout px-0">
                    <v-icon color="red" @click="excluir(props.item)">delete</v-icon>
                  </td>
                </tr>
              </template>
            </v-data-table>
            <template v-slot:no-results>
              <v-alert
                :value="true"
                color="error"
                icon="warning"
              >Sua pesquisa por "{{ search }}" não retornou resultados.</v-alert>
            </template>
          </v-card>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
import ServiceClienteEndereco from "../services/ClienteEndereco";
import ServiceEstado from "../services/Estado";
import ServiceCidade from "../services/Cidade";

export default {
  name: "k-endereco-cliente",
  props: {
    value: {
      type: Boolean
    },
    itemCliente: {
      type: Object
    }
  },
  data() {
    return {
      modal: false,
      valid: false,
      search: "",
      clientes: [],
      headers: [
        { text: "Endereço", value: "endereco" },
        { text: "Número", value: "numero" },
        { text: "Bairro", value: "bairro" },
        { text: "Ações", value: "name", sortable: false }
      ],
      enderecos: [],
      dadosCliente: null,
      nomeCliente: null,
      enderecoRules: [v => !!v || "Endereço é obrigatório"],
      numeroRules: [v => !!v || "Número é obrigatório"],
      bairroRules: [v => !!v || "Bairro é obrigatório"],
      cepRules: [v => !!v || "CEP é obrigatório"],
      endereco: null,
      numero: null,
      bairro: null,
      cep: null,
      rowSelectedid: null,
      selectEstado: null,
      selectCidade: null,
      listaEstados: [],
      listaCidades: []
    };
  },
  watch: {
    value(newValue) {
      this.modal = newValue;
    },
    modal(newValue) {
      this.$emit("input", newValue);
      this.$emit("openModal", newValue);
      this.dadosCliente = this.itemCliente;

      if (!newValue) {
        this.resetData();
      }
    },
    itemCliente(newItem, oldItem) {
      this.nomeCliente = this.itemCliente.nome;
      this.loadList();

      ServiceEstado.listAll().then(response => {
        this.listaEstados = response.data.estados;
      });
    },
    selectEstado(newValue) {
      ServiceCidade.listAll(newValue).then(response => {
        this.listaCidades = response.data.cidades;
      });
    }
  },
  methods: {
    salvar() {
      if (this.validate()) {
        ServiceClienteEndereco.cadEnderecoCliente({
          endereco: this.endereco,
          numero: this.numero,
          cep: this.cep,
          bairro: this.bairro,
          clienteid: this.dadosCliente.id,
          cidadeid: this.selectCidade,
          estadoid: this.selectEstado
        })
          .then(response => {
            const { id, message } = response.data;
            if (id != null) {
              this.loadList();
              this.resetData();
            }
          })
          .catch((e, a, b) => {
            alert("Erro ao salvar endereco!");
            return false;
          });
      }
    },
    editar() {
      ServiceClienteEndereco.editarEnderecoCliente(this.rowSelectedid, {
        endereco: this.endereco,
        numero: this.numero,
        cep: this.cep,
        bairro: this.bairro,
        cidadeid: this.selectCidade,
        estadoid: this.selectEstado
      })
        .then(response => {
          this.resetData();
          this.loadList();
        })
        .catch((e, a, b) => {
          alert("Erro ao editar endereço!");
          return false;
        });
    },
    excluir(item) {
      ServiceClienteEndereco.removerEnderecoCliente(item.id).then(response => {
        this.resetData();
        this.loadList();
      });
    },
    resetData() {
      this.endereco = null;
      this.cep = null;
      this.numero = null;
      this.bairro = null;
      this.rowSelectedid = null;
      (this.selectEstado = null), (this.selectCidade = null);
    },
    closeModal() {
      this.modal = false;
      this.resetData();
    },
    validate() {
      if (this.$refs.formEndereco.validate()) {
        this.snackbar = true;
      }

      return this.snackbar;
    },
    loadList() {
      ServiceClienteEndereco.listAll(this.itemCliente.id).then(response => {
        const { enderecos, message } = response.data;
        this.enderecos = enderecos;

        if (response.data.status === "ERROR") {
          alert(message || "Erro ao carregar endereço");
          return false;
        }
      });
    },
    selectRow(item) {
      this.rowSelectedid = item.id;
      this.endereco = item.endereco;
      this.cep = item.cep;
      this.numero = item.numero;
      this.bairro = item.bairro;
      (this.selectEstado = item.estadoid), (this.selectCidade = item.cidadeid);
    }
  }
};
</script>

<style>
</style>
