import Vue from 'vue'

import Icon from '@app/components/Icon'
import WithdrawalResults from './components/WithdrawalResults.vue'
import WithdrawalTransactions from './components/WithdrawalTransactions.vue'

Vue.component('icon', Icon);

new Vue({
	el: '#bank-app',
	components: {
		Icon,
		WithdrawalResults,
		WithdrawalTransactions
	}
});