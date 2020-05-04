require("./bootstrap");
import Vue from "vue";
import Vmodal from "vue-js-modal";

Vue.use(Vmodal);

Vue.component(
    "new-project-modal",
    require("./components/NewProjectModal.vue").default
);
Vue.component(
    "DropdownComponent",
    require("./components/DropdownComponent").default
);
const app = new Vue({
    el: "#app"
});
