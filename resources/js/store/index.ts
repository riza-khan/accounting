import { createStore } from "vuex";
import Axios from "../api";

interface Company {
	[key: string]: any;
}

interface ModalTargetObj {
	[key: string]: any;
}

interface Category {
	[key: string]: any;
}

interface State {
	loading: boolean;
	token: string;
	company: Company;
	categories: Category[];
	modalTargetObj: ModalTargetObj;
	loader: boolean;
}

export default createStore({
	state: {
		loading: false,
		token: "",
		company: {},
		categories: [],
		modalTargetObj: {},
		loader: false,
	},
	getters: {
		getLoading: (state: State): boolean => state.loading,
		getToken: (state: State): string => state.token,
		getCompany: (state: State): Company => state.company,
		getCompanyName: (state: State): string => state.company.CompanyName,
		getCategories: (state: State): Category => state.categories,
		getLoader: (state: State): boolean => state.loader,
		getModalTargetObj: (state: State): ModalTargetObj =>
			state.modalTargetObj,
	},
	mutations: {
		setToken(state, token) {
			state.token = token;
		},
		setModalTargetObj(state, obj) {
			state.modalTargetObj = obj;
		},
		setCompany(state, company) {
			state.company = company;
		},
		setCategories(state, categories) {
			state.categories = categories;
		},
		setLoader(state, newState) {
			state.loader = newState;
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
