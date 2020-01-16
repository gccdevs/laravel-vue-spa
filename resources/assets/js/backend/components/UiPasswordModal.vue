<template>
	<v-dialog
	  v-model="shouldShow"
	  persistent
	  :overlay="true"
	  max-width="500px"
	  transition="dialog-transition">
  	  <v-card style="padding: 30px;">
      	<v-card-title class="headline">更改密码</v-card-title>

        	<v-card-text>
    		<v-text-field
    		  name="Password"
    		  label="密码"
              :append-icon="show1 ? 'visibility_off' : 'visibility'"
              :type="show1 ? 'text' : 'password'"
    		  v-model="newPassword"
              :rules="[rules.required, rules.counter]"        		  
    		  hint="最少8位"
     		  counter
	          @click:append="show1 = !show1"		  
    		></v-text-field>
    		<v-text-field
    		  name="Password Confirmation"
    		  label="密码确认"
              :append-icon="show2 ? 'visibility_off' : 'visibility'"
    		  type="password"
    		  counter
              :rules="[rules.required, rules.passwordMatch, rules.counter]"        		  
    		  v-model="passwordConfirm"
	          @click:append="show2 = !show2"
    		></v-text-field>    	    
    		<input type="hidden" name="honeyss" v-model="honey">
    	    </v-card-text>

        	<v-card-actions>
	          <v-spacer></v-spacer>
    	      <v-btn
      	        color="error"
      	        flat
      	        :loading="isLoading"
        	    @click="onSubmit">
	            提交
        	  </v-btn>
    	      <v-btn
    	        color="primary"
        	    @click="onCancel">
	            取消
        	  </v-btn>
	      </v-card-actions>
	  </v-card>
	</v-dialog>
</template>

<script>
	export default {
		data () {
			return {
				honey: null,
				isLoading: false,
				show1: false,
				show2: false,
                rules: {
                    required: value => !!value || this.$t('FormBuilder.required'),
                    counter: value => value.length >= 8 || '最少八位字符',
                    passwordMatch:(value) => value && value === this.newPassword || '密码不对应'
                },
				newPassword: '',
				passwordConfirm: '',
				shouldShow: false,
			}
		},
		props: {
			dialog: {
				props: Boolean,
				required: true
			}
		},
		watch: {
			dialog (val) {
				if (val) {
					this.shouldShow = true;
				}
			}
		},
		computed: {
		},
		methods: {
			onCancel () {
				this.$emit('close');
				this.passwordConfirm = '';
				this.newPassword = '';
				this.shouldShow = false;
			},
			onSubmit () {
				if (!this.newPassword || this.newPassword !== this.passwordConfirm) {
					return;
				}
				this.isLoading = true;
				let data = {
					honey: this.honey,
					password: this.newPassword
				}
				this.$api.postRoute('backend.password.change', {}, data).then(response => {
					this.isLoading = false;
					this.passwordConfirm = '';
					this.newPassword = '';
					this.$toasted.success('修改成功');
				}).catch(err => {
					this.isLoading = false;
					this.passwordConfirm = '';
					this.newPassword = '';
					this.$toasted.error('修改失败： ' + err.response.message);
				});
				this.$emit('close');
				this.shouldShow = false;				
			}
		},
		created () {
			this.shouldShow = this.dialog;
		}
	}
</script>

<style lang="scss">
	
</style>