import HTTP from './HTTP'

export default {
    cadCliente: (inputs) => HTTP.post("./cliente", inputs),
    removerCliente: (id) => HTTP.delete("./cliente/" + id),
    editarCliente: (id, data) => HTTP.patch("./cliente/" + id, data),
    listAll: (id) => HTTP.get("./cliente/" + id)
}