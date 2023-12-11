import axios from "axios";

export default  {

    conn(refresh=false) {
        let apiAxios = axios.create({
          baseURL: "api",
        });

        let token = localStorage.getItem("token");
        if (refresh) {
          token = localStorage.getItem("refresh_token");
        }
        if (token) {
          apiAxios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
        }
        return apiAxios;
    },

    async logIn(email, password) {
        try {
          const result = await this.conn().post("session", {
              email:email,
              password: password
          })
          
          if (result.data.ok) {
            localStorage.setItem("token", result.data.data.access_token);
            localStorage.setItem("refresh_token", result.data.data.refresh_token);
            return {
              isOk: true
            }
          }
        } catch(result) {          
            localStorage.removeItem("token");
            localStorage.removeItem("refresh_token");
            return {
              isOk: false,
              message: result.response.data.msg
            }
        }
    },

}