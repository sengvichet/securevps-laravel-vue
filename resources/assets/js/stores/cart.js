import { http } from '../services'

export const cartStore = {

    getAll () {
        return new Promise((resolve, reject) => {
            http.get(`/api/cart`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    remove (id) {
        return new Promise((resolve, reject) => {
            http.delete(`/api/cart`, {id}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    isUserConnected (data) {
        return new Promise((resolve, reject) => {
            http.post(`/api/cart/isUserConnected`, {data}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getPaymentDetails () {
        return new Promise((resolve, reject) => {
            http.get(`/api/payment`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    checkDomainAvaliable (data) {
        return new Promise((resolve, reject) => {
            http.post(`/api/payment/checkdomainavaliable`, {data}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    changeSaveTokenStatus (data) {
        return new Promise((resolve, reject) => {
            http.post(`/api/payment/change-save-token-status`, {data}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },
}
