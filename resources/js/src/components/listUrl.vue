<template>
    <div v-if="getShortenUrlsFromStore?.length">
        <h2>Shortened URLs:</h2>
        <ul>
            <li v-for="url in getShortenUrlsFromStore" :key="url.id">{{ url.original_url }} - {{ url.shortened_url }}</li>
        </ul>
    </div>
</template>

<script>
import axios from "axios";
import { mapMutations } from 'vuex';
import { mapGetters } from 'vuex';
export default {
    computed: {
        ...mapGetters(['getShortenUrlsFromStore']),
    },
    created() {
        this.getShortenUrls();
    },
    methods: {
        ...mapMutations(['ADD_SHORTEN_URLS']),
        async getShortenUrls() {
            try {
                const response = await axios.post('/api/get_shorten_urls',  {});
                this.ADD_SHORTEN_URLS(response.data);
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>
