<template>
    <div style="text-align: left">
        <v-card-title style="padding: 0;">
            {{isPicker ? $t('FormBuilder.disabledRange') : $t('FormBuilder.options') }}
            <v-chip
                v-if="!showConditionalLogic"
                color="primary"
                text-color="white"
                small
                dark
                @click="toggleEditingOption">
                <v-icon>add</v-icon>
                {{ $t('FormBuilder.addOption') }}
            </v-chip>
            <v-chip
                class="option-list__logic"
                v-if="!showEditingOption && !showConditionalLogic && !isPicker"
                small
                color="red"
                text-color="white"
                @click="toggleEditingLogic">
                <v-icon>add</v-icon>
                {{ $t('FormBuilder.addLogic') }}
            </v-chip>
        </v-card-title>
        <v-card v-if="!showEditingOption && showConditionalLogic && !isPicker">
            <v-card-text>
                <v-card-title>{{ $t('FormBuilder.editLogic') }}</v-card-title>
                <v-container grid-list-md>
                    <v-flex xs12>
                        <ul>
                            <li v-for="option,n in formField.options" :key="n">
                                <b>{{ option }}</b> <span>{{ $t('FormBuilder.linksTo') }}</span>
                                <v-select
                                    style="display: inline"
                                    clearable
                                    v-model="newLogic[option]"
                                    :items="idWithLabel"
                                    item-text="label"
                                    item-value="value">
                                </v-select>
                            </li>
                        </ul>
                    </v-flex>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click.native="dialogAction(false)">{{ $t('FormBuilder.popupClose') }}</v-btn>
                <v-btn color="blue darken-1" flat @click.native="dialogAction(true)">{{ $t('FormBuilder.popupConfirm') }}</v-btn>
            </v-card-actions>
        </v-card>
        <ul v-else class="option-list" style="padding-left: 45px;" v-for="(option,n) in newOptions" :key="n">
            <li class="option-list__single">
                {{ option }}
                <span class="option-list__remove" v-if="notLastOne" @click="removeOption(option)"><v-icon>delete_outline</v-icon></span>
            </li>
        </ul>

        <ul v-if="showEditingOption" style="padding-left: 45px;">
            <li><v-text-field :label="$t('FormBuilder.addAnother')" v-model="newOptionValue" @keyup.enter="ifPressEnter" append-icon="keyboard_return" :append-icon-cb="ifPressEnter"></v-text-field></li>
        </ul>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex';
    export default {
        props: {
            formField: {
                type: Object,
                required: true
            }
        },
        data () {
            return {
                newLogic: {},
                newOptions: [],
                showConditionalLogic: false,
                showEditingOption: false,
                newOptionValue: null
            }
        },
        computed: {
            ...mapGetters('FormBuilder', [
                'idWithLabel',
            ]),
            notLastOne() {
                if (this.newOptions && this.newOptions.length > 1) {
                    return true;
                }
                return false; 
            },
            isPicker () {
                return this.formField.type === 'datepicker' || this.formField.type === 'timepicker';
            }
        },
        methods: {
            ...mapActions('FormBuilder', [
                'onChangeFormFieldAttribute'
            ]),
            ifPressEnter () {
                this.showEditingOption = false;
                if (!this.newOptionValue) return;
                this.newOptions.push(this.newOptionValue);
                this.newOptionValue = null;
                this.pushOptionToCloud();
            },
            removeOption (item) {
                this.newOptions.splice(this.newOptions.indexOf(item), 1);
                this.newOptions = [...this.newOptions];
                this.pushOptionToCloud();
            },
            pushOptionToCloud () {
                if (this.isPicker) {
                    this.onChangeFormFieldAttribute({
                        id: this.formField.id,
                        key: 'constraint',
                        value: this.newOptions
                    });
                } else {
                    this.onChangeFormFieldAttribute({
                        id: this.formField.id,
                        key: 'options',
                        value: this.newOptions
                    });
                }
            },
            toggleEditingOption () {
                this.showEditingOption = !this.showEditingOption;
                return this.showEditingOption;
            },
            toggleEditingLogic () {
                this.showConditionalLogic = !this.showConditionalLogic;
                return this.showConditionalLogic;

            },
            dialogAction (action) {
                if (action) {
                    this.onChangeFormFieldAttribute({
                        id: this.formField.id,
                        key: 'logic',
                        value: this.newLogic
                    });
                }
                this.newLogic =  {};
                this.showConditionalLogic = false;
            }
        },
        mounted () {
            if (this.isPicker) {
                this.newOptions = this.formField.constraint ? this.formField.constraint : [];
            } else {
                this.newOptions = this.formField.options ? this.formField.options : [];
                if (this.formField.logic) {
                    this.newLogic = this.formField.logic ? this.formField.logic : {};
                }
            }
        }
    }
</script>

<style lang="scss">
    /* Enter and leave animations can use different */
    /* durations and timing functions.              */
    .slide-fade-enter-active {
        transition: all .3s ease;
    }
    .slide-fade-leave-active {
        transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
        /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(10px);
        opacity: 0;
    }
    .option-list {
        &__remove {
            display: none;
        }

        &__single {
            min-height: 25px;
            &:hover {
                padding-right: 5px;
                .option-list__remove {
                    display: inline-block;
                }
            }
        }
    }
</style>
