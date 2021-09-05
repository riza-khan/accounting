import axios from "axios";
import store from "../store";

const Axios = axios.create({
	baseURL: process.env.API_URL,
	headers: { Accept: "application/json" },
});

Axios.interceptors.request.use(
	(config) => {
		store.commit("setLoader", true);
		return config;
	},
	(error) => {
		store.commit("setLoader", false);
		Promise.reject(error);
	}
);

Axios.interceptors.response.use(
	(response) => {
		store.commit("setLoader", false);
		return response;
	},
	(error) => {
		store.commit("setLoader", false);
		Promise.reject(error);
	}
);

export default Axios;
