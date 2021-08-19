import axios from "axios";
import store from "../store";

const Axios = axios.create({
	baseURL: process.env.APP_URL,
});

const addToken = (config: any) => {
	const token = store.getters["getToken"];
	if (token) {
		config.headers.Authorization = `Bearer ${token}`;
	}
};

Axios.interceptors.request.use(
	(config) => {
		store.commit("setLoader", true);
		return config;
	},
	(error) => Promise.reject(error)
);

Axios.interceptors.response.use(
	(response) => {
		store.commit("setLoader", false);
		return response;
	},
	(error) => Promise.reject(error)
);
