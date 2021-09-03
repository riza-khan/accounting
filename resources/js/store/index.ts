import { createStore } from "vuex";
import Axios from "../api";

export default createStore({
	state: {
		loading: false,
		token: "",
		company: {},
		categories: [],
	},
	getters: {
		getLoading: (state: any): boolean => state.loading,
		getToken: (state: any): string => state.token,
		getCompany: (state: any): any => state.company,
		getCategories: (state: any): any => state.categories,
	},
	mutations: {
		setToken(state, token) {
			state.token = token;
		},
		setCompany(state, company) {
			state.company = company;
		},
		setCategories(state, categories) {
			state.categories = categories;
		},
		logout() {
			Axios.post("/logout");
		},
	},
	actions: {
		async getCategories({ commit }) {
			const categories = await Axios.get("/api/categories");
			commit("setCategories", categories.data);
		},
	},
});
