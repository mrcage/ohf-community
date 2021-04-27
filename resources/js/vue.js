import Vue from "vue";

// Font awesome
import FontAwesomeIcon from "@/components/common/FontAwesomeIcon";
Vue.component("font-awesome-icon", FontAwesomeIcon);

// Bootstrap Vue
import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);

// i18n
import i18n from "@/plugins/i18n";

// ziggy routes
import ziggyMixin from "@/mixins/ziggyMixin";
Vue.mixin(ziggyMixin);

// Form validation
import "@/plugins/vee-validate";

// Hide prod tooltip
Vue.config.productionTip = false;

// Users app
import UserIndexPage from "@/pages/users/UserIndexPage";
if (document.getElementById("user-management-app")) {
    new Vue({
        el: "#user-management-app",
        i18n,
        components: {
            UserIndexPage
        }
    });
}

// Visitors app
import visitorRouter from "@/router/visitors";
import VisitorsApp from "@/app/VisitorsApp";
if (document.getElementById("visitors-app")) {
    new Vue({
        el: "#visitors-app",
        router: visitorRouter,
        i18n,
        components: {
            VisitorsApp
        }
    });
}

// Community volunteer app
import CommunityVolunteersReportPage from "@/pages/cmtyvol/CommunityVolunteersReportPage";
import CommunityVolunteersOverviewPage from "@/pages/cmtyvol/CommunityVolunteersOverviewPage";
import CmtyvolComments from "@/components/cmtyvol/CmtyvolComments";
if (document.getElementById("cmtyvol-app")) {
    new Vue({
        el: "#cmtyvol-app",
        i18n,
        components: {
            CommunityVolunteersReportPage,
            CommunityVolunteersOverviewPage,
            CmtyvolComments
        }
    });
}

// Accounting app
import accountingRouter from "@/router/accounting";
import AccountingApp from "@/app/AccountingApp";
if (document.getElementById("accounting-app")) {
    new Vue({
        el: "#accounting-app",
        router: accountingRouter,
        i18n,
        components: {
            AccountingApp
        }
    });
}

// Fundraising app
import store from "@/store";
import fundraisingRouter from "@/router/fundraising";
import FundraisingApp from "@/app/FundraisingApp";
if (document.getElementById("fundraising-app")) {
    new Vue({
        el: "#fundraising-app",
        store,
        router: fundraisingRouter,
        i18n,
        components: {
            FundraisingApp
        }
    });
}

// Reports app
import reportsRouter from "@/router/reports";
import ReportsApp from "@/app/ReportsApp";
if (document.getElementById("reports-app")) {
    new Vue({
        el: "#reports-app",
        router: reportsRouter,
        i18n,
        components: {
            ReportsApp
        }
    });
}
