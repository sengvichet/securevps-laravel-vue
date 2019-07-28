import {
    http
} from '../services'

export const wizardStore = {

    getWizard(cartid) {
        return new Promise((resolve, reject) => {
            http.get(`/api/cart/wizard?cart=` + cartid, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getSharedAddons(itemid, cartid) {
        return new Promise((resolve, reject) => {
            http.get(`/api/cart/shared_addons?cart=` + cartid + `&itemid=` + itemid, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getVPSAddons(os, cartid) {
        return new Promise((resolve, reject) => {
            http.get(`/api/cart/vps_addons?cart=` + cartid + `&os=` + os, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    savePackage(data) {
        return new Promise((resolve, reject) => {
            http.post(`/api/cart/addons`, {
                data
            }, ({
                data
            }) => {
                resolve(data)
                console.log(data)
            }, error => reject(error))
        })
    },

    remove(id) {
        return new Promise((resolve, reject) => {
            http.delete(`/api/cart`, {
                id
            }, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    }
}