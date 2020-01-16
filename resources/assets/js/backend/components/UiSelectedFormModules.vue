<template>
    <v-layout row wrap>
        <v-flex xs12 v-if="currentFormBuilder">
            <v-container v-if="currentFormBuilder" text-xs-center justify-center>
                <v-layout row wrap justify-center v-if="currentFormBuilder.form_fields">
                    <draggable
                        v-model="currentFormBuilder.form_fields"
                        :options="dragOptions"
                        :style="{ display: 'block' }" class="drag-wrapper"
                        @start="isDragging=true"
                        @end="isDragging=false">
                        <transition-group
                            name="custom-classes-transition"
                            enter-active-class="bounce-enter-active"
                            leave-active-class="animated bounceOutRight">
                            <ui-form-fields
                                :formField="formField"
                                @edit="editFormField"
                                @input-error="updateFieldError"
                                style="width: initial;padding-bottom: 20px;"
                                v-for="formField,n in currentFormBuilder.form_fields"
                                :key="formField.id">
                            </ui-form-fields>
                        </transition-group>
                    </draggable>
                </v-layout>
            </v-container>
            <div v-else>
            <span>
                Loading...
            </span>
            </div>
        </v-flex>
    </v-layout>
</template>

<script>
    import draggable from 'vuedraggable';
    import { mapState, mapActions } from 'vuex';
    export default {
        data () {
            return {
                isDragging: false,
                errorCount: 0,
            }
        },
        components: {
            draggable
        },
        computed: {
            ...mapState('FormBuilder', [
                'currentFormBuilder'
            ]),
            dragOptions () {
                return {
                    group: 'form_fields',
                    animation: 100
                }
            }
        },
        watch: {
          currentFormBuilder () {
              if (this.currentFormBuilder.form_fields && this.currentFormBuilder.form_fields.length - 1 > 0) {
                  let newCard = this.currentFormBuilder.form_fields[this.currentFormBuilder.form_fields.length - 1];
                  // let elmnt = document.getElementById(newCard.id);
                  // elmnt.scrollIntoView();
              }
          }
        },
        methods: {
            ...mapActions('FormBuilder', [
                'SaveNewFormFields'
            ]),
            updateFieldError (val) {
                if (val) {
                    this.errorCount += 1;
                } else {
                    this.errorCount -= 1;
                }
                if (this.errorCount < 0) {
                    this.errorCount = 0;
                }
                console.log(val,this.errorCount);
                if (this.errorCount > 0) {
                    this.$emit('step-error', true);
                } else {
                    this.$emit('step-error', false);                    
                }
            },
            editFormField (formData) {
                for (let i = 0; i < this.currentFormBuilder.form_fields.length; i++) {
                    if (this.currentFormBuilder.form_fields[i].id === formData.id) {
                        this.currentFormBuilder.form_fields[i] = formData;
                        this.SaveNewFormFields({form_fields: this.currentFormBuilder.form_fields});
                        return;
                    }
                }
            },
            saveFieldOptions () {
                this.$emit('onSubmit');
            }
        },
        mounted () {
        }
    }
</script>

<style>
    .bounce-enter-active {
        animation: bounce-in .5s;
    }
    @keyframes bounce-in {
        0% {
            transform: scale(0);
        }
        50% {
            transform: scale(1.5);
        }
        100% {
            transform: scale(1);
        }
    }
</style>