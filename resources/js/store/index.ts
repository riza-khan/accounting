import { createStore } from "vuex";
import Axios from "../api";

export default createStore({
	state: {
		loading: false,
		token: "",
		company: {},
	},
	getters: {
		getLoading: (state: any): boolean => state.loading,
		getToken: (state: any): string => state.token,
		getCompany: (state: any): any => state.company,
	},
	mutations: {
		setToken(state, token) {
			state.token = token;
		},
		setCompany(state, company) {
			state.company = company;
		},
		logout() {
			Axios.post("/logout");
		},
	},
});
