<template>
  <nav class="navbar navbar-expand-lg bg-white">
    <div class="container-fluid">
      <auth-logo class="nav-logo"></auth-logo>

      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <h3 v-if="userData">Hello, {{userData.name}}!</h3>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
          <li class="nav-item">
            <a class="nav-link"  :href="baseUrl">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" :href="myAccountUrl">My Account</a>
          </li>
<!--          <li class="nav-item dropdown">-->
<!--            <a-->
<!--              class="nav-link"-->
<!--              href="#"-->
<!--              id="notificationDropdown"-->
<!--              role="button"-->
<!--              data-bs-toggle="dropdown"-->
<!--              aria-expanded="false"-->
<!--            >-->
<!--              <span class="notification-icon">-->
<!--                <ion-icon name="notifications" class="notification-icon"></ion-icon>-->
<!--                <ion-icon name="ellipse" class="notification-alrt"></ion-icon>-->
<!--              </span>-->
<!--            </a>-->
<!--            <div class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown">-->
<!--              <h6 class="my-2">Notifications</h6>-->
<!--              <a href="#" class="dropdown-item new">-->
<!--                <strong>Participant’s</strong> membership<br />-->
<!--                ends in 30 days.-->
<!--              </a>-->
<!--              <a href="#" class="dropdown-item new">-->
<!--                <strong>Participant’s</strong> membership<br />-->
<!--                ends in 30 days.-->
<!--              </a>-->
<!--              <a href="#" class="dropdown-item new">-->
<!--                <strong>Participant’s</strong> membership<br />-->
<!--                ends in 30 days.-->
<!--              </a>-->
<!--            </div>-->
<!--          </li>-->
          <!-- Authentication Links -->
          <li class="nav-item" v-if="hasLogin">
            <a class="nav-link" :href="loginUrl">Login</a>
          </li>

          <li class="nav-item dropdown" v-if="userData">
            <a
              class="nav-link pe-0"
              href="#"
              id="navbarDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <!-- {{ userData.name }} -->
              <div class="avatar">
                <img :src="userData.avatar_url" width="50" height="50" alt="" />
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <a
                class="dropdown-item"
                :href="logoutUrl"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
              >
                Logout
              </a>

              <form id="logout-form" :action="logoutUrl" method="POST" class="d-none">
                <csrf-token />
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
  props: ["user"],
  data() {
    return {
      baseUrl: null,
      loginUrl: null,
      logoutUrl: null,
      myAccountUrl: null,
      hasLogin: null,
      userData: null,

    }
  },
  mounted() {

    try {
      this.userData = JSON.parse(this.user)
    } catch (e) {
      this.userData = null
    }

    this.baseUrl = this.laroute.route("index")
    this.loginUrl = this.laroute.route("login")
    this.logoutUrl = this.laroute.route("logout")
    this.myAccountUrl = this.laroute.route("my.account");
    this.hasLogin = window.location.pathname == this.loginUrl ? true : false
  },
}
</script>
