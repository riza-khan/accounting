import { createStore } from "vuex";

export default createStore({
    state: {
        loading: false,
    },
    getters: {
        getLoading: (state: any) => state.loading,
    },
});
