import axios from "axios";

export default function (refresh=false) {
  let api = axios.create({
    baseURL: "api",
  });

  let token = localStorage.getItem("token");
  if (refresh) {
    token = localStorage.getItem("refresh_token");
  }
  if (token) {
    api.defaults.headers.common["Authorization"] = `Bearer ${token}`;
  }
  return api;
}