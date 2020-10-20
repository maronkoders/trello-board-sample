<template>
    <div>
        <sideBar></sideBar>
        <div class="main-panel">
            <navBar></navBar>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="content-panel">
                                <div id="table">
                                    <VueGoodTable
                                        ref="clients"
                                        :columns="columns"
                                        :rows="rows"
                                        :search-options="{
                                            enabled: true,
                                            width: '100px',
                                            placeholder: 'Search Clients'
                                        }"
                                        :select-options="{ enabled: true }"
                                        :sort-options="{
                                            enabled: true,
                                            initialSortBy: {
                                                field: 'accountName',
                                                type: 'asc'
                                            }
                                        }"
                                        :pagination-options="{
                                            enabled: true,
                                            mode: 'records',
                                            perPage: 10,
                                            position: 'bottom',
                                            perPageDropdown: [25, 50, 100],
                                            dropdownAllowAll: false,
                                            setCurrentPage: 2,
                                            nextLabel: 'next',
                                            prevLabel: 'prev',
                                            rowsPerPageLabel: 'Rows per page',
                                            ofLabel: 'of',
                                            pageLabel: 'page', // for 'pages' mode
                                            allLabel: 'All'
                                        }"
                                    >
                                        <div slot="table-actions">
                                            <router-link to="/addClient">
                                                <button
                                                    class="btn btn-default"
                                                    style="margin-right:10px;"
                                                >
                                                    NEW CLIENT
                                                </button>
                                            </router-link>
                                        </div>
                                        <div slot="selected-row-actions">
                                            <button @click="deleteClient">
                                                Delete
                                            </button>
                                        </div>

                                        <div
                                            slot="table-row"
                                            slot-scope="props"
                                        >
                                            <span
                                                v-if="
                                                    props.column.field == 'btn'
                                                "
                                            >
                                                <router-link to="/editClient">
                                                    <button
                                                        style="margin-right:2px;"
                                                        type="button"
                                                        @click="
                                                            viewClient(
                                                                props.formattedRow
                                                            )
                                                        "
                                                    >
                                                        EDIT
                                                    </button>
                                                </router-link>
                                                <button
                                                    style="margin-right:2px;"
                                                    type="button"
                                                    @click="
                                                        changeStatus(
                                                            'blacklist',
                                                            props.formattedRow
                                                        )
                                                    "
                                                >
                                                    BACKLIST
                                                </button>
                                                <button
                                                    style="margin-right:2px;"
                                                    type="button"
                                                    @click="
                                                        changeStatus(
                                                            'unblacklist',
                                                            props.formattedRow
                                                        )
                                                    "
                                                >
                                                    UN-BLACKLIST
                                                </button>
                                                <button
                                                    style="margin-right:2px;"
                                                    type="button"
                                                    @click="
                                                        removeClient(
                                                            props.formattedRow
                                                        )
                                                    "
                                                >
                                                    DELETE
                                                </button>
                                            </span>
                                            <span v-else>
                                                {{
                                                    props.formattedRow[
                                                        props.column.field
                                                    ]
                                                }}
                                            </span>
                                        </div>
                                    </VueGoodTable>
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
import Vue from "vue";
import navBar from "../navBar.vue";
import sideBar from "../sideBar.vue";
import { VueGoodTable } from "vue-good-table";
import "vue-good-table/dist/vue-good-table.css";
import axios from "axios";
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-default.css";
import "vue-loading-overlay/dist/vue-loading.css";
import Loading from "vue-loading-overlay";
Vue.use(Loading);
Vue.use(VueToast);

export default {
    name: "clients",
    components: {
        navBar,
        sideBar,
        Loading,
        VueGoodTable
    },
    data() {
        return {
            columns: [
                {
                    label: "id",
                    field: "id",
                    hidden: true
                },
                {
                    label: "  Name",
                    field: "accountName"
                },
                {
                    label: " Type",
                    field: "clientType"
                },
                {
                    label: "Institution",
                    field: "institution"
                },
                {
                    label: " Manager",
                    field: "accountManager"
                },
                {
                    label: "Date",
                    field: "date"
                },
                {
                    label: "Status",
                    field: this.nameStatus
                },
                {
                    label: "Action",
                    field: "btn",
                    html: true
                }
            ],
            rows: []
        };
    },
    methods: {
        nameStatus: function(rowObj) {
            if (rowObj.status === 1) {
                return "BLACKLISTED";
            }
            return "ÚNBLACKLISTED";
        },
        deleteClient: function() {
            let loader = this.$loading.show({
                // Optional parameters
                canCancel: false,
                onCancel: this.onCancel,
                width: 40,
                height: 40,
                color: "#002d3f"
            });

            axios
                .post("deleteClients", this.$refs.clients.selectedRows)
                .then(response => {
                    if (response.status === 200) {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                    } else {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
                    loader.hide();
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        },
        removeClient: function() {
            let loader = this.$loading.show({
                // Optional parameters
                canCancel: false,
                onCancel: this.onCancel,
                width: 40,
                height: 40,
                color: "#002d3f"
            });

            let payload = {
                id: arguments[0].id
            };

            axios
                .post("removeClient", payload)
                .then(response => {
                    if (response.status === 200) {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                    } else {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
                    loader.hide();
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        },
        viewClient: function() {
            localStorage.setItem("client", JSON.stringify(arguments[0]));
        },
        getClients: function() {
            let loader = this.$loading.show({
                canCancel: false,
                onCancel: this.onCancel,
                width: 40,
                height: 40,
                color: "#002d3f"
            });
            axios
                .get("getClients")
                .then(response => {
                    if (response.status === 200) {
                        loader.hide();
                        this.rows = response.data;
                    } else {
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
                    loader.hide();
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        },
        changeStatus() {
            let loader = this.$loading.show({
                // Optional parameters
                canCancel: false,
                onCancel: this.onCancel,
                width: 40,
                height: 40,
                color: "#002d3f"
            });

            let payload = {
                status: arguments[0],
                id: arguments[1].id
            };
            axios
                .post("changeStatus", payload)
                .then(response => {
                    if (response.status === 200) {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: response.data.type,
                            position: response.data.position
                        });
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                    } else {
                        loader.hide();
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
                    loader.hide();
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        }
    },
    created() {
        this.getClients();
    }
};
</script>
<style scoped>
button {
    font-size: x-small;
}
.days {
    float: right;
}
.checkbox {
    height: 13px;
}
.form-control {
    padding: 0px;
    height: 20px;
}
.main-panel {
    overflow: auto;
    max-height: calc(100vh - 30px);
    min-height: 100%;
}

.align {
    display: block;
}
label {
    text-transform: uppercase;
}
</style>
