<template>
    <v-container fluid grid-list-md class="no-show-in-small-device">
        <v-layout pt-3 pb-3>
            <v-flex xs3>
                <div class="headline">{{ $t('FormBuilder.formListLabel') }}</div>
            </v-flex>
            <v-flex xs7></v-flex>
            <v-flex xs1 >
                <v-btn round color="primary" @click="goToCreatedForm">
                    <v-icon>add</v-icon>{{ $t('FormBuilder.createNewFormLabel') }}
                </v-btn>
            </v-flex>
            <v-flex xs1></v-flex>
        </v-layout>

        <v-divider></v-divider>

        <v-layout row wrap pt-3>
            <v-flex xs10 offset-xs1 style="background-color: #8eb4cb">
                <ui-forms-filter></ui-forms-filter>
            </v-flex>
        </v-layout>
        <v-layout row wrap pt-2 v-if="!isLoading">
             <v-flex d-flex v-for="form in forms" :key="form.id" xs12 md6 lg4 xl3 pa-3 class="scrolling-wrapper">
                <ui-form-card :form="form" class="card"></ui-form-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import { mapActions } from 'vuex';
    export default {
        data () {
            return {
                isLoading: true,
                isOnHover: false,
                forms: []
            }
        },
        mounted () {
            this.isLoading = true;
            this.$api.getRoute('backend.form.list').then(response => {
                this.isLoading = false;
                this.forms = response.data.data;
            }).catch(error => {
                this.$toasted.error('Cannot find any available forms');
            });
        },
        methods: {
            ...mapActions('FormBuilder', [
                'clearFormBuilder'
            ]),
            goToCreatedForm () {
                this.clearFormBuilder();
                this.$router.push({name: 'admin.form.builder'});
            }
        }
    }
</script>

<style lang="scss" scoped>
    .scrolling-wrapper-flexbox {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;

      .card {
        flex: 0 0 auto;
      }
    }
    .no-show-in-small-device {
    }
</style>
