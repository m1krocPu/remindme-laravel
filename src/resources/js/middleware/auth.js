import api from "../api.js";

export default async function auth({ next }) {
    if (!localStorage.getItem('token')) {
        return next({name:'login'})
    }


    try {
        await api.conn(true)
        .put("session")
        .then((r) => {
            localStorage.setItem("token", r.data.data.access_token);
        })
    } catch (r) {
        return next({name:'login'})
    }

    return next();
}