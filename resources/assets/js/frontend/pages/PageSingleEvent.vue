<template>
	<div>
        <ba-page-logo></ba-page-logo>
        <ba-single-event v-if="!isLoading && form" :form="form"></ba-single-event>
        <div class="pageloader" v-else><span class="loader-title">Loading</span></div>
	</div>
</template>

<script>
    export default {
        data () {
            return {
                form: null,
                isLoading: true
            }
        },
        mounted () {
            if (this.$route.params.event) {
                this.$api.getRoute('event.single', {event: this.$route.params.event}).then(response => {
                    this.form = response.data.data;
                    this.isLoading = false;
                }).catch(err => {
                    this.isLoading = false;
                    this.$toasted.error('Failed to retrieve the request form');
                    console.log(err);
                    this.$router.push({name: 'events.home'});
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
	@import "~bulma-pageloader";
	@import '~frontend_variables';
	.all {
		width: 100vw;
		height: 100vh;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: $brand-primary;
	}
</style>
