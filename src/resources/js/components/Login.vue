<template>
  <div class="">
    <input v-model="user" type="text" />
    <input v-model="pass" type="password" />
    <button @click="login">Login</button>
  </div>
</template>
<script>
import api from "../api.js";
export default {
  data() {
    return {
      user: "alice@mail.com",
      pass: "123456"
    };
  },
  mounted: function () {},
  methods: {
    login: function () {
      api()
        .post("session", {
          email: this.user,
          password: this.pass
        })
        .then((r) => {
          localStorage.setItem("token", r.data.data.access_token);
          localStorage.setItem("refresh_token", r.data.data.refresh_token);
          this.$router.replace('/');
        })
        .catch(function (r) {
            localStorage.removeItem("token");
            localStorage.removeItem("refresh_token");
            alert(r.response.data.msg)
          });
    },
    logout: function () {
      // revoke token
      api()
        .post("logout")
        .then((r) => {
          localStorage.removeItem("token");
          console.log(r.data);
        });
    },
  },
};
</script>