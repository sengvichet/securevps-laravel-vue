import moment from 'moment'
import numeral from 'numeral'

export function date (date) {
    return moment(date).format('DD/MM/YYYY')
}

export function datetime (datetime) {
    return moment(datetime).format('H:mm DD/MM/YYYY')
}

export function currency (n) {
    return numeral(n).format('0,0.00') + ' ₪'
}

export function currency2 (n) {
    return numeral(n).format('0,0.00')
}

export function microCurrency (n) {
    return numeral(n).format('0,0.00000') + ' ₪'
}

export function quantity (n) {
    return numeral(n).format('0,0') + ' יח\''
}

export function quantity2 (n) {
    return numeral(n).format('0,0')
}

export function intg (n) {
    return Math.floor(n)
}

export function isRefund (n) {
    return (n < 0) ? 'זיכוי': 'חיוב'
}

export function disk (s) {
    let n = (parseInt(s || 0) * 1024 * 1024)
    let filesizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

    if (n == 0) return 0 + ' ' + 'KB';

    let i = parseInt(Math.floor(Math.log(n) / Math.log(1024)));
    if (i == 0) return n + ' ' + filesizes[i];

    return (n / Math.pow(1024, i)).toFixed(1) + ' ' + filesizes[i];
}
