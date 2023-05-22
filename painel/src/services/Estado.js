import HTTP from './HTTP'

export default {
    listAll: () => HTTP.get("./estado")
}