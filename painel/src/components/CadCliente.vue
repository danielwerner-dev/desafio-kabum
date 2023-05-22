<template >
  <div class="k-cad-cliente">
    <v-card class="card">
      <v-card-title>
        <h2>Clientes</h2>
        <v-spacer></v-spacer>
        <v-btn @click="voltar" color="error">
          <v-icon dark left>arrow_back</v-icon>Voltar
        </v-btn>
        <v-btn @click="salvarCliente" color="success" :disabled="disabled">Salvar Cliente</v-btn>
      </v-card-title>

      <v-form ref="form" v-model="valid">
        <v-container>
          <v-layout row wrap>
            <v-flex xs12 md6>
              <v-text-field v-model="nome" :rules="nameRules" label="Nome" :maxLength="70" required></v-text-field>
            </v-flex>
            <v-flex xs12 md3>
              <v-flex xs11>
                <v-menu
                  ref="menu"
                  v-model="menu"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="dataNascimento"
                  lazy
                  transition="scale-transition"
                  offset-y
                  full-width
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="dateFormated"
                      label="Data de Nascimento"
                      prepend-icon="event"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-date-picker v-model="date" type="date" locale="pt-br">
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="menu = false">Cancel</v-btn>
                    <v-btn flat color="primary" @click="$refs.menu.save(date)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-flex>
            </v-flex>
            <v-flex xs12 md3>
              <v-text-field v-model="telefone" label="Telefone" mask="(##) ####-####"></v-text-field>
            </v-flex>
          </v-layout>
          <v-layout>
            <v-flex xs12 md3>
              <v-text-field v-model="celular" label="Celular" mask="(##) #####-####"></v-text-field>
            </v-flex>
            <v-flex xs12 md5>
              <v-text-field v-model="cpf" label="CPF" mask="###.###.###-##"></v-text-field>
            </v-flex>
            <v-flex xs12 md4>
              <v-text-field v-model="rg" label="RG" :maxLength="10"></v-text-field>
            </v-flex>
          </v-layout>
        </v-container>
      </v-form>
    </v-card>
  </div>
</template>

<script>
import ServiceCliente from "../services/Cliente";
import LocalStorage from "../utils/LocalStorage";
import moment from 'moment'

export default {
  name: "k-cad-cliente",
  props: {
    userID: {
      type: String
    }
  },
  data() {
    return {
      nome: null,
      dataNascimento: new Date("1993-12-08").toISOString().substr(0, 10),
      telefone: null,
      celular: null,
      cpf: null,
      rg: null,
      nameRules: [v => !!v || "Nome é é obrigatório"],
      disabled: true,
      valid: true,
      clienteID: null,
      sessionUser: LocalStorage.get("SESSION_KABUM") || { token: "" },
      date: null,
      menu: false,
      modal: false
    };
  },
  watch: {
    nome(newValue) {
      if (newValue.length > 0) {
        this.disabled = false;
      }
    }
  },
  methods: {
    salvarCliente() {
      const { usuarioid } = this.sessionUser.session;

      if (!usuarioid) {
        this.$router.push("/");
        return false;
      }

      if (this.validate()) {
        ServiceCliente.cadCliente({
          nome: this.nome,
          datanascimento: this.dataNascimento,
          cpf: this.cpf,
          rg: this.rg,
          telefone: this.telefone,
          celular: this.celular,
          usuarioid: usuarioid
        }).then(response => {
          const { message, status, id } = response.data;

          if (status == "SUCCESS" && id != null) {
            this.resetForm();
            this.clienteID = id;
            this.$router.push("/ListaCliente");

            return false;
          } else if (status == "REQUIRED_VALUE" || status == "CLIENTE_EXISTS") {
            alert(message);
            return false;
          } else {
            alert(message || "Erro ao cadastrar cliente!");
            return false;
          }
        });
      }
    },
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }

      return this.snackbar;
    },
    voltar() {
      this.$router.push("/ListaCliente");
    },
    resetForm() {
      this.nome = this.nome;
      this.dataNascimento = null;
      this.cpf = null;
      this.rg = null;
      this.telefone = null;
      this.celular = null;
      this.usuarioid = null;
    }
  },
   computed: {
    dateFormated() {
      return moment(this.dataNascimento).format('DD/MM/YYYY');
    }
  }
};
</script>

<style>
.card {
  margin: 20px;
  padding: 15px;
}

.card-children {
  margin: 5px;
  padding: 0 20px 0 20px;
}
</style>
