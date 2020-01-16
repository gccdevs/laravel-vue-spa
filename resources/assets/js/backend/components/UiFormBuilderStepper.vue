<template>
	<div class="stepper">
		<v-stepper v-model="currentStep" vertical>
			<v-stepper-step :complete="currentStep > 1" step="1" editable :rules="[rules.validateStep1]">
				{{ $t('FormBuilder.step1') }}
				<small>{{ $t('FormBuilder.step1Title') }}</small>
			</v-stepper-step>

			<v-stepper-content step="1">
				<ui-create-form-basic-fields @info-error="hasInfoError"></ui-create-form-basic-fields>
				<v-btn color="primary" @click="nextStep(1)">{{ $t('FormBuilder.continueLabel') }}</v-btn>
				<v-btn flat color="error" @click="onRestart">{{ $t('FormBuilder.restartLabel') }}</v-btn>
			</v-stepper-content>

			<v-stepper-step :complete="currentStep > 2" step="2" :rules="[rules.validateStep2]">
				{{ $t('FormBuilder.step2') }}
				<small>{{ $t('FormBuilder.step2Title') }}</small>
			</v-stepper-step>

			<v-stepper-content step="2">
				<v-layout row class="form-builder-panel">
					<v-flex xs12 md12 lg2 xl3>
						<ui-field-options id="myHeader" v-if="currentStep === 2"></ui-field-options>
					</v-flex>
					<v-flex xs12 md12 lg10 xl9>
						<ui-selected-form-modules @step-error="hasFieldError"></ui-selected-form-modules>
					</v-flex>
				</v-layout>
				<v-divider></v-divider>
				<v-btn color="primary" @click="nextStep(2)">{{ $t('FormBuilder.continueLabel') }}</v-btn>
				<v-btn flat color="error" @click="onRestart">{{ $t('FormBuilder.restartLabel') }}</v-btn>
			</v-stepper-content>

			<v-stepper-step :complete="currentStep > 3" step="3">
				{{ $t('FormBuilder.step3') }}
				<small>{{ $t('FormBuilder.step3Title') }}</small>
			</v-stepper-step>

			<v-stepper-content step="3">
				<v-layout row wrap>
					<v-flex xs12>
						<ui-form-payment></ui-form-payment>
					</v-flex>
					<v-flex xs12>
						<ui-form-builder-actions :hasError="hasFormInfoError || hasFormFieldError" :submitType="'EDIT'" @saved="saved"></ui-form-builder-actions>
					</v-flex>
				</v-layout>
				<v-divider></v-divider>
				<v-btn color="primary" @click="nextStep(3)"><v-icon>arrow_back</v-icon>{{ $t('FormBuilder.goBackLabel') }}</v-btn>
				<v-btn flat color="error" @click="onRestart">{{ $t('FormBuilder.restartLabel') }}</v-btn>
			</v-stepper-content>
		</v-stepper>
	</div>
</template>

<script>
	import { mapState, mapActions, mapGetters } from 'vuex';
	export default {
		data () {
			return {
				currentStep : 1,
				hasFormInfoError: false,
				hasFormFieldError: false,
				rules: {
					validateStep1: value => {
						return this.hasFormInfoError ? false : true;
					},
					validateStep2: value => {
						return this.hasFormFieldError ? false : true;
					}
				}
			}
		},
		computed: {
			...mapState('FormBuilder', [
				'currentFormBuilder',
				]),
			...mapGetters('FormBuilder', [
				'hasDateTimeError',
				]),
		},
		methods: {
			...mapActions('FormBuilder', [
				'onChangeFormBuilderAttribute',
				]),
			hasInfoError (val) {
				if (val) {
					this.hasFormInfoError = true;
				} else {
					this.hasFormInfoError = false;            		
				}
			},
			hasFieldError (val) {
				if (val) {
					this.hasFormFieldError = true;
				} else {
					this.hasFormFieldError = false;            		
				}
			},
			saved () {
				this.$router.push({name: 'admin.form.list'});
				this.$toasted.success('修改成功', {
					icon: 'done_all'
				});
			},
			nextStep (currentStep) {
				if (currentStep === 1) {
					this.currentStep = 2;
				} else if (currentStep === 2) {
					this.currentStep = 3;
				} else if (currentStep === 3) {
					this.currentStep = 2;
				} else {
					this.currentStep = 1;
				}
			},
			onRestart () {
				this.currentStep = 1;
				this.hasFormFieldError = false;
				this.hasFormInfoError = false;
				this.$store.dispatch('FormBuilder/clearFormBuilder').then(response => {
					this.$toasted.success('Restart form builder', {
						icon: 'repeat_one'
					});
				});
			}
		},
	}
</script>

<style lang="scss">

</style>
