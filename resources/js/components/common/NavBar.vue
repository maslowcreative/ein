<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" :href="baseUrl">
                EIN
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item" v-if="hasLogin">
                        <a class="nav-link" :href="loginUrl">Login</a>
                    </li>

                    <li class="nav-item dropdown" v-if="userData">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ userData.name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" :href="logoutUrl"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" :action="logoutUrl" method="POST" class="d-none">
                                <csrf-token/>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>


        </div>
    </nav>
</template>

<script>
export default {
    props: ['user'],
    data() {
        return {
            'baseUrl': null,
            'loginUrl': null,
            'logoutUrl': null,
            'hasLogin' : null,
            'userData' : null,
        }
    },
    mounted() {

        try {this.userData = JSON.parse(this.user)}
        catch(e) {this.userData = null};

        this.baseUrl = this.laroute.route('index');
        this.loginUrl =  this.laroute.route('login');
        this.logoutUrl =  this.laroute.route('logout');
        this.hasLogin = window.location.pathname == this.loginUrl ? true : false;
    }
}
</script>
