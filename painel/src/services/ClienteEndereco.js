import HTTP from './HTTP'

export default {
    cadEnderecoCliente: (data) =>  HTTP.post("./enderecoCliente", data),
    removerEnderecoCliente: (id) =>  HTTP.delete("./enderecoCliente/" + id),
    editarEnderecoCliente: (id, data) =>  HTTP.patch("./enderecoCliente/" + id, data),
    listAll: (id) =>  HTTP.get("./enderecoCliente/" + id)
}