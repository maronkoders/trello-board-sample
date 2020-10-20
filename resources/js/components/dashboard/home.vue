<template>
    <div>
        <sideBar></sideBar>
        <div class="main-panel">
            <navBar></navBar>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Total Clients</h4>
                                    <p class="card-category">
                                        System Clients
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div ref="clients"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card card-tasks">
                                <div class="card-header">
                                    <h4 class="card-title">User Activites</h4>
                                    <p class="card-category">
                                        Recent Activities
                                    </p>
                                </div>
                                <div class="card-body">
                                    <div class="table-full-width">
                                        <table class="table">
                                            <tbody>
                                                <tr
                                                    v-for="item in activities"
                                                    :key="item.id"
                                                >
                                                    <td
                                                        style="width:fit-content"
                                                    >
                                                        <span>
                                                            {{ item.userName }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ item.action }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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
import Vue from "vue";
import axios from "axios";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4charts from "@amcharts/amcharts4/charts";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

am4core.useTheme(am4themes_animated);
export default {
    name: "home",
    components: {
        navBar,
        sideBar,
        axios
    },
    data() {
        return {
            allClients: [],
            activities: []
        };
    },
    methods: {
        getClients: function() {
            axios
                .get("getClients")
                .then(response => {
                    if (response.status === 200) {
                        localStorage.setItem(
                            "serverClients",
                            JSON.stringify(response.data)
                        );
                    } else {
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        },
        getActivities: function() {
            axios
                .get("getActivites")
                .then(response => {
                    if (response.status === 200) {
                        this.activities = response.data;
                    } else {
                        Vue.$toast.open({
                            message: response.data.message,
                            type: "error",
                            position: "top"
                        });
                    }
                })
                .catch(error => {
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
        this.getActivities();
    },
    mounted() {
        let clients = JSON.parse(localStorage.getItem("serverClients"));
        let chart = am4core.create(this.$refs.clients, am4charts.PieChart);
        let blackListedClients = [];
        let unblackListedClients = [];

        // if (clients === null) {
        //     window.location.reload();
        // }
        clients.forEach(element => {
            if (element.status === 1) {
                blackListedClients.push(element);
            }else{
                 unblackListedClients.push(element);  
            }
         
        });

        chart.data = [
            {
                status: "Blacklisted ",
                total: blackListedClients.length
            },
            {
                status: "Unblacklisted",
                total: unblackListedClients.length
            }
        ];
        let pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "total";
        pieSeries.dataFields.category = "status";
    }
};
</script>
<style scoped>
.container-fluid {
    margin-top: 10px;
}
.card {
    height: fit-content;
}
.card-body {
    height: fit-content;
}
.main-panel {
    overflow: auto;
    max-height: calc(100vh - 30px);
    min-height: 100%;
}
</style>
