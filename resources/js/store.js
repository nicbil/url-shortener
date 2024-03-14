import { createStore } from 'vuex';

export default createStore({
    state() {
        return {
            shortenUrls: []
        };
    },
    mutations: {
        ADD_SHORTEN_URLS(state, shortenUrls) {
            state.shortenUrls = shortenUrls;
        },
        ADD_SHORTEN_URL(state, shortenUrl) {
            state.shortenUrls.push(shortenUrl);
        }
    },
    getters: {
        getShortenUrlsFromStore: state => {
            return state.shortenUrls;
        },
    }
});
