import { createStore } from "vuex";
import Axios from "../api";

export default createStore({
	state: {
		loading: false,
		token: "",
	},
	getters: {
		getLoading: (state: any): boolean => state.loading,
		getToken: (state: any): string => state.token,
	},
	mutations: {
		setToken(state, token) {
			state.token = token;
		},
		logout() {
			Axios.post("/logout");
		},
	},
});
