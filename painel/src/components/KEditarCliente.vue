<template>
  <div class="k-editar-cliente">
    <v-layout row justify-center>
      <v-dialog max-width="600px" v-model='modal'>
        <v-card>
          <v-card-title>
            <span class="headline">Editar Cliente</span>
          </v-card-title>

          <v-form ref="form" v-model="valid">
            <v-container>
              <v-layout row wrap>
                <v-flex xs12 md12>
                  <v-text-field
                    v-model="nome"
                    :rules="nameRules"
                    label="Nome"
                    :maxLength="70"
                    required
                  ></v-text-field>
                </v-flex>
                <v-flex xs12 md6>
                  <v-text-field v-model="dataNascimento" label="Data de Nascimento"></v-text-field>
                </v-flex>
                <v-flex xs12 md6>
                  <v-text-field v-model="telefone" label="Telefone" mask="(##) ####-#####"></v-text-field>
                </v-flex>
                <v-flex xs12 md4>
                  <v-text-field v-model="celular" label="Celular" mask="(##) #####-####"></v-text-field>
                </v-flex>
                <v-flex xs12 md4>
                  <v-text-field v-model="cpf" label="CPF" mask="###.###.###-##"></v-text-field>
                </v-flex>
                <v-flex xs12 md4>
                  <v-text-field v-model="rg" label="RG" :maxLength="10"></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
          </v-form>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="closeModal">Fechar</v-btn>
            <v-btn color="orange darken-1" flat @click="editar">Editar</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </div>
</template>

<script>
import ServiceCliente from "../services/Cliente"

export default {
  name: "k-editar-cliente",
  props: {
    value: {
      type: Boolean
    },
    item: {
      type: Object
    }
  },
  watch:{
    value(newValue){
      this.modal = newValue
    },
    modal(newValue){
      this.$emit('input', newValue)
    },
    item(newItem){
      this.clienteID = this.item.id
      this.nome = this.item.nome
      this.dataNascimento = this.item.datanascimento
      this.telefone = this.item.telefone
      this.celular = this.item.celular
      this.cpf = this.item.cpf
      this.rg = this.item.rg
    }
  },
  data() {
    return {
      nameRules: [v => !!v || "Nome é é obrigatório"],
      nome: null,
      dataNascimento: null,
      telefone: null,
      celular: null,
      cpf: null,
      rg: null,
      clienteID: null,
      disabled: true,
      valid: true,
      modal: false
    }
  },
  methods: {
    editar(){
      ServiceCliente.editarCliente(this.clienteID, {
          nome: this.nome,
          datanascimento: this.dataNascimento,
          cpf: this.cpf,
          rg: this.rg,
          telefone: this.telefone,
          celular: this.celular
        }).then(response => {
          const { status, message } = response.data

        if (status == "USER_NOT_EXISTS" || status == "USER_EXISTS") {
            alert(message)
            return false
        }

        if (status == "SUCCESS") {
          this.modal = false
          this.$emit("editSucess", response.data);
        } else {
          alert("Erro ao editar Cliente. \n Por favor entre em contato com o administrador!")
          return false;
        }
      })
    },
    closeModal(){
      this.modal = false
    }
  }
}
</script>

<style>
</style>
