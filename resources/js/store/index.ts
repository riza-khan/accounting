import { createStore } from "vuex";
import Axios from "../api";
import modules from "./modules";

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
		logout() {},
	},
	modules: {
		...modules,
	},
});
