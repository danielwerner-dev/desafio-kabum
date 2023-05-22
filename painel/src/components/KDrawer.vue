<template>
    <div class="k-drawer">
        <v-navigation-drawer app v-model="drawer">
            <v-card  flat class="transparent">
                    <v-toolbar  color="#e66c30">
                        <img class="logo" src="../assets/logo.png"/>
                    </v-toolbar>
                    <v-list class="list-item">
                        <v-list-tile v-for="item in items" :key="item.title" @click="onClick(item)">
                            <v-list-tile-action>
                                <v-icon>{{ item.icon }}</v-icon>
                            </v-list-tile-action>

                            <v-list-tile-content>
                                <v-list-tile-title>{{ item.title }} </v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
            </v-card>
        </v-navigation-drawer>
    </div>
</template>

<script>
import VueRouter from 'vue-router'
export default {
    name: "k-drawer",
    props: {
        value: Boolean
    },
    watch: {
        value(newValue){
           this.drawer = newValue
        },
        drawer(newValue){
            this.$emit('input', newValue)
        }
    },
    data () {
        return {
            items: [
                { title: 'Clientes', icon: 'face' }
            ],
            drawer: true
        }
    },
    methods: {
        onClick(item) {
            if(item.title == "Clientes") {
               this.$router.push('/listaCliente')
            }
        }
    }
}
</script>

 <style style="scss" scoped>
    .logo {
      width: 130px;
      padding: 5px;
    }
    .list-item {
      margin-top: 20px;
    }
 </style>
