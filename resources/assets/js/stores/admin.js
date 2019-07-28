import {
    http
} from '../services'
import {
    date,
    currency,
    quantity,
    intg
} from '../utils'

export const adminStore = {

    sendMeSmsCodeForAdminLogin(phone) {
        return new Promise((resolve, reject) => {
            http.post('sendMeSmsCodeForAdminLogin', {
                phone
            }, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    // getAllUsers () {
    //     return new Promise((resolve, reject) => {
    //         http.get('/api/admin/users', ({ data }) => {
    //
    //             _.map(data, function(tag) {
    //                 return tag.CreateDate = date(tag.CreateDate);
    //             })
    //
    //             resolve(data)
    //         }, error => reject(error))
    //     })
    // },

    getItems() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/items', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    importItems() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/items/import', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    destroyItems() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/items/destroy', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    destroyAll() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/items/destroy-all', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    toggleEnable(id) {
        return new Promise((resolve, reject) => {
            http.get(`/api/admin/items/${id}/enable`, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    loginAsUser(asUser) {
        return new Promise((resolve, reject) => {
            http.post('/api/admin/loginAsUser', {
                asUser
            }, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    // getOrders () {
    //     return new Promise((resolve, reject) => {
    //         http.get('/api/admin/orders', ({ data }) => {
    //             resolve(data)
    //         }, error => reject(error))
    //     })
    // },

    getSessions() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/sessions', ({
                data
            }) => {

                // _.map(data, (tag) => {
                //     return tag.created_at = date(tag.created_at)
                // })
                //
                // _.map(data, (tag) => {
                //     return tag.updated_at = date(tag.updated_at)
                // })

                resolve(data)
            }, error => reject(error))
        })
    },

    destroySessions() {
        return new Promise((resolve, reject) => {
            http.post('/api/admin/destroy-sessions', {}, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    deleteSession(id) {
        return new Promise((resolve, reject) => {
            http.post('/api/admin/delete-session', {
                id
            }, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getLocalUsers() {
        return new Promise((resolve, reject) => {
            http.get('/api/admin/local-users', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    trancateLocalUsers() {
        return new Promise((resolve, reject) => {
            http.post('/api/admin/trancate-local-users', {}, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    deleteLocalUser(id) {
        return new Promise((resolve, reject) => {
            http.post('/api/admin/delete-local-user', {
                id
            }, ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getDomainSpaces() {
        return new Promise((resolve, reject) => {
            http.get('/api/getDomainSpaces', ({
                data
            }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

}