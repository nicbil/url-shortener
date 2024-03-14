<template>
    <div class="main">
        <AddUrlShortener />
        <ListUrl/>
    </div>
</template>

<script lang="ts">
	import { defineComponent } from 'vue';
	import AddUrlShortener from './components/addUrlShortener.vue';
    import ListUrl from './components/listUrl.vue';

	export default defineComponent({
		components: {
            AddUrlShortener,
            ListUrl
		},
	});
</script>

<style lang="less" scoped>
	.main {
		width: 992px;
		margin: 0 auto;
		padding: 40px;
	}
</style>
