import Vue from 'vue';
import { each, findIndex, omit, find } from 'lodash';
import moment from 'moment';
import { compareDateError } from 'backendUtils/CompareDateTime';
import { compareDateTimeError } from 'backendUtils/CompareDateTime';

let blankFormBuilder = {
    contact_person: '',
    contact_number: '',
    is_upload_file: false,
    banner_link: '',
    form_banner: '',
    form_banner_name: '',
    form_name: '',
    form_description: '',
    start_date: moment(new Date()).format('YYYY-MM-DD'),
    expired_date: moment(new Date()).add(1,'days').format('YYYY-MM-DD'),
    start_time: "08:00",
    expired_time: "20:00",
    is_draft: false,
    last_modified: null,
    last_modify_user_id: '',
    form_fields: [],
    has_payment: false,
    payment: {
        amount: 0.00,
        description: null,
        coupon: [],
    }
};

export default {
    // create a new form
    namespaced: true,

    state: {
        currentFormBuilder: blankFormBuilder
    },

    mutations: {
       /**
        * Set form field attribute
        */
        setFormFieldAttribute (state, {id, key, value}) {
            let formFields = state.currentFormBuilder.form_fields;
            for (let i in formFields) {
                if (formFields[i].id === id) {
                    state.currentFormBuilder.form_fields[i][key] = value;
                    let currentFormBuilder = state.currentFormBuilder;
                    Vue.$storage.set('current_form_builder', {currentFormBuilder});
                    return true;
                }
            }
            return false;
        },
       /**
        * Set form builder attribute
        */
        setFormBuilderAttribute (state, {key, value}) {
            if (key !== 'form_fields') {
                state.currentFormBuilder[key] = value;
                let currentFormBuilder = state.currentFormBuilder;
                Vue.$storage.set('current_form_builder', {currentFormBuilder});
                return true;
            }
            return false;
        },
       /**
        * Push a new field to stack
        */
        setNewFormField (state, {form_field}) {
            state.currentFormBuilder.form_fields.push(form_field);
            let currentFormBuilder = state.currentFormBuilder;
            Vue.$storage.set('current_form_builder', {currentFormBuilder});
        },
        /**
         * Sync vue local storage data if exists
         * @param state
         * @param formData
         */
        syncFormBuilder(state, formData) {
            if (formData.currentFormBuilder) {
                state.currentFormBuilder = formData.currentFormBuilder;
                console.log('synced: ', state.currentFormBuilder);
            }
        },
        /**
         * Clean vuex and vue local storage
         * @param state
         */
        cleanFormBuilder (state) {
            state.currentFormBuilder.form_fields = [];
            state.currentFormBuilder.form_banner = '';
            state.currentFormBuilder.form_banner_name = '';
            state.currentFormBuilder.form_banner_link = '';
            state.currentFormBuilder.form_name = '';
            state.currentFormBuilder.contact_person = '';
            state.currentFormBuilder.contact_number = '';
            state.currentFormBuilder.form_description = '';
            state.currentFormBuilder.is_upload_file = true;
            state.currentFormBuilder.has_payment = false;
            state.currentFormBuilder.start_date = moment(new Date()).format('YYYY-MM-DD');
            state.currentFormBuilder.expired_date = moment(new Date()).add(1,'days').format('YYYY-MM-DD');
            state.currentFormBuilder.start_time = "08:00";
            state.currentFormBuilder.expired_time = "20:00";

            state.currentFormBuilder.payment = {
                amount: null,
                description: null,
                coupon: []
            };
            delete state.currentFormBuilder;
            state.currentFormBuilder = blankFormBuilder;
            let currentFormBuilder = state.currentFormBuilder;
            Vue.$storage.set('current_form_builder', {currentFormBuilder});
        },
        /**
         * Remove one form field from form builder
         * @param state
         * @param formData
         */
        removeField(state, {form_field}) {
            let formFields = state.currentFormBuilder.form_fields;
            let currentFormBuilder = state.currentFormBuilder;
            for (let i in formFields) {
                if (formFields[i].id === form_field.id) {
                    state.currentFormBuilder.form_fields.splice(i, 1);
                    // state.currentFormBuilder.form_fields = [...state.currentFormBuilder.form_fields];
                    Vue.$storage.set('current_form_builder', {currentFormBuilder});
                    return true;
                }
            }
            return false;
        }
    },

    getters: {
        idWithLabel (state) {
            let ids = [];
            let idList = state.currentFormBuilder.form_fields;
            for (let i = 0; i< idList.length; i++) {
                ids.push({
                    label: idList[i].label,
                    value: idList[i].id
                });
            }
            return ids;
        },
        hasDateError (state) {
            return compareDateError(state.currentFormBuilder.start_date, state.currentFormBuilder.expired_date);
        },
        hasDateTimeError (state) {
            return compareDateTimeError(state.currentFormBuilder.start_date, state.currentFormBuilder.start_time, state.currentFormBuilder.expired_date, state.currentFormBuilder.expired_time);
        }
    },

    actions: {
       /**
        * Change form field attributes
        */
        onChangeFormFieldAttribute ({commit}, {id, key, value}) {
            commit('setFormFieldAttribute', {id, key, value});
        },
       /**
        * Change form builder attribute
        */
        onChangeFormBuilderAttribute ({commit}, {key, value}) {
            console.log(key, value)
            commit('setFormBuilderAttribute', {key, value});
        },
        /**
         * handle new adding form field request
         * @param state
         * @param formData
         */
        pushFormField({commit}, {form_field}) {
            commit('setNewFormField', {form_field});
        },
        /*
        * Handles form field remove request
        * @param commit
        * @param form_field
        */
        removeFormField({commit}, {form_field}) {
            commit('removeField', {form_field})
        },
        /**
         * Vue local storage, triggered when loading page
         * @param commit
         * @param values
         */
        batchUpdate({commit}, values) {
            console.log('updating forms.');
            commit('syncFormBuilder', values);
        },
        /**
         * Clear vue local storage
         * @param commit
         */
        clearFormBuilder({commit}) {
            commit('cleanFormBuilder');
        }
    }
}
