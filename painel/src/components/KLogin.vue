<template>
    <div class="k-login">
        <v-app>
            <v-content>
                <v-container fluid class="content-login">
                    <v-layout row justify-center >
                        <v-flex xs12 sm10 md3 >
                            <v-card class="box-logo text-xs-center text-sm-center text-md-center">
                                <img class="logo" src="../assets/logo.png"/>
                            </v-card>
                            <v-card class="login">
                                <v-form ref="form" v-model="valid">
                                    <v-text-field
                                    v-model="login"
                                    :rules="rules"
                                    name="login"
                                    label="Login"
                                    hint="Digite pelo menos 3 caracteres."
                                    />

                                    <v-text-field
                                    v-model="password"
                                    :append-icon="show1 ? 'visibility' : 'visibility_off'"
                                    :rules="rules"
                                    type="Password"
                                    name="password"
                                    label="Senha"
                                    hint="Digite pelo menos 3 caracteres."
                                    :disabled="disabledInputSenha"
                                    max-lengh
                                    />
                                </v-form>
                                    <div>
                                        <v-btn @click="authenticate"
                                        class="btn-entrar"
                                        block
                                        color="secondary"
                                        :disabled="disabledButton">
                                            Entrar
                                        </v-btn>
                                    </div>
                                    <v-alert
                                        :value="showError"
                                        type="error"
                                        transition="scale-transition"
                                    >
                                        Login ou senha inválido!
                                    </v-alert>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
    </div>
</template>

<script>
import ServiceLogin from '../services/Login'
import LocalStorage from '../utils/LocalStorage'
import VueRouter from 'vue-router'

export default {
    name: "k-login",
    data () {
        return {
            valid: true,
            show1: false,
            show2: false,
            login: '',
            password: '',
            rules: [
                v => !!v || 'Obrigatório.',
                v =>  v.length >= 3 || 'Min 3 caracteres.'
            ],
            disabledButton: true,
            disabledInputSenha: true,
            showError: false
        }
    },
    watch:{
        login(newValue){
            this.disabledInputSenha = newValue ? false : true
            this.showError = false
            this.password = ""
        },
        password(newValue){
            this.disabledButton = newValue ? false : true
            this.showError = false
        }
    },
    methods: {
        authenticate() {

             if (this.$refs.form.validate()) {
                const { login, password } = this

                if(!login.length || !password.length){
                    return false;
                }


                ServiceLogin.efetuarLogin(login, password).then(response => {

                    if(response.status === 200){
                        if(response.data.token && response.data.token != "") {
                            LocalStorage.add("SESSION_KABUM", {
                                session: response.data.sessionData,
                                token: response.data.token
                            });
                            this.$router.push('painel');
                        } else {
                            this.showError = true
                        }
                    }

                })
             }
        }
    }
}
</script>

<style>
    .content-login {
        background: #003190;
        height: 100%;
        display: flex;
        align-items: center;
    }

    .login {
        padding: 20px 30px 50px 30px;
    }

    .box-logo {
        padding: 20px;
    }

    .btn-entrar {
        margin-top: 30px;
        margin-bottom: 20px;
    }
</style>


