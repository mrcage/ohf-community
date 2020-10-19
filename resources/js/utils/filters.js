import Vue from 'vue'
import moment from 'moment'
import numeral from 'numeral'

Vue.filter('dateFormat', function (value) {
    return moment(value).format('LL')
})

Vue.filter('dateTimeFormat', function (value) {
    return moment(value).format('LLL')
})

Vue.filter('numberFormat', function (value) {
    return numeral(value).format('0,0.00')
})
