import Company from "./models/Company.ts";


const state = () => ({
	company: {},
});

const getters = {};

const mutations = {
	setCompany(state: any, company: any) {
		state.company = new Company(company);
	},
};

const actions = {};

export default {
	state,
	getters,
	mutations,
	actions,
};
