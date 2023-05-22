import HTTP from './HTTP'

export default {
    efetuarLogin: (user, password) => HTTP.post("./login", {
        login: user,
        senha: password
    })
}