<template>
    <form @submit.prevent="shortenUrl">
        <input type="url" v-model="url" placeholder="Enter URL" required>
        <button>Add shorten URL</button>
    </form>
</template>

<script>
import axios from "axios";
import {mapMutations} from "vuex";
export default {
    data() {
        return {
            url: 'https://bilenko.com',
        };
    },
    methods: {
        ...mapMutations(['ADD_SHORTEN_URL']),
        async shortenUrl() {
            try {
                const response = await axios.post('/api/add_url', { url: this.url });
                if (response.data.url) {
                    console.warn(response.data.url +' - '+ response.data.message)
                } else {
                    this.ADD_SHORTEN_URL(response.data);
                }
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
