<template>
    <div>
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="#" class="simple-text">Clients</a>
                </div>
                <ul class="nav">
                    <li class="nav-item">
                        <router-link to="/home">
                            <a class="nav-link">
                                <p>Dashboard</p>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/addClient">
                            <a class="nav-link">
                                <p>add Clients</p>
                            </a>
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/clients">
                            <a class="nav-link">
                                <p>Clients</p>
                            </a>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "sideBar"
};
</script>
