import { createStore } from "vuex";
import Axios from "../api";

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
        getLoading: (state: any): boolean => state.loading,
        getToken: (state: any): string => state.token,
        getCompany: (state: any): any => state.company,
        getCompanyName: (state: any): any => state.company.CompanyName,
        getCategories: (state: any): any => state.categories,
        getLoader: (state: any): any => state.loader,
        getModalTargetObj: (state: any): any => state.modalTargetObj,
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
