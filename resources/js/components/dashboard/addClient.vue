<template>
    <div>
        <sideBar></sideBar>
        <div class="main-panel">
            <navBar></navBar>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Add Client</h4>
                                </div>
                                <div class="card-body">
                                    <form>
                                    <p v-if="errors.length">
                                    <b style="color:red;" >Please correct the following error(s):</b>
                                    <ul>
                                    <li style="color:red;"  v-for="error in errors " >{{ error }}</li>
                                    </ul>
                                </p>
                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Account Name</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="accountName"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label>Client Type</label>

                                                    <select
                                                        class="form-control"
                                                        v-model="clientType"
                                                    >
                                                        <option
                                                            value=""
                                                            disabled
                                                            >Select
                                                            Option</option
                                                        >
                                                        <option value="business"
                                                            >Business</option
                                                        >
                                                        <option
                                                            value="individual"
                                                            >Individual</option
                                                        >
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 pr-1">
                                                <div class="form-group">
                                                    <label>Insitution</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="institution"
                                                    />
                                                </div>
                                            </div>

                                            <div class="col-md-6 pl-1">
                                                <div class="form-group">
                                                    <label
                                                        >Account Manager</label
                                                    >
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="accountManager"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="submit"
                                            class="btn btn-info btn-fill pull-left"
                                            @click="saveClient($event)"
                                        >
                                            Save Client
                                        </button>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import navBar from "../navBar.vue";
import sideBar from "../sideBar.vue";
import axios from "axios";
import Vue from "vue";
import VueToast from "vue-toast-notification";
import "vue-loading-overlay/dist/vue-loading.css";
import Loading from "vue-loading-overlay";
import "vue-toast-notification/dist/theme-default.css";
Vue.use(VueToast);
Vue.use(Loading);
export default {
    name: "addClient",
    components: {
        navBar,
        sideBar
    },
    data() {
        return {
            accountName: "",
            clientType: "",
            institution: "",
            accountManager: "",
              errors: [],
        };
    },
    methods: {
        saveClient: function(event) {

              if (this.accountName && this.clientType && this.institution && this.accountManager) {
           let loader = this.$loading.show({
                // Optional parameters
                canCancel: false,
                onCancel: this.onCancel,
                width: 40,
                height: 40,
                color: "#002d3f"
            });
            event.preventDefault();

            let data = {
                accountName: this.accountName,
                clientType: this.clientType,
                institution: this.institution,
                accountManager: this.accountManager
            };
            axios
                .post("saveClient", data)
                .then(response => {
                    loader.hide();
                    setTimeout(() => {
                        Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position
                        });
                        this.clearForm(response.data.status);
                    }, 2000);
                })
                .catch(error => {
                    loader.hide();

                    setTimeout(() => {
                        Vue.$toast.open({
                            message: response.message,
                            type: "error",
                            position: "top"
                        });
                    }, 2000);
                });
      }

      this.errors = [];
      if (!this.accountName) {
        this.errors.push('account name required is required');
      }
      if (!this.institution) {
        this.errors.push('institution is  required.');
      }
      if (!this.clientType) {
        this.errors.push('client type is  required.');
      }
      if (!this.accountManager) {
        this.errors.push('account manager is  required.');
      }
event.preventDefault();
        },
        clearForm: function() {
            if (arguments[0] === 201) {
                this.accountName = "";
                this.clientType = "";
                this.institution = "";
                this.accountManager = "";
            }
        }
    }
};
</script>
<style scoped>
.container-fluid {
    margin-top: 10px;
}
.main-panel {
    overflow: auto;
    max-height: calc(100vh - 30px);
    min-height: 100%;
}
</style>
