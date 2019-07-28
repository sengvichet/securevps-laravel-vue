import { http } from '../services'

export const userStore = {

    sendMeSmsCodeForLogin (phone, captcha) {
        return new Promise((resolve, reject) => {
            http.post('sendMeSmsCodeForLogin', { phone }, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    validateMySmsCodeForLogin (smscode) {
        return new Promise((resolve, reject) => {
            http.post('validateMySmsCodeForLogin', { smscode }, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getDomainSpaces () {
        return new Promise((resolve, reject) => {
            http.get('/api/getDomainSpaces', ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getOrderData (docEntry) {
        return new Promise((resolve, reject) => {
            http.get(`/api/getOrderData/${docEntry}`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getUpgradePackeges (currentId, upgradeType, res) {
        return new Promise((resolve, reject) => {
            http.get(`/api/upgrade/packeges/${currentId}/${upgradeType}/${res}`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    setUpgradeSummerize (params) {
        return new Promise((resolve, reject) => {
            http.post(`/api/upgrade/summerize`, { params }, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getNewAddons (addList, selectedId) {
        return new Promise((resolve, reject) => {
            http.post(`/api/upgrade/getNewAddons`, { addList, selectedId }, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getDomainInvoicesAndReceipts (domain) {
        return new Promise((resolve, reject) => {
            http.post(`/api/getDomainInvoicesAndReceipts`, {domain}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getAllClientInvoices () {
        return new Promise((resolve, reject) => {
            http.get(`/api/getAllClientInvoices`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getAllClientReceipts () {
        return new Promise((resolve, reject) => {
            http.get(`/api/getAllClientReceipts`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    createPdf (docEntry, thedate, doctype) {
        return new Promise((resolve, reject) => {
            http.get(`/api/createPdf/${docEntry}/${thedate}/${doctype}`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    getSessionResult () {
        return new Promise((resolve, reject) => {
            http.get('get-session-result', ({ data }) => {
            resolve(data)
        }, error => reject(error))
     })
    },

    getInvoiceYears () {
        return new Promise((resolve, reject) => {
            http.get(`/api/get-invoice-years`, ({ data }) => {
            resolve(data)
        }, error => reject(error))
     })
    },

    createInvoiceExcelByYear (params) {
        return new Promise((resolve, reject) => {
            http.post(`/api/create-invoice`, { params }, ({ data }) => {
            resolve(data)
        }, error => reject(error))
     })
    },

    checkAddonParentDate () {
        return new Promise((resolve, reject) => {
            http.get('/api/check-parent-package', ({ data }) => {
             resolve(data)
            }, error => reject(error))
        })
    },

    checkActiveAddon () {
        return new Promise((resolve, reject) => {
            http.get('/api/check-active-addon', ({ data }) => {
             resolve(data)
            }, error => reject(error))
        })
    },

    getAllPackeges (packageType, packageOs, packageDn) {
        return new Promise((resolve, reject) => {
            http.get(`/api/upgrade/get-all-packages/${packageType}/${packageOs}/${packageDn}`, ({ data }) => {
            resolve(data)
            }, error => reject(error))
        })
    },

    getAllCreditCards () {
        return new Promise((resolve, reject) => {
            http.get(`/api/credit-cards`, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    removeCreditCard (creditCard) {
        return new Promise((resolve, reject) => {
            http.delete(`/api/credit-cards`, {creditCard}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    markCreditCardAsDefault (creditCard) {
        return new Promise((resolve, reject) => {
            http.post(`/api/credit-cards/mark-as-default`, {creditCard}, ({ data }) => {
                resolve(data)
            }, error => reject(error))
        })
    },

    setPayNowSummerize (params) {
        return new Promise((resolve, reject) => {
            http.post(`/api/payment/summerize`, { params }, ({ data }) => {
            resolve(data)
        }, error => reject(error))
    })
    },

}
