import Vue from 'vue'

export default{
    /**
     * storing list of existing forms
     */
    namespaced: true,

    state: {
        events: {},
        newEvent: {
            form_name: null,
            form_id: null,
            has_payment: false,
            payment: {
                amount: null,
                description: null,
            },
            fields: {}
        }
    },

    getters: {

        /**
         * Get current event values
         * @param state
         * @returns {{has_payment: boolean, payment: {amount: null, description: null}, fields: {}}|newEvent|{has_payment, payment, fields}}
         */
        getCurrentEventFields (state) {
            return state.newEvent;
        },
    },

    mutations:{
        /**
         * Sync event information
         * @param state
         * @param payment
         */
        onUpdateEventInfo(state, data) {
            state.newEvent.form_name = data.form_name;
            state.newEvent.form_id = data.form_id;
            state.newEvent.has_payment = data.has_payment;
            if (data.has_payment) {
                state.newEvent.payment.amount = data.amount;
                state.newEvent.payment.description = data.description;
            } else {
                state.newEvent.has_payment = false;
            }
        },

        /**
         * Sync single event field while page loading
         * @param state
         * @param uuid
         * @param data
         */
        onCreateNewField(state, {uuid, data}) {
            state.newEvent.fields[uuid] = data;
            // console.log('vuex sync event fields: ', state.newEvent.fields[field_id]);
        },

        /**
         * Update event fields values, triggered by submit button
         * @param state
         * @param field
         * @param uuid
         */
        onPushFieldValue(state, {val, uuid}) {
            state.newEvent.fields[uuid].field_value = val;
        }
    },

    actions: {

        /**
         * Get all available events
         * @param state
         */
        getAllEventsRequest ({state}) {
            Vue.$api.getRoute('events.get').then(function (response) {
                state.events = response.data;
            })
        },

        /**
         * request called when page loading
         * @param commit
         * @param data
         */
        syncEventBasicDetailRequest ({commit}, {data}) {
            commit('onUpdateEventInfo', {
                form_name: data.form_name,
                form_id: data.id,
                has_payment: data.has_payment,
                amount: data.payment.amount,
                description: data.payment.description,
            })
        },
        /**
         * Request that creates event field
         * @param commit
         * @param field
         */
        createNewEventFieldRequest ({commit}, {field}) {
            commit('onCreateNewField', {
                uuid: field.id,
                data: {
                    dirty: false,
                    type: field.type,
                    field_value: null,
                    field_label: field.label,
                    required: field.required,
                    instruction: field.instruction,
                    form_field_id:  field.field_id,
                    allow_markdown: field.allow_markdown,
                },
            })
        },

        /**
         * Request that update all events values
         * @param state
         * @param commit
         * @param fields
         * @returns {boolean}
         * @constructor
         */
        UpdateEventFieldsRequest({state, commit}, {fields}) {
            if (!fields || _.keys(fields).length <= 0) {
                return false;
            }
            for (let i in state.newEvent.fields) {
                if (fields[i] && state.newEvent.fields[i]) {
                    commit('onPushFieldValue', {
                        val: fields[i].field_value,
                        uuid: i
                    });
                } else {
                    console.log('error, unknown field id: ' + i);
                    return false;
                }
            }
            return true;
        }
    }
}
