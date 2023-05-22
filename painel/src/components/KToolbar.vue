 <template>
  <div class="k-toolbar" >
    <v-toolbar app  color="#e66c30" dark>
      <v-toolbar-side-icon @click="onClick"></v-toolbar-side-icon>

      <v-spacer></v-spacer>
      <div>Olá {{userName || ""}}</div>
      <v-btn flat @click="openDialog">
        <strong>Sair</strong>
      </v-btn>
    </v-toolbar>

    <v-dialog v-model="visibled" persistent max-width="290">
      <v-card>
        <v-card-text>Deseja sair do Painel ?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="black" flat @click="visibled = false">Cancelar</v-btn>
          <v-btn color="blue" flat @click="closeSession">Sim</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
 
 <script>
export default {
  name: "k-toolbar",
  props: {
    userName: {
      type: String
    }
  },
  data() {
    return {
      visibled: false,
      clicked: false
    };
  },
  methods: {
    openDialog() {
      this.visibled = true;
    },
    closeSession() {
      this.visibled = false;
      this.$emit("logout");
    },
    onClick(){
      this.clicked = !this.clicked
        this.$emit("onClick", this.clicked);
    }
  }
};
</script>
 
 <style style="scss" scoped>
</style>
 