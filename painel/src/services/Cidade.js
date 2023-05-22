import HTTP from './HTTP'

export default {
    listAll: (id) => HTTP.get("./cidade/" + id)
}